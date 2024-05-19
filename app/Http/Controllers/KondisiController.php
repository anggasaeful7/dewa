<?php

namespace App\Http\Controllers;

use App\Models\KondisiRumah;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class KondisiController extends Controller
{
    public function index()
    {
        $kondisi = KondisiRumah::with('penduduk')->get();
        return view('kondisi.index', compact('kondisi'));
    }

    public function create()
    {
        $penduduk = Penduduk::all();
        return view('kondisi.create', compact('penduduk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_penduduk' => 'required',
            'Luas_lantai' => 'required|numeric',
            'Jenis_lantai' => 'required|string|max:255',
            'Jenis_dinding' => 'required|string|max:255',
            'Fasilitas_BAB' => 'required|string|max:255',
            'Penerangan' => 'required|string|max:255',
            'Air_minum' => 'required|string|max:255',
            'BB_masak' => 'required|string|max:255',
            'foto_rumah' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Mengelola unggahan file
        if ($request->hasFile('foto_rumah')) {
            $file = $request->file('foto_rumah');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/foto_rumah', $fileName);
        }

        // Membuat entri baru
        $penduduk = new KondisiRumah([
            'id_penduduk' => $request->id_penduduk,
            'Luas_lantai' => $request->Luas_lantai,
            'Jenis_lantai' => $request->Jenis_lantai,
            'Jenis_dinding' => $request->Jenis_dinding,
            'Fasilitas_BAB' => $request->Fasilitas_BAB,
            'Penerangan' => $request->Penerangan,
            'Air_minum' => $request->Air_minum,
            'BB_masak' => $request->BB_masak,
            'foto_rumah' => $fileName ?? null,
        ]);

        $penduduk->save(); // Menyimpan data ke basis data

        return redirect()->route('kondisi.index')->with('success', 'Kondisi berhasil ditambahkan.');
    }



    public function edit($id)
    {
        $kondisi = KondisiRumah::find($id);
        $penduduk = Penduduk::all();
        return view('kondisi.edit', compact('kondisi', 'penduduk'));
    }

    public function update(Request $request, $id)
    {
        KondisiRumah::find($id)->update([
            'Luas_lantai' => $request->Luas_lantai,
            'Jenis_lantai' => $request->Jenis_lantai,
            'Jenis_dinding' => $request->Jenis_dinding,
            'Fasilitas_BAB' => $request->Fasilitas_BAB,
            'Penerangan' => $request->Penerangan,
            'Air_minum' => $request->Air_minum,
            'BB_masak' => $request->BB_masak
        ]);

        return redirect()->route('kondisi.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        KondisiRumah::destroy($id);
        return redirect()->route('kondisi.index')->with('success', 'Data berhasil dihapus');
    }
}
