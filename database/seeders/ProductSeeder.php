<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Masplene', 'description' => 'Pellet merupakan bahan polipropilen murni yang telah melalui proses peleburan dalam ekstrusi Pellet. Dengan merek dagang Masplene®. Produk polipropilena Polytama telah mendapatkan Sertifikat Halal dari Majelis Ulama Indonesia (MUI)', 'price' => 700000, 'weight' => 25 , 'stock' => 500, 'status' => 'ready'],
            ['name' => 'Granule', 'description' => 'Granule merupakan produk inovatif Polytama yang telah dipasarkan sejak Agustus 2017. Granule merupakan partikel yang terbentuk sebagai hasil pembesaran progresif dari partikel primer. Produk inovasi ini merupakan langkah terobosan Polytama untuk menciptakan segmen pasar tersendiri di tengah persaingan pasar polipropilena di Indonesia', 'price' => 2000000, 'weight' => 100, 'stock' => 600, 'status' => 'ready']
        ];

        foreach ($products as $product) {
            \App\Models\product::create($product);
        }
    }
}
