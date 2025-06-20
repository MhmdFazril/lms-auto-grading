<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DashboardController
{

    function dashboard()
    {
        $data = [
            'title' => 'Dashboard',
            'info' => Dashboard::orderBy('order', 'asc')->get(),
        ];

        return view('menus.dashboard', $data);
    }

    function index()
    {
        $data = [
            'title' => 'Site Setting',
            'script' => 'siteSetting_script',
            'information' => Dashboard::orderby('order', 'asc')->get(),
        ];

        return view('menus.siteSetting', $data);
    }

    function create()
    {
        $data = [
            'title' => 'Create Information',
            'script' => 'addSiteSetting_script',
            'orders' => Dashboard::orderby('order', 'asc')->get(['title', 'order']),
        ];

        return view('menus.addSiteSetting', $data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required|string|max:50',
            'published_at' => 'nullable|date',
            'take_down_at' => 'nullable|date|after_or_equal:published_at',
            'order' => 'required|integer|min:1|max_digits:2',
            'gambar' => 'nullable|file|image|max:2048',
            'content' => 'nullable|string'
        ]);

        if ($request->file('gambar')) {
            $validateData['gambar'] = 'storage/' . $request->file('gambar')->store('image-dashboard');
        } else {
            $validateData['gambar'] = null;
        }

        try {
            DB::transaction(function () use ($validateData) {
                Dashboard::where('order', '>=', $validateData['order'])
                    ->increment('order');

                Dashboard::create($validateData);
            });

            return redirect()->route('dashboard.index')->with('successToast', 'Informasi berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan dashboard', ['error' => $e]);

            return redirect()->route('dashboard.index')->with('errorToast', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function edit(Dashboard $dashboard)
    {
        $data = [
            'title' => 'Edit Information',
            'script' => 'editSiteSetting_script',
            'information' => $dashboard,
            'orders' => Dashboard::orderby('order', 'asc')->get(['title', 'order', 'id']),
        ];

        return view('menus.editSiteSetting', $data);
    }


    public function update(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required|string|max:50',
            'published_at' => 'nullable|date',
            'take_down_at' => 'nullable|date|after_or_equal:published_at',
            'order' => 'required|integer|min:1|max_digits:2',
            'gambar' => 'nullable|file|image|max:2048',
            'content' => 'nullable|string'
        ]);

        if ($request->file('gambar')) {
            if ($request->gambar_old != null) {
                Storage::delete(substr($request->gambar_old, 8));
            }
            $validateData['gambar'] = 'storage/' . $request->file('gambar')->store('image-dashboard');
        }

        if ($request->remove_image == '1' && !$request->hasFile('gambar')) {
            Storage::delete(substr($request->gambar_old, 8));
            $validateData['gambar'] = null;
        }

        // masih harus diperbaiki
        try {
            DB::transaction(function () use ($validateData, $request) {
                $dashboard = Dashboard::findOrFail($request->id);
                $oldOrder = $dashboard->order;
                $newOrder = $validateData['order'];

                if ($newOrder != $oldOrder) {
                    if ($newOrder < $oldOrder) {
                        Dashboard::where('id', '!=', $dashboard->id)
                            ->where('order', '>=', $newOrder)
                            ->where('order', '<', $oldOrder)
                            ->increment('order');
                    } else {
                        Dashboard::where('id', '!=', $dashboard->id)
                            ->where('order', '>', $oldOrder)
                            ->where('order', '<=', $newOrder)
                            ->decrement('order');
                    }
                }

                $dashboard->update($validateData);
            });
            return redirect()->route('dashboard.index')->with('successToast', 'Informasi berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan dashboard', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('dashboard.index')->with('errorToast', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }


    public function destroy(Dashboard $dashboard)
    {
        if ($dashboard->gambar != null) {
            Storage::delete(substr($dashboard->gambar, 8));
        }

        Dashboard::destroy($dashboard->id);

        return redirect()->route('dashboard.index')->with('successToast', 'Data berhasil dihapus');
    }
}
