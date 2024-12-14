<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Logcurrentpoints;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.level:2');
    }

    //ดึงข้อมูล เเละ ค้นหาข้อมล
    public function index(Request $request){
        $search = $request->search;
        $members = Member::where(function ($query) use ($search){
            $query->where('phone_no', 'like', '%' . $search . '%')
                  ->orWhere('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('current_point', 'like', '%' . $search . '%');
        })
        ->paginate(10);
        return view('admin.members', compact('members','search'));
    }

    //ลบข้อมูลตามID
    public function destroy($id){
        $members = Member::findOrFail($id);
        $members->delete();

        return redirect()->route('members')->with('success', 'Members delete successfully!');
    }

    //แก้ไขpoint
    public function updatepoint(Request $request, $id){
        $request->validate([
            'current_point' => 'required',
        ]);
        $members = Member::find($id);

        Logcurrentpoints::create([
            'phone_no' => $members->phone_no,
            'current_point' => $request->input('current_point'),
            'admin_id' => auth()->user()->id,
        ]);
        $members->update([
            'current_point' => $request->current_point,
        ]);

       return redirect()->route('members')->with('success', 'Members update successfully.');
    }

    //อัปเดตข้อมูล
    public function update(Request $request, $id){
    $request->validate([
        'phone_no' => 'required|unique:members,phone_no,' . $id,
        'name' => 'required',
        'email' => 'required|email|unique:members,email,'. $id,
        'level' => 'required',
        'pass' => 'required',
    ]);

    $member = Member::findOrFail($id);

    $member->phone_no = $request->phone_no;
    $member->name = $request->name;
    $member->email = $request->email;
    $member->level = $request->level;

    if ($request->filled('pass')){
        $member->pass = Hash::make($request->pass);
    }
    
    $member->save();

    return redirect()->route('members')->with('success', 'Member updated successfully.');
    }
}
