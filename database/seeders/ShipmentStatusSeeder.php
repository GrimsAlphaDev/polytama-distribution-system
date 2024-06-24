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
            ['name' => 'Menunggu Konfirmasi Transporter'],
            ['name' =>'Pesanan Ditolak oleh Transporter'],
            ['name' =>'Driver dan Armada Telah Dipilih'],
            ['name' =>'Truck Menuju Gudang'],
            ['name' =>'Truck Tiba di Gudang'],
            ['name' =>'Pesanan Di Proses Oleh Tim Logistik'],
            ['name' =>'Surat Jalan Telah Diterbitkan'],
            ['name' =>'Driver Mengirim Pesanan'],
            ['name' =>'Pesanan Telah Diterima Customer'],
        ];

        foreach ($shipmentStatus as $status) {
            ShipmentStatus::create($status);
        }

    }
}
