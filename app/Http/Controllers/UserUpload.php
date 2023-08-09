<?php

namespace App\Http\Controllers;

use App\Models\GoogleDrive;
use App\Models\PostImage;
use Carbon\Carbon;
use Google\Service\ShoppingContent\Resource\Pos;
use Illuminate\Http\Request;

class UserUpload extends Controller
{
    public function getBase64(Request $request)
    {
        $user = auth()->user()->email;

        $paginate = $request->page_number;
        $max_item = 10;
        $all = PostImage::where("user",$user)->get();

        if ($paginate == null)
        {
            $img = PostImage::where("user",$user)->latest()->take($max_item)->get();

            return response()->json(["data" => $img,"length" => count($all)], 200);
        }
        else{
            $skipp_item = ($paginate-1) * $max_item;
            $img = PostImage::where("user",$user)->skip($skipp_item)->latest()->take($max_item)->get();

            return response()->json(["data" => $img,"length" => count($all)], 200);
        }
    }

    public function getDrive(Request $request)
    {
        $user = auth()->user()->email;

        $paginate = $request->page_number;
        $max_item = 10;
        $all = GoogleDrive::where("user",$user)->get();

        if ($paginate == null)
        {
            $img = GoogleDrive::where("user",$user)->latest()->take($max_item)->get();

            return response()->json(["data" => $img,"length" => count($all)], 200);
        }
        else{
            $skipp_item = ($paginate-1) * $max_item;
            $img = GoogleDrive::where("user",$user)->skip($skipp_item)->latest()->take($max_item)->get();

            return response()->json(["data" => $img,"length" => count($all)], 200);
        }
    }
}
