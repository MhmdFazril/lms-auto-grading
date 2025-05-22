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

        $originalName = pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = 'logos_' . $originalName . '.' . $request->file->extension();
        $path = $request->file('file')->storeAs('logo', $fileName);
        $size = $request->file->getSize();

        $cek = Logos::where('file', 'like', '%logos%')->first();
        if ($cek == null) {
            Logos::create([
                'file' => $fileName,
                'size' => $size,
                'path' => $path,
            ]);
        }
        // else {
        //     Storage::delete($cek->path);
        //     Logos::where('id', 1)->update([
        //         'file' => $fileName,
        //         'size' => $size,
        //         'path' => $path,
        //     ]);
        // }

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

        $originalName = pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = 'favicon_' . $originalName . '.' . $request->file->extension();
        $path = $request->file('file')->storeAs('logo', $fileName);
        $size = $request->file->getSize();

        $cek = Logos::where('file', 'like', '%favicon_%')->first();
        if ($cek == null) {
            Logos::create([
                'file' => $fileName,
                'size' => $size,
                'path' => $path,
            ]);
        }
        // else {
        //     Storage::delete($cek->path);
        //     Logos::where('id', 1)->update([
        //         'file' => $fileName,
        //         'size' => $size,
        //         'path' => $path,
        //     ]);
        // }

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

        $cleanFilename = preg_replace('/^logos_/', '', $request->filename); // hapus logos_ di awal
        $path = Logos::where('file', 'like', '%logos_' . $cleanFilename . '%')->first();
        if ($path != null) {
            if (Storage::delete($path->path)) {
                Logos::where('path', $path->path)->delete();
                $success = true;
                $message = 'berhasil menghapus gambar';
            } else {
                $success = false;
                $message = 'gagal menghapus gambar';
            }
        } else {
            $success = true;
            $message = 'berhasil menghapus gambar';
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'back' => $request->url,
        ]);
    }

    function removeFavicon(Request $request)
    {
        $success = false;
        $message = '';

        // $path = substr($request->url, 9);

        $cleanFilename = preg_replace('/^favicon_/', '', $request->filename); // hapus logos_ di awal
        $path = Logos::where('file', 'like', '%favicon_' . $cleanFilename . '%')->first();

        if ($path != null) {
            if (Storage::delete($path->path)) {
                Logos::where('path', $path->path)->delete();
                $success = true;
                $message = 'berhasil menghapus gambar';
            } else {
                $success = false;
                $message = 'gagal menghapus gambar';
            }
        } else {
            $success = true;
            $message = 'berhasil menghapus gambar';
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'back' => $request->url,
        ]);
    }
}
