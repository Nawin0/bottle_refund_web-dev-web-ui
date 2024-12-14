<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewController extends Controller
{
    public function __construct(){
        $this->middleware('check.level:2');
    }

    // ค้นหา เเละ ดึงข้อมูล
    public function index(Request $request){
        $search = $request->search;
        $news = News::where(function ($query) use ($search){
            $query->where('heading', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
        })
        ->paginate(10);

        return view('admin.news', compact('news', 'search'));
    }

    // ลบข้อมูล
    public function destroy($id){
        $news = News::findOrFail($id);
        $news->delete();

        return redirect()->route('news')->with('success', 'News delete successfully!');
    }

    // อัปเดตข้อมูล
    public function update(Request $request, $id){
        $request->validate([
            'heading' => 'required',
            'content' => 'required',
            'image64' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $news = News::findOrFail($id);

        $news->heading = $request->heading;
        $news->content = $request->content;
        
        if ($request->hasFile('image64')) {
            $image = $request->File('image64');
            $imageBase64 = base64_encode(file_get_contents($image));
            $news->image64 = $imageBase64;
        }

        $news->save();

        return redirect()->route('news')->with('success', 'Rewarditems update successfully.');

    }

    // เพิ่มข้อมูล
    public function store(Request $request){
        $request->validate([
            'heading' => 'required',
            'content' => 'required',
            'image64' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $request->file('image64');
        $imageBase64 = base64_encode(file_get_contents($image));

        News::create([
            'heading' => $request->input('heading'),
            'content' => $request->input('content'),
            'image64' => $imageBase64,
        ]);

        return redirect()->back()->with('success','Heading Create Successfully.');
    }
}
