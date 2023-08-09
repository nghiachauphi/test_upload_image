<?php

namespace App\Http\Controllers;

use App\Models\GoogleDrive;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Visitor::all();
        $arr = [];

        foreach ($all as $item)
        {
            array_push($arr, $item->ip);
        }

        $total_ip = array_count_values($arr);

        $date_now = Visitor::whereDate('date', Carbon::today())->get();

        return response()->json(["data" => count($all) + 117, "date" => count($date_now), "ip" => count($total_ip)], 200);
    }

    public function logRequestAPI(Request $request)
    {
        $paginate = $request->page_number;
        $max_item = 10;
        $category = Visitor::all();
        $length = count($category);

        if ($paginate == null)
        {
            $category_latest = Visitor::latest()->take($max_item)->get();
            return response()->json(["data" => $category_latest,"length" => $length], 200);
        }
        else{
            $skipp_item = ($paginate-1) * $max_item;
            $category = Visitor::skip($skipp_item)->latest()->take($max_item)->get();

            return response()->json(["data" => $category,"length" => $length], 200);
        }
    }

    public function logRequest()
    {
        return view("log.log_request");
    }
}
