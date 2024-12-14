<?php

namespace App\Http\Controllers;

use App\Models\RewardItem;
use Illuminate\Http\Request;

class RewardItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.level:2');
    }

    //ดึงข้อมูล เเละ ค้นหาข้อมล
    public function index(Request $request){
        $search = $request->search;
        $rewarditems = RewardItem::where(function ($query) use ($search){
            $query->where('product_reward', 'like', '%' . $search . '%')
                  ->orWhere('stock', 'like', '%' . $search . '%')
                  ->orWhere('point', 'like', '%' . $search . '%')
                  ->orWhere('status', 'like', '%' . $search . '%');
        })
        ->paginate(10);
        return view('admin.rewarditems', compact('rewarditems','search'));
    }

    //ลบข้อมูลตามID
    public function destroy($id){
        $rewarditems = RewardItem::findOrFail($id);
        $rewarditems->delete();

        return redirect()->route('rewarditems')->with('success', 'Rewarditems delete successfully!');
    }

    //อัปเดข้อมูล
    public function update(Request $request, $id){
        $request->validate([
            'product_reward' => 'required',
            'stock' => 'required',
            'point' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $rewarditems = RewardItem::findOrFail($id);

        $rewarditems->product_reward = $request->product_reward;
        $rewarditems->stock = $request->stock;
        $rewarditems->point = $request->point;
        
        if ($request->hasFile('image')) {
            $image = $request->File('image');
            $imageBase64 = base64_encode(file_get_contents($image));
            $rewarditems->image = $imageBase64;
        }

        $rewarditems->save();

        return redirect()->route('rewarditems')->with('success', 'Rewarditems update successfully.');

    }

    //เพิ่มข้อมูล
    public function store(Request $request){
        $request->validate([
            'product_reward' => 'required|unique:reward_items,product_reward',
            'details' => 'required',
            'stock' => 'required',
            'point' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],[
            'product_reward.unique' => 'The Product-Reward has already been taken.',
        ]);

        $image = $request->file('image');
        $imageBase64 = base64_encode(file_get_contents($image));

        $rewarditems = RewardItem::create([
            'product_code' => uniqid('PR-'),
            'product_reward' => $request->input('product_reward'),
            'details' => $request->input('details'),
            'stock' => $request->input('stock'),
            'point' => $request->input('point'),
            'image' => $imageBase64,
        ]);
        $rewarditems->update([
            'product_code' => 'PR-' .str_pad($rewarditems->id,10,'0',STR_PAD_LEFT)
        ]);
        
        return redirect()->back()->with('success','Product-Reward Create Successfully.');
    }

    public function updateStatus(Request $request, $id){
        $status = $request->input('status');
        $rewarditems = RewardItem::find($id);
        $rewarditems->status = $status;
        $rewarditems->save();

        return reponse()->json(['message' => 'Status updated successfully']);
    }
}
