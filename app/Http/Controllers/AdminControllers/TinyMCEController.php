<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;

class TinyMCEController extends Controller
{
    public function uploadTinymceImage(): \Illuminate\Http\JsonResponse
    {
        $image = request()->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('storage/tinymce_uploads'), $imageName);
        return response()->json(['location' => asset('storage/tinymce_uploads/' . $imageName)]);
    }
}
