<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth')->except('upload_form','download');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        \Illuminate\Support\Facades\Artisan::call('make:controller DenemeController');
        return view('home');
    }
    public function upload_form()
    {
        return view('upload');
    }
    public function download($filepath)
    {
        //return response()->download(public_path('uploads\\'.$filepath));
        if (!Storage::disk('local')->exists("$filepath")){
        return response()->json([
            'message'=>'Aradığınız dosya bulunamamaktadır'
    ]);      }

        return Storage::disk('local')->download("$filepath");
    }
}
