<?php

namespace Database\Seeders;

use App\Models\Artikel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ArtikelSeeder extends Seeder
{
    public function run()
    {
        DB::table('artikel')->truncate();

        $uploadPath = public_path('uploads/artikel');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $defaultImage = 'origami_indonesia.jpg';
        $sourcePath = database_path('seeders/images/' . $defaultImage);
        $destinationPath = public_path('uploads/artikel/' . $defaultImage);
        
        if (!file_exists($destinationPath) && file_exists($sourcePath)) {
            copy($sourcePath, $destinationPath);
        }

        // Artikel::create([
        //     'judul' => 'Sejarah Origami di Indonesia',
        //     'isi' => '<p>Origami, seni melipat kertas yang berasal dari Jepang, telah menjadi bagian penting dari budaya Indonesia. Seni ini diperkenalkan ke Indonesia pada awal abad ke-20 dan telah berkembang pesat sejak saat itu.</p>
        //              <p>Di Indonesia, origami tidak hanya menjadi hobi, tetapi juga digunakan dalam pendidikan dan terapi. Banyak sekolah dasar mengajarkan origami untuk meningkatkan keterampilan motorik halus anak-anak.</p>
        //              <p>Origami juga menjadi bagian dari industri kreatif Indonesia, dengan banyak pengrajin lokal yang menciptakan karya-karya unik yang menggabungkan teknik origami dengan motif tradisional Indonesia.</p>',
        //     'tanggal_publikasi' => now(),
        //     'gambar' => 'artikel1.jpg'
        // ]);
    }
}
