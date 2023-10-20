<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;

class ObatController extends Controller
{
    public function tambahObat(Request $request) {
        $request->validate([
            'name' => 'required|min:3',
            'type' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric'
        ], [
            'name.required' => 'Nama obat wajib diisi',
            'name.min' => 'Nama obat tidak boleh kurang dari 3 karakter',
            'type.required' => 'Jenis obat wajib dipilih',
            'price.required' => 'Harga obat wajib diisi',
            'stock.required' => 'Stok obat wajib diisi'
        ]);
        $requestData = $request->all();
        Obat::create($requestData);

        return redirect()->route('apotek.obatInfo')->with('obatAdd', 'Data ditambahkan');
    }

    public function obatData() {
        $obatData = Obat::simplePaginate(5);
        return view('apotek.obat', compact('obatData'));
    }


    public function obatEdit($id) {
        $obat = Obat::find($id);
        return view('apotek.obatEdit')->with('obat', $obat);
    }

    public function obatUpdate($id, Request $request) {
        $data = Obat::find($id);
        $data->update($request->except(['_token', 'submit']));

        return redirect()->route('apotek.obatInfo')->with('obatUpdate', 'Data berhasil diperbarui!');
    }

    public function obatDestroy($id) {
        $Obat = Obat::find($id);
        $Obat->delete();

        return redirect()->route('apotek.obatInfo')->with('obatDelete', 'Data berhasil dihapus');
    }

    public function stock() {
        $obatData = Obat::all();
        return view('apotek.stok', compact('obatData'));
    }

    public function stockEdit($id) {
        $obat = Obat::find($id);
        return view('apotek.obatStok')->with('obat', $obat);
    }

    public function stockUpdate($id, Request $request) {
        $data = Obat::find($id);

        $stockUpdate = $request->input('stock');

        if ($stockUpdate > $data->stock) {
            $data->stock = $stockUpdate;
            $data->save();
            return redirect()->route('apotek.obatStok')->with('stockAdd', 'Stok berhasil di tambah');
        } else {
            return redirect()->back()->with('stockAddError', 'Nominal harus lebih dari yang sebelum nya!');
        }
    }

}
