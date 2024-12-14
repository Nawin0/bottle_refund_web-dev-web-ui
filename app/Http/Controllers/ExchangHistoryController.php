<?php

namespace App\Http\Controllers;
use App\Models\Exchang_History;
use Illuminate\Http\Request;

class ExchangHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.level:2');
    }

    //ดึงข้อมูล เเละ ค้นหาข้อมูล
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $type = $request->input('type', 1);

        $exchang = Exchang_History::where(function ($query) use ($search) {
            if ($search) {
                $query->where('phone_no', 'like', '%' . $search . '%')
                    ->orWhere('product_code', 'like', '%' . $search . '%')
                    ->orWhere('point', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%');
            }
        })
        ->when($type, function ($query) use ($type) {
            $query->where('status', $type);
        })
        ->paginate(10);

        return view('admin.historyreward', compact('search', 'exchang', 'type'));
    }

    public function updateStatus(Request $request, $id){
        $status = $request->input('status');
        $exchang = Exchang_History::find($id);
        $exchang->status = $status;
        $exchang->save();

        return reponse()->json(['message' => 'Status updated successfully']);
    }
}
