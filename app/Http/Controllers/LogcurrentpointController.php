<?php

namespace App\Http\Controllers;
use App\Models\Logcurrentpoints; 
use Illuminate\Http\Request;

class LogcurrentpointController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.level:2');
    }

    //ดึงข้อมูล เเละ ค้นหาข้อมูล
    public function index(Request $request){
        $search = $request->search;
        $logcurrentpoints = Logcurrentpoints::where(function ($query) use ($search){
            $query->Where('phone_no', 'like', '%' . $search . '%')
                  ->orWhere('current_point', 'like', '%' . $search . '%')
                  ->orWhere('admin_id', 'like', '%' . $search . '%');
        })
        ->paginate(10);
        return view('admin.logcurrentpoints', compact('logcurrentpoints','search'));
    }
}
