<?php

namespace App\Http\Controllers;
use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.level:2');
    }

    //ดึงข้อมูล เเละ ค้นหาข้อมูล
    public function index(Request $request){
        $search = $request->search;
        $machines = Machine::where(function ($query) use ($search){
            $query->Where('name', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%')
                  ->orWhere('remark', 'like', '%' . $search . '%');
        })
        ->paginate(10);
        return view('admin.machines', compact('machines','search'));
    }

    //ลบข้อมูลตามID
    public function destroy($id){
        $machines = Machine::findOrFail($id);
        $machines->delete();

        return redirect()->route('machines')->with('success', 'machine delete successfully!');
    }

    //อัปเดข้อมูล
    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'remark' => 'required',
        ]);

        $machines = Machine::findOrFail($id);

        $machines->name = $request->name;
        $machines->location = $request->location;
        $machines->remark = $request->remark;

        $machines->save();

        return redirect()->route('machines')->with('success', 'Machine update successfully.');

    }

    //เพิ่มข้อมูล
    public function store(Request $request){
       
        $request->validate([
            'name' => 'required|unique:machines,name',
            'location' => 'required',
            'remark' => 'required',
        ],[
            'name.unique' => 'The name has already been taken.',
        ]);

        Machine::create([
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'remark' => $request->input('remark'),
        ]);

        return redirect()->back()->with('success','Machine Create Successfully.');
    }
}
