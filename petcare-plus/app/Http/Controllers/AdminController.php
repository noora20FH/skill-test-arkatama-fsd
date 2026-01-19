<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Treatment;
use App\Models\Checkup;

class AdminController extends Controller
{
    public function index()
    {
        // Data untuk Dashboard: List Hewan & Dropdown Owner
        $pets = Pet::with(['owner', 'checkups.treatment'])->latest()->get();
        // Syarat B: Dropdown hanya pemilik verified
        $owners = Owner::where('is_verified', true)->get();
        // Data Treatment untuk modal/form pemeriksaan
        $treatments = Treatment::all();

        return view('admin.dashboard', compact('pets', 'owners', 'treatments'));
    }

    // --- LOGIC 1: SIMPAN HEWAN (Sesuai Syarat A, B, C, D) ---
    public function storePet(Request $request)
    {
        $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'raw_data' => 'required|string',
        ]);

        // 1. Parsing Data (Aturan C & D)
        $cleanString = preg_replace('/\s+/', ' ', trim($request->raw_data));
        $parts = explode(' ', $cleanString);

        if (count($parts) < 4) {
            return back()->withErrors(['raw_data' => 'Format salah. Gunakan: NAMA JENIS USIA BERAT']);
        }

        $rawWeight = array_pop($parts);
        $rawAge    = array_pop($parts);
        $rawType   = array_pop($parts);
        $rawName   = implode(' ', $parts);

        // Aturan Pengolahan Data
        $name = strtoupper($rawName);
        $type = strtoupper($rawType);
        $age = (int) filter_var($rawAge, FILTER_SANITIZE_NUMBER_INT);
        $weight = (float) filter_var(str_replace(',', '.', $rawWeight), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        // Validasi Tambahan A: Unik
        if (Pet::where('owner_id', $request->owner_id)->where('name', $name)->where('type', $type)->exists()) {
            return back()->withErrors(['raw_data' => "Hewan $name ($type) sudah ada pada pemilik ini."]);
        }

        // Generate Kode (Syarat 5): HHMMXXXXYYYY
        $timePart = now()->format('Hi');
        $ownerPart = str_pad($request->owner_id, 4, '0', STR_PAD_LEFT);
        $seqPart = str_pad(Pet::count() + 1, 4, '0', STR_PAD_LEFT);
        $code = $timePart . $ownerPart . $seqPart;

        Pet::create([
            'owner_id' => $request->owner_id,
            'code'     => $code,
            'name'     => $name,
            'type'     => $type,
            'age'      => $age,
            'weight'   => $weight,
        ]);

        return back()->with('success', 'Hewan berhasil didaftarkan!');
    }

    // --- LOGIC 2: SIMPAN PEMERIKSAAN (Fitur Baru) ---
    public function storeCheckup(Request $request)
    {
        $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'treatment_id' => 'required|exists:treatments,id',
            'notes' => 'nullable|string'
        ]);

        Checkup::create($request->all());

        return back()->with('success', 'Data pemeriksaan berhasil disimpan!');
    }
    
    public function destroyPet($id)
    {
        Pet::findOrFail($id)->delete();
        return back()->with('success', 'Data dihapus.');
    }
}