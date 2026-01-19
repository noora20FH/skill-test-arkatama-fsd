<?php

// app/Http/Controllers/OwnerController.php
namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::latest()->get();
        return view('admin.owners.index', compact('owners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
        ]);

        Owner::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'is_verified' => true // Default verified agar muncul di dropdown hewan
        ]);

        return back()->with('success', 'Pemilik berhasil ditambahkan');
    }
}
