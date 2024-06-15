<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use App\Http\Requests\StoreArmadaRequest;
use App\Http\Requests\UpdateArmadaRequest;
use Illuminate\Support\Facades\Auth;

class ArmadaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $armadas = Armada::orderBy('updated_at', 'desc')->get();

        return view('transporter.armada.index', compact('armadas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transporter.armada.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArmadaRequest $request)
    {

        // dd($request->all());
        // validate request
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'brand' => 'required',
            'year' => 'required',
            'condition' => 'required',
            'license_plate' => 'required',
            'max_weight' => 'required',
        ],[
            'name.required' => 'Nama armada harus diisi',
            'type.required' => 'Tipe armada harus diisi',
            'brand.required' => 'Merek armada harus diisi',
            'year.required' => 'Tahun armada harus diisi',
            'condition.required' => 'Kondisi armada harus diisi',
            'license_plate.required' => 'Plat nomor armada harus diisi',
            'max_weight.required' => 'Batas muatan armada harus diisi',
        ]);

        // store data to database
        $armada = new Armada();
        $armada->name = $request->name;
        $armada->type = $request->type;
        $armada->brand = $request->brand;
        $armada->year = $request->year;
        $armada->condition = $request->condition;
        $armada->license_plate = $request->license_plate;
        $armada->max_load = $request->max_weight;
        $armada->user_id = Auth::user()->id;
        $armada->save();

        return redirect()->route('armada')->with('success', 'Data armada berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(Armada $armada)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $armada = Armada::find($id);

        return view('transporter.armada.edit', compact('armada'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArmadaRequest $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'brand' => 'required',
            'year' => 'required',
            'condition' => 'required',
            'license_plate' => 'required',
            'max_weight' => 'required',
        ],[
            'name.required' => 'Nama armada harus diisi',
            'type.required' => 'Tipe armada harus diisi',
            'brand.required' => 'Merek armada harus diisi',
            'year.required' => 'Tahun armada harus diisi',
            'condition.required' => 'Kondisi armada harus diisi',
            'license_plate.required' => 'Plat nomor armada harus diisi',
            'max_weight.required' => 'Batas muatan armada harus diisi',
        ]);

        $armada = Armada::find($id);
        $armada->name = $request->name;
        $armada->type = $request->type;
        $armada->brand = $request->brand;
        $armada->year = $request->year;
        $armada->condition = $request->condition;
        $armada->license_plate = $request->license_plate;
        $armada->max_load = $request->max_weight;
        $armada->update();

        return redirect()->route('armada')->with('success', 'Data armada berhasil diubah');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $armada = Armada::find($id);

        $armada->delete();

        return redirect()->route('armada')->with('success', 'Data armada berhasil dihapus');
    }
}
