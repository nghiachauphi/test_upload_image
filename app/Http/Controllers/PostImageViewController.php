<?php

namespace App\Http\Controllers;

use App\Models\GoogleDrive;
use App\Models\User;
use Carbon\Carbon;
use Google\Service\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Mongodb\Auth\Authenticatable;
use Illuminate\Support\Facades\Session;

class PostImageViewController extends Controller
{
    public function getFileMultipart()
    {
        return view('/googledrive.getfile');
    }

    public function getReport()
    {
        return view('/report.index');
    }

    public function postFileMultipart(Request $request)
    {
        $user = "";
        if (auth()->check() == true)
        {
            $user = auth()->user()->email;
        }

        $count = count($request->allFiles());
        $date = Carbon::now()->toDateString();
        $array = [];
        $name_file = [];

        for ($i=1; $i<=$count; $i++)
        {
            \Storage::disk('google')->put("file_$date",$request->file("file_$i"), "public");

            $name_tmp = $request->file("file_$i")->getClientOriginalName();

            $data = (array)\Storage::disk('google')->getAdapter();

            $id = array_key_last ($data["\x00Masbug\Flysystem\GoogleDriveAdapter\x00cacheFileObjects"]);

            array_push($array, $id);
            array_push($name_file, $name_tmp);
        }

        if ($id)
        {
            $id_link = GoogleDrive::create([
                "id_ggdrive" => $array,
                "name_file" => $name_file,
                "user" => $user,
            ]);
        }

        return view('/googledrive.getfile')->with("link",$id_link->_id)->with("data",$id_link);
    }

    public function showFileMultipart(Request $request)
    {
        $id_img = $request->getRequestUri();
        return view('/googledrive.showfile')->with('data',$id_img);
    }


    public function getImageMultipart()
    {
        return view('/googledrive.freeimage');
    }

    public function getGoogleDriveImage(Request $request)
    {
        $id_img = $request->getRequestUri();
        return view('/googledrive.showimage')->with('data',$id_img);
    }

    public function getImage()
    {
        return view('/freeimage.index');
    }

    public function show(Request $request)
    {
        $id_img = $request->getRequestUri();
        return view('/freeimage.show')->with('data',$id_img);
    }

    public function ggdrive()
    {
        return view('/freeimage.ggdrive');
    }

    public function showGGDrive(Request $request)
    {
        $id_file = $request->getRequestUri();
        return view('/freeimage.showdrive')->with('data',$id_file);
    }
}
