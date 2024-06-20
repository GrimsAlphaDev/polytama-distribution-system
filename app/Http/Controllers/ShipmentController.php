<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{

    public function dashboard()
    {
        
        $driverAvail = Availability::where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->where('user_id', auth()->user()->id)->first();

        return view('driver.dashboard.index', compact('driverAvail'));
    }

    public function index()
    {
        return view('shipment.dashboard.index', compact('driverAvail'));
    }

    public function updateStatusDriver($id, Request $request)
    {

        $request->validate([
            'status' => 'required'
        ],[
            'status.required' => 'Status harus diisi'
        ]);

        $availability = Availability::where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->where('user_id', $id)->first();
        if($availability){
            $availability->status = $request->status;
            $availability->updated_at = now();
            $availability->update();
        } else {
            $create = new Availability();
            $create->user_id = $id;
            $create->status = $request->status;
            $create->save();
        }

        return redirect()->route('driver')->with('success', 'Status driver berhasil diubah');
    }
}
