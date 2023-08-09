<?php

namespace App\Http\Controllers;

use App\Models\GoogleDrive;
use App\Models\PostImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mongodb\Auth\Authenticatable;

class PostImageController extends Controller
{
    public function CheckUser()
    {
        $user = "";
        if (auth()->check() == true)
            $user = auth()->user()->email;
        return $user;
    }

    public function getReportBase64()
    {
        $image = PostImage::orderBy('created_at', 'DESC')->take(15)->get();

        return response()->json(["data" => $image], 200);
    }

    public function getReportGGDrive()
    {
        $image = GoogleDrive::orderBy('created_at', 'DESC')->take(15)->get();

        return response()->json(["data" => $image], 200);
    }

    public function index($id)
    {
        $image = PostImage::where("_id",$id)->get();

        if ($image->isEmpty())
        {
            $image = PostImage::where("link",$id)->get(); //khong con dung link nua
        }

        return response()->json(["message" => $image], 200);
    }

    public function create(Request $request)
    {
        $image = "data:image/jpeg;base64,".base64_encode(file_get_contents($request->file('image_base64')->path()));

        if ($image)
        {
            $response = PostImage::create([
                "image_base64" => $image,
                "user" => $this->CheckUser(),
            ]);

            return response()->json(["message" => "Tải ảnh lên thành công", "data"=> $response->_id ], 200);
        }
    }

    public function upGoogleDrive(Request $request)
    {
        $date = Carbon::now()->toDateString();

        \Storage::disk('google')->put("video_$date",$request->file('file_upload'),"public");

        $data = (array)\Storage::disk('google')->getAdapter();

        $id = array_key_last ($data["\x00Masbug\Flysystem\GoogleDriveAdapter\x00cacheFileObjects"]);

        if ($id)
        {
            GoogleDrive::create([
                "id_ggdrive" => $id,
                "user" => $this->CheckUser(),
            ]);
        }

        return response()->json(["message" => "Tải ảnh lên thành công", "data"=> $id ], 200);
    }

    public function getGoogleDrive($id)
    {
        $file = GoogleDrive::where("id_ggdrive",$id)->get();

        return response()->json(["message" => $file], 200);
    }

    public function upGoogleDriveImage(Request $request)
    {
        $count = count($request->allFiles());
        $date = Carbon::now()->toDateString();
        $array = [];

        for ($i=1; $i<=$count; $i++)
        {
            \Storage::disk('google')->put("image_$date",$request->file("image_$i"), "public");

            $data = (array)\Storage::disk('google')->getAdapter();

            $id = array_key_last ($data["\x00Masbug\Flysystem\GoogleDriveAdapter\x00cacheFileObjects"]);

            array_push($array, $id);

        }

        if ($id)
        {
            $id_link = GoogleDrive::create([
                "id_ggdrive" => $array,
                "user" => $this->CheckUser(),
            ]);
        }

        return response()->json(["message" => "Tải ảnh lên thành công", "data"=> $array, "link"=>$id_link ], 200);
    }

    public function upGoogleDriveFile(Request $request)
    {
        $count = count($request->allFiles());
        $date = Carbon::now()->toDateString();
        $array = [];
        $name_file = [];

        for ($i=1; $i<=$count; $i++)
        {
            \Storage::disk('google')->put($date,$request->file("file_$i"), "public");

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
                "user" => $this->CheckUser(),
            ]);
        }

        return response()->json(["message" => "Tải file lên thành công", "data"=> $array, "link"=>$id_link ], 200);
    }

    public function getGoogleDriveFile($id)
    {
        $image = GoogleDrive::where("_id",$id)->get();

        return response()->json(["message" => $image], 200);
    }
}
