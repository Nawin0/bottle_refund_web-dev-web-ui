<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Logpoint;
use App\Models\Member;
use App\Models\RewardItem;
use App\Models\Address;
use App\Models\Exchang_History;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserpageController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.level:1');
    }

    //My Point Function
    public function point_user($id) {
        $member = Member::find($id);
        $pointuser = Logpoint::where('phone_no', $member->phone_no)
            ->orderBy('created_date', 'desc')
            ->paginate(5);

        $pointuser->each(function ($item) {
            $product = Product::where('barcode', $item->barcode)->first();
            if ($product) {
                $item->product = $product;

                $transaction = Transaction::where('barcode', $item->barcode)->first();
                if ($transaction) {
                    $item->flag = $transaction->flag;
                }
            }
            $exchang = RewardItem::where('product_code', $item->barcode)->first();
            if ($exchang) {
                $item->exchang = $exchang;
            }
        });

        return view("user.mypoint", compact('member', 'pointuser'));
    }

    //Exchang_History Function
    public function exchang_history_user($id) {
        $member = Member::find($id);
        $exchang = Exchang_History::where('phone_no', $member->phone_no)
            ->orderBy('created_at', 'desc')
            ->paginate(5);
            $exchang->each(function ($item) {
                $reward = RewardItem::where('product_code', $item->product_code)->first();
                if ($reward) {
                    $item->reward = $reward;
                }
            });
        return view("user.history_reward", compact('member', 'exchang'));
    }

    //Rewards User  Function
    public function reward_user(Request $request){
        $search = $request->search;
        $member = auth()->user();
        $addresses = Address::where('phone_no', $member->phone_no)
        ->orderByRaw("CASE WHEN status = 2 THEN 0 ELSE 1 END")
        ->get()
        ->mapWithKeys(function ($address) {
            $label = $address->status == 2 ? "{$address->address} (ที่อยู่เริ่มต้น)" : $address->address;
            return [$address->id => $label];
        });

        $rewards = RewardItem::where(function ($query) use ($search){
            $query->where('product_reward', 'like', '%' . $search . '%')
                  ->orWhere('point', 'like', '%' . $search . '%');
        })
        ->paginate(5);
        return view('user.reward', compact('rewards','search','addresses'));
    }

    //Member Profile Function
    public function member_user($id){
        $member = Member::find($id);
        $address = Address::where('phone_no', $member->phone_no)->paginate(2);

        return view("user.profile", compact('member', 'address'));
    }

    // News
    public function news()
    {
        $news = News::latest()->paginate(6);
        return view("user.new", compact('news'));
    }

    public function detail_new($id){
        $news = News::findOrFail($id);
        return view('user.detail_new', compact('news'));
    }

    //Edit Profile Users
   public function edit_profile(Request $request ,$id){
    $request->validate([
        'name'=>'required',
        'email' => 'required|email|unique:members,email,' . $id,
        'phone_no' => 'required',
    ]);

    $member = Member::findOrfail($id);

    $member->name = $request->name;
    $member->email = $request->email;
    $member->phone_no = $request->phone_no;
    $member->save();

    return back()->with('success', 'Profile has been updated.');
   }

   public function add_address(Request $request){
    $request->validate([
        'address' => 'required',
    ]);

    $member = auth()->user();

    Address::create([
        'address' => $request->input('address'),
        'phone_no' => $member->phone_no,
    ]);

    return redirect()->back()->with('success','Address Create Successfully.');
   }

   public function update_address(Request $request, $id){
        $request->validate([
            'address' => 'required',
        ]);

        $address = Address::findOrFail($id);
        $address->update([
            'address'=> $request->address,
        ]);

        return redirect()->back()->with('success', 'Address updated successfully.');
   }

   public function delete_address($id){
    $address = Address::findOrFail($id);
    $address->delete();

    return redirect()->back()->with('success', 'Address deleted successfully.');
   }

   public function setAddressDefault($id){
        $address = Address::find($id);

        if ($address) {
            $address->status = 2;
            $address->save();

            Address::where('phone_no', $address->phone_no)
                ->where('id', '!=', $id)
                ->update(['status' => 1]);

            return redirect()->back()->with('success', 'Address set as default!');
        }

        return redirect()->back()->with('error', 'Address not found!');
    }

    public function exchange_add(Request $request){
        $request->validate([
            'phone_no' => 'required',
            'product_code' => 'required',
            'point' => 'required',
            'image' => 'required',
            'quantity' => 'required',
            'address' => 'required',
        ],
        [
            'address.required' => 'Please select an address.',
        ]
        );

        $member = Member::where('phone_no', $request->phone_no)->first();
        if (!$member) {
            return redirect()->back()->with('error', 'Member not found.');
        }

        $reward = RewardItem::where('product_code', $request->product_code)->first();
        if (!$reward) {
            return redirect()->back()->with('error', 'Reward item not found.');
        }

        if ($member->current_point < $request->point) {
            return redirect()->back()->with('error', 'Not enough points.');
        }

        if ($reward->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Not enough stock.');
        }

        Exchang_History::create([
            'phone_no' => $request->input('phone_no'),
            'product_code' => $request->input('product_code'),
            'point' => $request->input('point'),
            'image64' => $request->input('image'),
            'quantity' => $request->input('quantity'),
            'address' => $request->input('address'),
        ]);

        Logpoint::create([
            'phone_no' =>  $request->input('phone_no'),
            'barcode' =>  $request->input('product_code'),
            'point' =>  $request->input('point'),
        ]);

        $member->current_point -= $request->point;
        $member->save();

        $reward->stock -= $request->quantity;
        $reward->save();

        return redirect()->back()->with('success','Successfully exchanged items');
    }
}
