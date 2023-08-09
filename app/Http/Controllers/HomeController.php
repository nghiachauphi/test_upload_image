<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Mongodb\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function test()
    {
        return view('test');
//        return redirect('https://shopee.vn/');

    }

    public function index()
    {
        if (auth()->check())
        {
            $user = auth::user();
        }

        return view('home')->with("user", isset($user));
    }

    public function stopGif()
    {
        return view('other/stopgif');
    }

    public function CountDownDate()
    {
        $coutdown = Category::where('name',"countdown")->get();

        return response()->json(["data" => $coutdown],200);
    }

    public function ContactInfo(Request $request)
    {
        $image = "data:image/jpeg;base64,".base64_encode(file_get_contents($request->file('image_contact')->path()));

        $response = Contact::create([
            'name' => $request->name,
            'email_phone' => $request->email_phone,
            'title' => $request->title,
            'content_info' => $request->content_info,
            'image_contact' => $image,
        ]);

        return view("/home")->with("data_contact", "Cảm ơn bạn đã đóng góp ý kiến! Chúng tôi sẽ phản hồi sớm nhất.");
    }
}
