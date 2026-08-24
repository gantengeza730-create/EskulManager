<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ekskul;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $ekskuls = [
            [
                'title' => 'Futsal',
                'category' => 'Olahraga',
                'coach' => 'Coach Nur Cahyana',
                'description' => 'Mengasah taktik, kerja sama tim, fisik prima, dan sportivitas tinggi melalui futsal.',
                'image' => 'https://images.unsplash.com/photo-1536122985607-4fea00713805?w=800&q=80',
            ],
            [
                'title' => 'Basketball',
                'category' => 'Olahraga',
                'coach' => 'Coach Nur Cahyana',
                'description' => 'Kembangkan akurasi tembakan dan daya tahan fisik bersama tim basket andalan sekolah.',
                'image' => 'https://images.unsplash.com/photo-1519861531473-9200262188bf?w=800&q=80',
            ],
            [
                'title' => 'Programming',
                'category' => 'Teknologi',
                'coach' => 'Pak Dede Dwinarantika',
                'description' => 'Belajar coding, pembuatan web, web design, aplikasi mobile, hingga persiapan LKS SMK bidang IT.',
                'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&q=80',
            ],
            [
                'title' => 'Paduan Suara',
                'category' => 'Seni & Kreatif',
                'coach' => 'Tim Kesenian', // Di gambar tidak terlihat nama pelatihnya
                'description' => 'Mengembangkan kemampuan vokal, kerja sama tim, disiplin, dan percaya diri melalui latihan serta penampilan.',
                'image' => 'https://images.unsplash.com/photo-1551009175-8a68da93d5f9?w=800&q=80',
            ],
            [
                'title' => 'Marching Band',
                'category' => 'Seni & Musik',
                'coach' => 'Bu Nenikormala',
                'description' => 'Latihan musikalitas instrumen tiup dan perkusi dikombinasikan dengan koreografi baris berbaris.',
                'image' => 'https://images.unsplash.com/photo-1573676047242-eb4871d87e07?w=800&q=80',
            ],
            [
                'title' => 'Paskibra',
                'category' => 'Kepemimpinan',
                'coach' => 'Pak Yogarosmant',
                'description' => 'Pembentukan disiplin, karakter tangguh, kesolidan tim, serta persiapan upacara hari besar nasional.',
                'image' => 'https://images.unsplash.com/photo-1532375810709-75b1da00537c?w=800&q=80',
            ],
            [
                'title' => 'Pramuka',
                'category' => 'Kepemimpinan',
                'coach' => 'Pak Itisar',
                'description' => 'Pendidikan kepanduan mandiri, survival alam, tali temali, pembentukan kepemimpinan tanggap.',
                'image' => 'https://images.unsplash.com/photo-1508933221946-b6bafdf6ffbe?w=800&q=80',
            ],
            [
                'title' => 'PMR (Palang Merah Remaja)',
                'category' => 'Kemanusiaan',
                'coach' => 'Pak Elpan',
                'description' => 'Latihan dasar pertolongan pertama, simulasi tanggap bencana, dan kepedulian sosial terhadap kesehatan.',
                'image' => 'https://images.unsplash.com/photo-1584515933487-779824d29309?w=800&q=80',
            ]
        ];

        foreach ($ekskuls as $ekskul) {
            Ekskul::create($ekskul);
        }
    }
}