<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logpoint;

class LogpointController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.level:2');
    }

    public function index(Request $request){
        $search = $request->search;
        $logpoints = Logpoint::where(function ($query) use ($search){
            $query->where('phone_no', 'like', '%' . $search . '%')
                  ->orWhere('point', 'like', '%' . $search . '%');
        })
        ->paginate(10);

        return view('admin.logpoints', compact('logpoints', 'search'));
    }
}
