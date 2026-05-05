<?php
// ============================================================
// FILE: database/seeders/DatabaseSeeder.php
// ============================================================
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Genre, Band};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@bandspk.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Anggota
        $anggota = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'anggota@bandspk.com',
            'password' => Hash::make('password'),
            'role'     => 'anggota',
        ]);

        // Genre
        $genres = ['Pop', 'Rock', 'Jazz', 'R&B', 'Indie', 'Dangdut', 'Metal', 'Blues'];
        $genreIds = [];
        foreach ($genres as $g) {
            $genre = Genre::create(['nama_genre' => $g]);
            $genreIds[$g] = $genre->id;
        }

        // Band data: [nama_band, genre, lokasi, tahun_berdiri, pengikut, biaya_sewa, deskripsi]
        $bandsData = [
            // ── Data asli ────────────────────────────────────────────────────
            ['Sinaraya',      'Pop',     'Surabaya',   2016, 120000,  5000000,  'Band pop asal Surabaya yang energik.'],
            ['Gemuruh',       'Rock',    'Malang',     2013, 89000,   7000000,  'Band rock berpengalaman dari Malang.'],
            ['Kelabu',        'Jazz',    'Surabaya',   2015, 67000,   4000000,  'Jazz modern yang menawan.'],
            ['RhythmMore',    'R&B',     'Surabaya',   2018, 45000,   3500000,  'Band R&B modern.'],
            ['Langit Biru',   'Indie',   'Yogyakarta', 2019, 32000,   2500000,  'Indie folk dari Jogja.'],
            ['CahayaNada',    'Pop',     'Surabaya',   2019, 80000,   3000000,  'Pop hits Indonesia.'],
            ['Mentari',       'Pop',     'Surabaya',   2012, 55000,   7000000,  'Pop senior berpengalaman.'],
            ['BintangSore',   'Pop',     'Surabaya',   2021, 40000,   2500000,  'Pop fresh generation.'],
            ['Resonansi',     'Pop',     'Surabaya',   2018, 65000,   6000000,  'Pop dengan nuansa orkestra.'],
            ['PantaiSelatan', 'Pop',     'Surabaya',   2014, 92000,   7500000,  'Pop asal Surabaya yang terbentuk pada tahun 2014. Dengan pengalaman lebih dari 10 tahun, band ini telah tampil di berbagai acara bergengsi.'],
            ['BumiPertiwi',   'Dangdut', 'Jakarta',    2010, 150000,  10000000, 'Dangdut queen dari Jakarta.'],
            ['MetroPolis',    'Indie',   'Bandung',    2020, 25000,   2000000,  'Indie alternative Bandung.'],

            // ── Pop tambahan ─────────────────────────────────────────────────
            ['Mahalini',      'Pop',     'Bali',       2019, 2100000, 8000000,  'Pop ballad hits fenomenal dari Bali.'],
            ['Tiara Andini',  'Pop',     'Jakarta',    2020, 1800000, 7500000,  'Penyanyi pop juara Indonesian Idol.'],
            ['Ziva Magnolya', 'Pop',     'Jakarta',    2020, 900000,  6500000,  'Pop penuh ekspresi dari Jakarta.'],
            ['Lyodra',        'Pop',     'Medan',      2020, 1500000, 9000000,  'Vokal powerhouse dari Medan.'],
            ['Tulus',         'Pop',     'Padang',     2011, 3000000, 15000000, 'Pop soul fenomenal dari Padang.'],
            ['Rizky Febian',  'Pop',     'Bandung',    2016, 1400000, 10000000, 'Pop romantis asal Bandung.'],
            ['Kunto Aji',     'Pop',     'Yogyakarta', 2013, 800000,  8500000,  'Pop introspektif dari Yogyakarta.'],
            ['Raisa',         'Pop',     'Jakarta',    2011, 2500000, 18000000, 'Ratu pop Indonesia.'],
            ['Isyana Sarasvati','Pop',   'Bandung',    2015, 1800000, 12000000, 'Pop klasikal bersuara unik.'],
            ['Yura Yunita',   'Pop',     'Bandung',    2014, 1000000, 9000000,  'Pop penuh warna dari Bandung.'],
            ['Afgan',         'Pop',     'Jakarta',    2008, 2200000, 15000000, 'Bintang pop pria Indonesia.'],
            ['Judika',        'Pop',     'Medan',      2008, 1600000, 14000000, 'Pop bertenaga dari Sumatera Utara.'],
            ['Cakra Khan',    'Pop',     'Jakarta',    2012, 900000,  10000000, 'Pop melankolis bervokal kuat.'],
            ['Rossa',         'Pop',     'Sumedang',   1996, 2000000, 20000000, 'Legenda pop wanita Indonesia.'],
            ['Sheila On 7',   'Pop',     'Yogyakarta', 1996, 1500000, 20000000, 'Legenda pop rock Yogyakarta.'],
            ['Naif',          'Pop',     'Jakarta',    1995, 300000,  8000000,  'Pop retro ikonik dari Jakarta.'],
            ['Geisha',        'Pop',     'Pekanbaru',  2006, 400000,  7000000,  'Pop manis dari Pekanbaru.'],

            // ── Rock tambahan ────────────────────────────────────────────────
            ['Noah',          'Rock',    'Jakarta',    1996, 4000000, 25000000, 'Legenda rock Indonesia.'],
            ['Padi Reborn',   'Rock',    'Surabaya',   1994, 1200000, 18000000, 'Rock melodius dari Surabaya.'],
            ['Dewa 19',       'Rock',    'Surabaya',   1986, 3500000, 30000000, 'Ikon rock Indonesia sejak 1986.'],
            ['Slank',         'Rock',    'Jakarta',    1983, 2800000, 25000000, 'Rock gaul legendaris dari Jakarta.'],
            ['Gigi',          'Rock',    'Bandung',    1994, 800000,  15000000, 'Rock dinamis asal Bandung.'],
            ['Superman Is Dead','Rock',  'Bali',       1995, 600000,  12000000, 'Punk rock energik dari Bali.'],
            ['Kotak',         'Rock',    'Jakarta',    2004, 350000,  8000000,  'Rock wanita bersuara keras.'],
            ['Ungu',          'Rock',    'Jakarta',    1996, 900000,  12000000, 'Rock religi populer di Indonesia.'],
            ['Peterpan',      'Rock',    'Bandung',    2000, 2000000, 15000000, 'Rock pop ikonik dari Bandung.'],
            ['Barasuara',     'Rock',    'Jakarta',    2013, 500000,  7000000,  'Art rock modern dari Jakarta.'],

            // ── Jazz tambahan ────────────────────────────────────────────────
            ['Ardhito Pramono','Jazz',   'Jakarta',    2018, 650000,  6500000,  'Jazz pop modern dari Jakarta.'],
            ['Mocca',          'Jazz',   'Bandung',    2000, 400000,  9000000,  'Jazz pop manis dari Bandung.'],
            ['Maliq DEssentials','Jazz', 'Jakarta',    2002, 600000,  12000000, 'Jazz soul groovy dari Jakarta.'],
            ['Tompi',          'Jazz',   'Jakarta',    2003, 300000,  9000000,  'Jazz smooth dari Jakarta.'],
            ['Sandhy Sondoro', 'Jazz',   'Jakarta',    2008, 250000,  8000000,  'Jazz blues nuansa internasional.'],

            // ── R&B tambahan ─────────────────────────────────────────────────
            ['Agnez Mo',      'R&B',     'Jakarta',    2003, 5000000, 35000000, 'R&B pop bintang internasional.'],
            ['Weird Genius',  'R&B',     'Jakarta',    2017, 900000,  12000000, 'Electronic R&B hits dari Jakarta.'],
            ['Awkarin',       'R&B',     'Jakarta',    2016, 800000,  7000000,  'R&B pop digital native.'],
            ['Rendy Pandugo', 'R&B',     'Jakarta',    2016, 500000,  7000000,  'R&B soul modern Jakarta.'],

            // ── Indie tambahan ───────────────────────────────────────────────
            ['Gild Acoustic', 'Indie',   'Bandung',    2017, 45000,   3500000,  'Akustik folk segar dari Bandung.'],
            ['Nadin Amizah',  'Indie',   'Jakarta',    2018, 600000,  5000000,  'Indie folk melankolis dari Jakarta.'],
            ['Hindia',        'Indie',   'Jakarta',    2017, 550000,  5500000,  'Indie introspektif dari Jakarta.'],
            ['Pamungkas',     'Indie',   'Yogyakarta', 2016, 1200000, 6000000,  'Indie pop romantis dari Yogyakarta.'],
            ['Reality Club',  'Indie',   'Jakarta',    2016, 400000,  4500000,  'Indie pop segar dari Jakarta.'],
            ['Danilla',       'Indie',   'Jakarta',    2014, 350000,  5000000,  'Indie pop kelam dari Jakarta.'],
            ['Fourtwnty',     'Indie',   'Jakarta',    2014, 700000,  6000000,  'Indie folk meditatif dari Jakarta.'],
            ['Payung Teduh',  'Indie',   'Jakarta',    2007, 1100000, 8000000,  'Folk indie melankolis Jakarta.'],

            // ── Dangdut tambahan ─────────────────────────────────────────────
            ['Ajeng Febria',  'Dangdut', 'Blora',      2016, 120000,  4500000,  'Penyanyi dangdut josjis dari Blora.'],
            ['Rhoma Irama',   'Dangdut', 'Jakarta',    1970, 2000000, 30000000, 'Raja dangdut Indonesia.'],
            ['Inul Daratista','Dangdut', 'Pasuruan',   2001, 2200000, 18000000, 'Dangdut goyang fenomenal.'],
            ['Dewi Perssik',  'Dangdut', 'Jember',     2001, 1500000, 15000000, 'Dangdut seksi dari Jember.'],
            ['Via Vallen',    'Dangdut', 'Surabaya',   2010, 3000000, 20000000, 'Ratu koplo dari Surabaya.'],
            ['Nella Kharisma','Dangdut', 'Kediri',     2012, 2500000, 15000000, 'Koplo manis dari Kediri.'],
            ['Denny Caknan',  'Dangdut', 'Ngawi',      2018, 2800000, 18000000, 'Koplo viral dari Ngawi.'],
            ['Happy Asmara',  'Dangdut', 'Blitar',     2017, 1800000, 12000000, 'Koplo ceria dari Blitar.'],

            // ── Metal tambahan ───────────────────────────────────────────────
            ['Burgerkill',    'Metal',   'Bandung',    1995, 400000,  10000000, 'Heavy metal terdepan dari Bandung.'],
            ['Seringai',      'Metal',   'Jakarta',    2002, 200000,  8000000,  'Metal punk garang dari Jakarta.'],
            ['Deadsquad',     'Metal',   'Jakarta',    2007, 180000,  7500000,  'Technical death metal Jakarta.'],

            // ── Blues tambahan ───────────────────────────────────────────────
            ['Gugun Blues Shelter','Blues','Jakarta',  2003, 100000,  8000000,  'Blues rock terbaik Indonesia.'],
            ['Iwan Fals',     'Blues',   'Bogor',      1975, 5000000, 30000000, 'Legenda folk blues Indonesia.'],
        ];

        foreach ($bandsData as [$nama, $genre, $lokasi, $tahun, $pengikut, $biaya, $deskripsi]) {
            $user = User::create([
                'name'     => $nama,
                'email'    => strtolower(str_replace([' ', '&'], ['', ''], $nama)) . '@band.com',
                'password' => Hash::make('password'),
                'role'     => 'band',
            ]);
            Band::create([
                'user_id'       => $user->id,
                'genre_id'      => $genreIds[$genre],
                'nama_band'     => $nama,
                'lokasi'        => $lokasi,
                'tahun_berdiri' => $tahun,
                'pengikut'      => $pengikut,
                'biaya_sewa'    => $biaya,
                'deskripsi'     => $deskripsi,
            ]);
        }
    }
}