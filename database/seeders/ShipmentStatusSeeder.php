<?php

namespace Database\Seeders;

use App\Models\ShipmentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShipmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shipmentStatus = [
            ['name' =>'Menunggu Konfirmasi Transporter'],
            ['name' =>'Pesanan Ditolak oleh Transporter'],
            ['name' =>'Driver dan Armada Telah Dipilih'],
            ['name' =>'Driver Menuju Gudang'],
            ['name' =>'Truck Tiba di Gudang'],
            ['name' =>'Logistik Dilakukan Penimbangan Pertama'],
            ['name' =>'Logistik Melakukan Loading Barang'],
            ['name' =>'Logistik Melakukan Timbangan Kedua'],
            ['name' =>'Surat Jalan Telah Diterbitkan'],
            ['name' =>'Driver Mengirim Pesanan'],
            ['name' =>'Pesanan Telah Selesai dan Produk Berhasil Diterima Customer'],
        ];

        foreach ($shipmentStatus as $status) {
            ShipmentStatus::create($status);
        }

    }
}
