<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.level:2');
    }

    //ดึงข้อมูล เเละ ค้นหาข้อมล
    public function index(Request $request){
        $search = $request->search;
        $products = Product::where(function ($query) use ($search){
            $query->where('barcode', 'like', '%' . $search . '%')
                  ->orWhere('name', 'like', '%' . $search . '%')
                  ->orWhere('type', 'like', '%' . $search . '%')
                  ->orWhere('point', 'like', '%' . $search . '%');
        })
        ->paginate(10);
        return view('admin.products', compact('products','search'));
    }

    //ลบข้อมูลตามID
    public function destroy($id){
        $products = Product::findOrFail($id);
        $products->delete();

        return redirect()->route('products')->with('success', 'Product delete successfully!');
    }

    //อัปเดข้อมูล
    public function update(Request $request, $id){
        $request->validate([
            'barcode' => 'required',
            'name' => 'required',
            'type' => 'required',
            'point' => 'required',
        ]);

        $products = Product::findOrFail($id);

        $products->barcode = $request->barcode;
        $products->name = $request->name;
        $products->type = $request->type;
        $products->point = $request->point;

        $products->save();

        return redirect()->route('products')->with('success', 'Product update successfully.');

    }

    //เพิ่มข้อมูล
    public function store(Request $request){
       
        $request->validate([
            'barcode' => 'required|unique:products,barcode',
            'name' => 'required',
            'type' => 'required',
            'point' => 'required',
        ],[
            'barcode.unique' => 'The barcode has already been taken.',
        ]);

        Product::create([
            'barcode' => $request->input('barcode'),
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'point' => $request->input('point'),
        ]);

        return redirect()->back()->with('success','Product Create Successfully.');
    }
}   
