<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '.' . $file->extension();
            //$file->move(public_path('/uploads/'), $fileName);
            $fileUrl = url('/uploads/' . $fileName);
            //$path=$file->store('');
            $path=$file->storeAs('',$fileName);
            return response()->json([
                'url' => asset('/uploads/' .$path)
            ]);
        }
    }

}
