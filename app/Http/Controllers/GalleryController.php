<?php

namespace App\Http\Controllers;

use App\Models\Laundry;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Laundry $laundry)
    {
        $photos = Gallery::where('laundry_id', $laundry->id)
                        ->latest()
                        ->get();
        return view('gallery.index', compact('laundry', 'photos'));
    }

    public function store(Request $request, Laundry $laundry)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
            'caption' => 'nullable|string|max:255'
        ]);

        try {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/gallery'), $filename);

            Gallery::create([
                'laundry_id' => $laundry->id,
                'photo' => 'img/gallery/' . $filename,
                'caption' => $request->caption
            ]);

            return redirect()
                ->back()
                ->with('success', 'Foto berhasil ditambahkan ke galeri!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat mengunggah foto!');
        }
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'caption' => 'required|string|max:255'
        ]);

        $gallery->update([
            'caption' => $request->caption
        ]);

        return redirect()
            ->back()
            ->with('success', 'Caption foto berhasil diperbarui!');
    }

    public function destroy(Gallery $gallery)
    {
        try {
            if (file_exists(public_path($gallery->photo))) {
                unlink(public_path($gallery->photo));
            }
            
            $gallery->delete();
            return redirect()
                ->back()
                ->with('success', 'Foto berhasil dihapus dari galeri!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus foto!');
        }
    }
}