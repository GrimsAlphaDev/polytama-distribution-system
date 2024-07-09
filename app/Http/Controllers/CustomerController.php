<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function dashboard()
    {
        $customers = Customer::orderBy('updated_at', 'desc')->get();

        $orders = Order::orderBy('updated_at', 'desc')->get();

        return view('marketing.dashboard.index', compact('customers', 'orders'));
    }

    public function index()
    {
        $customers = Customer::orderBy('updated_at', 'desc')->get();
        
        return view('marketing.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('marketing.customer.create');
    }

    public function insert(Request $request)
    {
        // validate the request
        $request->validate([
            'name' => 'required|min:3|alpha',
            'email' => 'required|email|unique:customer,email',
            'phone' => 'required|unique:customer,no_telp',
            'address' => 'required',
            'city' => 'required',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.min' => 'Nama minimal 3 karakter',
            'name.alpha' => 'Nama harus berupa huruf',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone.required' => 'Nomor telepon tidak boleh kosong',
            'phone.unique' => 'Nomor telepon sudah terdaftar',
            'address.required' => 'Alamat tidak boleh kosong',
            'city.required' => 'Kota tidak boleh kosong',
        ]);

        // insert the data
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->no_telp = $request->phone;
        $customer->alamat = $request->address;
        $customer->kota = $request->city;
        $customer->save();

        return redirect()->route('customer')->with('success', 'Berhasil')->with('description', 'Data customer berhasil ditambahkan');
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('marketing.customer.edit', compact('customer'));
    }

    public function update($id, Request $request)
    {
        // validate the request
        $request->validate([
            'name' => 'required|min:3|alpha',
            'email' => 'required|email|unique:customer,email,' . $id,
            'phone' => 'required|unique:customer,no_telp,' . $id,
            'address' => 'required',
            'city' => 'required',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.min' => 'Nama minimal 3 karakter',
            'name.alpha' => 'Nama harus berupa huruf',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone.required' => 'Nomor telepon tidak boleh kosong',
            'phone.unique' => 'Nomor telepon sudah terdaftar',
            'address.required' => 'Alamat tidak boleh kosong',
            'city.required' => 'Kota tidak boleh kosong',
        ]);

        // update the data
        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->no_telp = $request->phone;
        $customer->alamat = $request->address;
        $customer->kota = $request->city;
        $customer->save();

        return redirect()->route('customer')->with('success', 'Berhasil')->with('description', 'Data customer berhasil diubah');
    }

    public function delete($id)
    {
        $customer = Customer::find($id);
        $customer->delete();

        return redirect()->route('customer')->with('success', 'Berhasil')->with('description', 'Data customer berhasil dihapus');
    }
}
