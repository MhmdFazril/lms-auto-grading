<?php

namespace App\Http\Controllers;

use App\Models\Logos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogosController
{
    function logos()
    {
        $data = [
            'title' => 'logo',
            'script' => 'logo_script',
            'logo' => Logos::where('file', 'LIKE', "%logos%")->first(),
            'favicon' => Logos::where('file', 'LIKE', "%favicon%")->first(),
        ];

        return view('admin.logo.logo', $data);
    }

    function logosStore(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $fileName = 'logos_' . time() . '.' . $request->file->extension();
        $path = $request->file('file')->storeAs('logo', $fileName);
        $size = $request->file->getSize();

        $cek = Logos::where('file', 'like', '%logos%')->first();
        if ($cek == null) {
            Logos::create([
                'file' => $fileName,
                'size' => $size,
                'path' => $path,
            ]);
        } else {
            Storage::delete($cek->path);
            Logos::where('id', 1)->update([
                'file' => $fileName,
                'size' => $size,
                'path' => $path,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'File berhasil diunggah',
            'file_name' => $fileName,
            'file_size' => $size,
            'file_path' => 'storage/' . $path
        ]);
    }

    function faviconStore(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $fileName = 'favicon_' . time() . '.' . $request->file->extension();
        $path = $request->file('file')->storeAs('logo', $fileName);
        $size = $request->file->getSize();

        $cek = Logos::where('file', 'like', '%favicon_%')->first();
        if ($cek == null) {
            Logos::create([
                'file' => $fileName,
                'size' => $size,
                'path' => $path,
            ]);
        } else {
            Storage::delete($cek->path);
            Logos::where('id', 1)->update([
                'file' => $fileName,
                'size' => $size,
                'path' => $path,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'File berhasil diunggah',
            'file_name' => $fileName,
            'file_size' => $size,
            'file_path' => 'storage/' . $path
        ]);
    }

    function removeLogos(Request $request)
    {
        $success = false;
        $message = '';

        $path = substr($request->url, 9);

        if (Storage::delete($path)) {
            Logos::where('path', $path)->delete();
            $success = true;
            $message = 'berhasil menghapus gambar';
        } else {
            $success = false;
            $message = 'gagal menghapus gambar';
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'back' => $request->url,
        ]);
    }
}
