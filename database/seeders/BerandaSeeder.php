<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BerandaSeeder extends Seeder
{
    public function run()
    {
        DB::table('beranda')->insert([
            'instagram'     => 'pbtcmasmansur',
            'email'         => 'info@pesma.com',
            'whatsapp'      => '6282122687848',
            'location'      => 'PESMA KH Mas Mansur, Jl. A. Yani Pabelan Kartasura Tromol Pos 1 Surakarta, 577102',
            'maps_link'     => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3677.1383426983098!2d110.76720697465457!3d-7.548651192464935!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a159cd3393015%3A0x45a81e6db67a375d!2sPESMA%20KH%20MAS%20MANSUR%20UMS!5e1!3m2!1sid!2sid!4v1762902769774!5m2!1sid!2sid',

            'slider1_image' => 'storage/img/qNbHp2wXtM0veDN7NEUC5vXIkxvChnFnYTDE5SdF.jpg',
            'slider1_text'  => 'Pesma Inn
KH. Mas Mansur', 

            'slider2_image' => 'storage/img/J7Yc05Q4cRfHsDhencnP29lODSIhXxxhXxkvStQy.jpg',
            'slider2_text'  => 'PESMA Inn difokuskan sebagai tempat penginapan dengan fasilitas setara hotel, harga yang terjangkau, serta lokasi yang sangat strategis karena dekat dengan Kampus dan Edutorium Universitas Muhammadiyah Surakarta.f',

            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }
}