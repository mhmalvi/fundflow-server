<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\MontlyBlogReader;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class VisitorController extends Controller
{
    public function monthly_blog_reader()
    {
        try {
            $curr_month = date('m');
            $curr_year = date('Y');
            $reader = MontlyBlogReader::select(DB::raw('sum(monthly_blog_reader) as reader_number'))->whereMonth('created_at', '=', $curr_month - 1)->whereYear('created_at', '=', $curr_year)->get();
            // dd(json_encode($reader));
            if ($reader) {
                return response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $reader
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    
}
