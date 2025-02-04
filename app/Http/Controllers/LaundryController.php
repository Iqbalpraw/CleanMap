<?php
namespace App\Http\Controllers;

use App\Models\Laundry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaundryController extends Controller
{
    public function index()
    {
        $laundries = Laundry::latest()->get();
        return view('laundry.index', compact('laundries'));
    }

    public function create()
    {
        return view('laundry.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact' => 'required|string|max:20',
            'services' => 'required|array|min:1',
            'opening_hour' => 'required|date_format:H:i',
            'closing_hour' => 'required|date_format:H:i|after:opening_hour',
            'description' => 'nullable|string',
            'owner_name' => 'required|string|max:255',
            'owner_contact' => 'required|string|max:20',
            'location' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'photo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/laundry'), $filename);
            $validated['photo'] = 'img/laundry/' . $filename;
        }

        try {
            Laundry::create($validated);
            return redirect()
                ->route('laundry.index')
                ->with('success', 'Data laundry berhasil disimpan!');
        } catch (\Exception $e) {
            if (isset($validated['photo'])) {
                unlink(public_path($validated['photo']));
            }
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data!');
        }
    }

    public function edit(Laundry $laundry)
    {
        return view('laundry.edit', compact('laundry'));
    }

    public function update(Request $request, Laundry $laundry)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact' => 'required|string|max:20',
            'services' => 'required|array|min:1',
            'opening_hour' => 'required|date_format:H:i',
            'closing_hour' => 'required|date_format:H:i|after:opening_hour',
            'description' => 'nullable|string',
            'owner_name' => 'required|string|max:255',
            'owner_contact' => 'required|string|max:20',
            'location' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'photo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($laundry->photo && file_exists(public_path($laundry->photo))) {
                unlink(public_path($laundry->photo));
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/laundry'), $filename);
            $validated['photo'] = 'img/laundry/' . $filename;
        }

        try {
            $laundry->update($validated);
            return redirect()
                ->route('laundry.index')
                ->with('success', 'Data laundry berhasil diperbarui!');
        } catch (\Exception $e) {
            if (isset($validated['photo'])) {
                unlink(public_path($validated['photo']));
            }
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data!');
        }
    }

    public function destroy(Laundry $laundry)
    {
        try {
            if ($laundry->photo && file_exists(public_path($laundry->photo))) {
                unlink(public_path($laundry->photo));
            }
            
            $laundry->delete();
            return redirect()
                ->route('laundry.index')
                ->with('success', 'Data laundry berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data!');
        }
    }



    public function show(Laundry $laundry)
    {
        // Use the laundry's actual coordinates
        $coordinates = [
            'latitude' => $laundry->latitude,
            'longitude' => $laundry->longitude
        ];
        return view('laundry.show', compact('laundry', 'coordinates'));
    }

    public function dashboard()
    {
        // Get all laundries with their complete information
        $laundries = Laundry::latest()->get()->map(function ($laundry) {
            return [
                'id' => $laundry->id,
                'name' => $laundry->name,
                'photo' => $laundry->photo,
                'address' => $laundry->address,
                'contact' => $laundry->contact,
                'opening_hour' => $laundry->opening_hour->format('H:i'),
                'closing_hour' => $laundry->closing_hour->format('H:i'),
                'services' => $laundry->services,
                'latitude' => $laundry->latitude,
                'longitude' => $laundry->longitude
            ];
        });
        
        return view('dashboard', compact('laundries'));
    }
}