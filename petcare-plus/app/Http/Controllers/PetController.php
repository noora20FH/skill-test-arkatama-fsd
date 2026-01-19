<?php
namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PetController extends Controller
{
    public function index()
    {

        $pets = Pet::with('owner')->latest()->get();
        $owners = Owner::where('is_verified', true)->get();

        return view('pets.index', compact('pets', 'owners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'raw_data' => 'required|string',
        ]);

        // 1. Parsing Data Input

        $cleanString = preg_replace('/\s+/', ' ', trim($request->raw_data));
        $parts = explode(' ', $cleanString);

        
        if (count($parts) < 4) {
            return back()->withErrors(['raw_data' => 'Format data tidak sesuai. Gunakan: NAMA JENIS USIA BERAT']);
        }


        $rawWeight = array_pop($parts);
        $rawAge    = array_pop($parts);
        $rawType   = array_pop($parts);
        $rawName   = implode(' ', $parts);

        // 2. Pembersihan & Formatting Data


        $name = strtoupper($rawName);
        $type = strtoupper($rawType);

        // B. Bersihkan Usia (Ambil angka saja)

        $age = (int) filter_var($rawAge, FILTER_SANITIZE_NUMBER_INT);
        if ($age <= 0) {
            return back()->withErrors(['raw_data' => 'Format usia tidak valid.']);
        }

        $normalizedWeight = str_replace(',', '.', $rawWeight);
        $weight = (float) filter_var($normalizedWeight, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        if ($weight <= 0) {
            return back()->withErrors(['raw_data' => 'Format berat tidak valid.']);
        }

        $exists = Pet::where('owner_id', $request->owner_id)
                     ->where('name', $name)
                     ->where('type', $type)
                     ->exists();

        if ($exists) {
            return back()->withErrors(['raw_data' => "Hewan $name ($type) sudah terdaftar pada pemilik ini."]);
        }



        $timePart = now()->format('Hi');
        $ownerPart = str_pad($request->owner_id, 4, '0', STR_PAD_LEFT);

        $nextSequence = Pet::count() + 1;
        $seqPart = str_pad($nextSequence, 4, '0', STR_PAD_LEFT);

        $code = $timePart . $ownerPart . $seqPart;

        Pet::create([
            'owner_id' => $request->owner_id,
            'code'     => $code,
            'name'     => $name,
            'type'     => $type,
            'age'      => $age,
            'weight'   => $weight,
        ]);

        return redirect()->back()->with('success', 'Data hewan berhasil disimpan!');
    }
}
