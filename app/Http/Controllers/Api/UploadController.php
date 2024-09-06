<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'required|image|max:15000',
        ]);

        $uploadedFiles = collect();

        foreach ($request->file('files') as $file) {
            $date = date('Y-m-d');
            $uploadedFiles->push(
                \Storage::url($file->store('public/uploads/' . $date))
            );
        }

        return response()->json(['message' => 'Files uploaded successfully', 'files' => $uploadedFiles]);

    }
}
