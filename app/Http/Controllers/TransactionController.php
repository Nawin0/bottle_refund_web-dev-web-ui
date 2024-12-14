<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Member;
use App\Models\Logpoint;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware('check.level:2');
    }

    //ดึงข้อมูล เเละค้นหา
    public function index(Request $request){
        $search = $request->search;
        $transactions = Transaction::where(function ($query) use ($search){
            $query->where('machine_id', 'like', '%' . $search . '%')
                  ->orWhere('phone_no', 'like', '%' . $search . '%')
                  ->orWhere('barcode', 'like', '%' . $search . '%')
                  ->orWhere('flag', 'like', '%' . $search . '%');
        })
        ->paginate(10);
        return view('admin.transactions', compact('transactions','search'));
    }  

    //ยืนยันให้คะเเนน
    public function approve($id){
        $transactions = Transaction::find($id);
        if ($transactions) {
            $product = Product::where('barcode', $transactions->barcode)->first();

            if ($product){
                $member = Member::where('phone_no', $transactions->phone_no)->first();

                if ($member) {
                    $member->current_point += $product->point;
                    $member->save();

                    Logpoint::create([
                        'phone_no' => $transactions->phone_no,
                        'barcode' => $transactions->barcode,
                        'point' => $product->point,
                    ]);
                }
            }

            $transactions->update([
                'flag' => '2',
                'image64' => '0',
            ]);
        }

        return redirect('/transactions');
    }

    //ไม่ให้คะเเนน
    public function reject($id){
        $transactions = Transaction::find($id);
        $data = [
            'flag' => '3',
        ];
        $transactions->update($data);
        return redirect('/transactions');
    }
}
