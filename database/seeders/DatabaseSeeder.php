<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\LevelUser;
use App\Models\Group;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiBarang;
use App\Models\Stock;
use App\Models\Notifikasi;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\StockOpname;
use App\Models\StockOpnameItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed LevelUser
        LevelUser::create([
            'id_level_user' => 1,
            'level_user' => 'Super Admin'
        ]);
        LevelUser::create([
            'id_level_user' => 2,
            'level_user' => 'Admin'
        ]);

        // Seed Users
        $password = Hash::make('123456');
        $superAdmin = User::create([
            'nik' => 'SPRADM',
            'nama' => 'Super Admin',
            'email' => 'default@gmail.com',
            'password' => $password,
            'id_level_user' => 1
        ]);
        $adminAplikasi = User::create([
            'nik' => 'ADMAPK',
            'nama' => 'Admin Aplikasi',
            'email' => 'adminapk@gmail.com',
            'password' => $password,
            'id_level_user' => 2
        ]);
        User::create([
            'nik' => 'T.354778',
            'nama' => 'RACHMAD WAHYUDI, S.T	',
            'email' => 'wahyudi@gmail.com',
            'password' => $password,
            'id_level_user' => 2
        ]);
        User::create([
            'nik' => 'K.230187',
            'nama' => 'AGAM PEBRIAN',
            'email' => 'agam@gmail.com',
            'password' => $password,
            'id_level_user' => 2
        ]);

        // Satuan Unit
        $satuanUnit = Satuan::create([
            'nama' => 'Ea',
            'deskripsi' => 'Ea'
        ]);

        $satuanMeter = Satuan::create([
            'nama' => 'Meter',
            'deskripsi' => 'Meter'
        ]);

        $satuanPack = Satuan::create([
            'nama' => 'Pack',
            'deskripsi' => 'Pack'
        ]);

        // Seed Groups (ISMS dan ATK)
        $GroupISMS = Group::create([
            'nama' => 'ISMS',
            'deskripsi' => 'Peralatan IT dan Sistem Manajemen Keamanan Informasi (misal: komputer, CCTV, kabel, dll)'
        ]);
        $GroupATK = Group::create([
            'nama' => 'ATK',
            'deskripsi' => 'Peralatan kantor seperti kertas, alat tulis, bolpoin, dll'
        ]);

        // Seed Kategori (ISMS)
        $kategoriCctv = Kategori::create([
            'id_group' => $GroupISMS->id_group,
            'nama' => "CCTV",
            'deskripsi' => "CCTV ISMS"
        ]);
        $kategoriKomputer = Kategori::create([
            'id_group' => $GroupISMS->id_group,
            'nama' => "Komputer",
            'deskripsi' => "Komputer ISMS"
        ]);
        $kategoriKabel = Kategori::create([
            'id_group' => $GroupISMS->id_group,
            'nama' => "Kabel",
            'deskripsi' => "Kabel ISMS"
        ]);

        // Seed Kategori (ATK)
        $kategoriKertas = Kategori::create([
            'id_group' => $GroupATK->id_group,
            'nama' => "Kertas",
            'deskripsi' => "Kertas ATK"
        ]);
        $kategoriAlattulis = Kategori::create([
            'id_group' => $GroupATK->id_group,
            'nama' => "Alat Tulis",
            'deskripsi' => "Alat Tulis"
        ]);

        // Seed Barangs (ISMS)
        $barang1 = Barang::create([
            'id_group' => $GroupISMS->id_group,
            'id_kategori' => $kategoriKomputer->id_kategori,
            'nama' => 'Komputer Desktop',
            'deskripsi' => 'Komputer desktop dengan monitor LED dan aksesoris',
            'id_satuan' => $satuanUnit->id_satuan
        ]);
        $barang2 = Barang::create([
            'id_group' => $GroupISMS->id_group,
            'id_kategori' => $kategoriCctv->id_kategori,
            'nama' => 'CCTV Kamera',
            'deskripsi' => 'CCTV kamera untuk pengawasan',
            'id_satuan' => $satuanUnit->id_satuan
        ]);
        $barang3 = Barang::create([
            'id_group' => $GroupISMS->id_group,
            'id_kategori' => $kategoriKabel->id_kategori,
            'nama' => 'Kabel LAN',
            'deskripsi' => 'Kabel untuk jaringan komputer',
            'id_satuan' => $satuanMeter->id_satuan
        ]);

        // Seed Barangs (ATK)
        $barang4 = Barang::create([
            'id_group' => $GroupATK->id_group,
            'id_kategori' => $kategoriKertas->id_kategori,
            'nama' => 'Kertas A4',
            'deskripsi' => 'Kertas ukuran A4 untuk printer',
            'id_satuan' => $satuanPack->id_satuan
        ]);
        $barang5 = Barang::create([
            'id_group' => $GroupATK->id_group,
            'id_kategori' => $kategoriAlattulis->id_kategori,
            'nama' => 'Pensil',
            'deskripsi' => 'Pensil merk standar',
            'id_satuan' => $satuanPack->id_satuan
        ]);
        $barang6 = Barang::create([
            'id_group' => $GroupATK->id_group,
            'id_kategori' => $kategoriAlattulis->id_kategori,
            'nama' => 'Bolpoin',
            'deskripsi' => 'Bolpoin merk premium',
            'id_satuan' => $satuanPack->id_satuan
        ]);

        // Seed Stocks
        Stock::create([
            'id_barang' => $barang1->id_barang,
            'available_stock' => 8
        ]);
        Stock::create([
            'id_barang' => $barang2->id_barang,
            'available_stock' => 9
        ]);
        Stock::create([
            'id_barang' => $barang3->id_barang,
            'available_stock' => 90
        ]);
        Stock::create([
            'id_barang' => $barang4->id_barang,
            'available_stock' => 40
        ]);
        Stock::create([
            'id_barang' => $barang5->id_barang,
            'available_stock' => 15
        ]);
        Stock::create([
            'id_barang' => $barang6->id_barang,
            'available_stock' => 20
        ]);

        // Seed Transaksi (Permintaan Barang) ISMS
        $transaksiRequest = Transaksi::create([
            'id_user' => $superAdmin->id_user,
            'id_group' => $GroupISMS->id_group,
            'tipe' => 'in',
            'penerima' => 'Agam',
            'tanggal' => now(),
            'deskripsi' => 'Pembelian barang peralatan IT'
        ]);
        TransaksiBarang::create([
            'id_transaksi' => $transaksiRequest->id_transaksi,
            'id_barang' => $barang1->id_barang,
            'quantity' => 10,
            'deskripsi' => 'Komputer desktop untuk IT'
        ]);
        TransaksiBarang::create([
            'id_transaksi' => $transaksiRequest->id_transaksi,
            'id_barang' => $barang2->id_barang,
            'quantity' => 10,
            'deskripsi' => 'CCTV kamera untuk keamanan'
        ]);
        TransaksiBarang::create([
            'id_transaksi' => $transaksiRequest->id_transaksi,
            'id_barang' => $barang3->id_barang,
            'quantity' => 100,
            'deskripsi' => 'Kabel LAN untuk jaringan'
        ]);
        // Seed Transaksi (Permintaan Barang) ISMS
        $transaksiRequest = Transaksi::create([
            'id_user' => $superAdmin->id_user,
            'id_group' => $GroupISMS->id_group,
            'tipe' => 'out',
            'penerima' => 'Divisi IT',
            'tanggal' => now(),
            'deskripsi' => 'Untuk Zona 2'
        ]);
        TransaksiBarang::create([
            'id_transaksi' => $transaksiRequest->id_transaksi,
            'id_barang' => $barang1->id_barang,
            'quantity' => 2,
            'deskripsi' => 'Komputer desktop untuk IT'
        ]);
        TransaksiBarang::create([
            'id_transaksi' => $transaksiRequest->id_transaksi,
            'id_barang' => $barang2->id_barang,
            'quantity' => 1,
            'deskripsi' => 'CCTV kamera untuk keamanan'
        ]);
        TransaksiBarang::create([
            'id_transaksi' => $transaksiRequest->id_transaksi,
            'id_barang' => $barang3->id_barang,
            'quantity' => 10,
            'deskripsi' => 'Kabel LAN untuk jaringan'
        ]);

        // Seed Transaksi' (Pembelian Barang)
        $transaksiPurchase = Transaksi::create([
            'id_user' => $adminAplikasi->id_user,
            'id_group' => $GroupATK->id_group,
            'tipe' => 'in',
            'penerima' => 'Agam Febrian',
            'tanggal' => now(),
            'deskripsi' => 'Pembelian barang peralatan kantor'
        ]);
        TransaksiBarang::create([
            'id_transaksi' => $transaksiPurchase->id_transaksi,
            'id_barang' => $barang4->id_barang,
            'quantity' => 50,
            'deskripsi' => 'Kertas A4 untuk keperluan kantor'
        ]);
        TransaksiBarang::create([
            'id_transaksi' => $transaksiPurchase->id_transaksi,
            'id_barang' => $barang5->id_barang,
            'quantity' => 30,
            'deskripsi' => 'Pensil untuk kebutuhan kantor'
        ]);
        TransaksiBarang::create([
            'id_transaksi' => $transaksiPurchase->id_transaksi,
            'id_barang' => $barang6->id_barang,
            'quantity' => 40,
            'deskripsi' => 'Bolpoin untuk keperluan kantor'
        ]);

        // Seed Transaksi' (Pengambilan Barang)
        $transaksiPurchase = Transaksi::create([
            'id_user' => $adminAplikasi->id_user,
            'id_group' => $GroupATK->id_group,
            'tipe' => 'out',
            'penerima' => 'Nanang',
            'tanggal' => now(),
            'deskripsi' => 'Pengambilan barang peralatan kantor'
        ]);
        TransaksiBarang::create([
            'id_transaksi' => $transaksiPurchase->id_transaksi,
            'id_barang' => $barang4->id_barang,
            'quantity' => 10,
            'deskripsi' => 'Kertas A4 untuk keperluan kantor'
        ]);
        TransaksiBarang::create([
            'id_transaksi' => $transaksiPurchase->id_transaksi,
            'id_barang' => $barang5->id_barang,
            'quantity' => 15,
            'deskripsi' => 'Pensil untuk kebutuhan kantor'
        ]);
        TransaksiBarang::create([
            'id_transaksi' => $transaksiPurchase->id_transaksi,
            'id_barang' => $barang6->id_barang,
            'quantity' => 20,
            'deskripsi' => 'Bolpoin untuk keperluan kantor'
        ]);

        // Seed Notifikasi
        Notifikasi::create([
            'id_user_pengirim' => $superAdmin->id_user,
            'id_user_penerima' => $adminAplikasi->id_user,
            'judul' => 'Notifikasi Pengajuan Barang',
            'isi' => 'Permintaan barang peralatan IT telah diajukan oleh Super Admin.',
            'status' => 1,
        ]);
        Notifikasi::create([
            'id_user_pengirim' => $adminAplikasi->id_user,
            'id_user_penerima' => $superAdmin->id_user,
            'judul' => 'Notifikasi Pembelian Barang',
            'isi' => 'Pembelian barang peralatan kantor telah diproses oleh Admin Aplikasi.',
            'status' => 1,
        ]);

        // seed stock opname ISMS
        $stock_opname_isms = StockOpname::create([
            'id_user' => $adminAplikasi->id_user,
            'id_group' => $GroupISMS->id_group,
            'tanggal' => now(),
            'deskripsi' => "Melakukan stock opname akhir bulan"
        ]);
        $barangs = Barang::with('stock')->where('id_group',$GroupISMS->id_group)->get();
        foreach ($barangs as $key => $item) {
            StockOpnameItem::create([
                'id_stock_opname' => $stock_opname_isms->id_stock_opname,
                'id_barang' => $item->id_barang,
                'stock_sistem' => $item->stock->stock_available,
                'stock_fisik' => $item->stock->stock_available - 1,
                'selisih' => 1,
                'alasan' => 'Barang sudah rusak'
            ]);
        }
        // seed stock opname ATK 
        $stock_opname_atk = StockOpname::create([
            'id_user' => $adminAplikasi->id_user,
            'id_group' => $GroupATK->id_group,
            'tanggal' => now(),
            'deskripsi' => "Melakukan stock opname akhir bulan"
        ]);
        $barangs = Barang::with('stock')->where('id_group',$GroupATK->id_group)->get();
        foreach ($barangs as $key => $item) {
            StockOpnameItem::create([
                'id_stock_opname' => $stock_opname_atk->id_stock_opname,
                'id_barang' => $item->id_barang,
                'stock_sistem' => $item->stock->stock_available,
                'stock_fisik' => $item->stock->stock_available - 1,
                'selisih' => 1,
                'alasan' => 'Barang sudah rusak'
            ]);
        }

        $barang_atk = [
            ['nama_barang' => "BUKU JURNAL POS ISI 200"],
            ['nama_barang' => "BUKU JURNAL POS ISI 100"],
            ['nama_barang' => "BUKU CHECKLIST CCTV"],
            ['nama_barang' => "BUKU GATE PASS TAMU"],
            ['nama_barang' => "BUKU ANGKUTAN HASIL PRODUKSI"],
            ['nama_barang' => "BUKU ANGKUTAN TRUCK/PUPUK"],
            ['nama_barang' => "BUKU TAMU"],
            ['nama_barang' => "BUKU TAMU AREA TERTUTUP"],
            ['nama_barang' => "BUKU PENITIPAN KUNCI"],
            ['nama_barang' => "BUKU FREKUENSI"],
            ['nama_barang' => "BUKU CHECKLIST PERSONIL & INVENTARISIR"],
            ['nama_barang' => "BUKU CHECKLIST PATROLI"],
            ['nama_barang' => "BUKU KELUAR MASUK BARANG"],
            ['nama_barang' => "BUKU CATATAN KENDARAAN DINAS"],
            ['nama_barang' => "BUKU JURNAL HARIAN LT.8"],
            ['nama_barang' => "KERTAS A4"],
            ['nama_barang' => "KERTAS F4"],
            ['nama_barang' => "KERTAS AMANO"],
            ['nama_barang' => "BATERAI AAA3 (KECIL)"],
            ['nama_barang' => "BATERAI AA3 (SEDANG) JAM"],
            ['nama_barang' => "BATERAI A3 (TANGGUNG)"],
            ['nama_barang' => "BATERAI A (BESAR)"],
            ['nama_barang' => "BATERAI KOTAK"],
            ['nama_barang' => "SPIDOL BOARD MARKER HITAM"],
            ['nama_barang' => "SPIDOL BOARD MARKER BIRU"],
            ['nama_barang' => "SPIDOL BOARD MARKER MERAH"],
            ['nama_barang' => "SPIDOL PERMANENT MARKER HITAM"],
            ['nama_barang' => "SPIDOL PERMANENT MARKER BLUE"],
            ['nama_barang' => "SPIDOL PERMANENT MARKER RED"],
            ['nama_barang' => "SPIDOL BESAR BLACK MARKER 500"],
            ['nama_barang' => "SPIDOL BESAR BLUE MARKER 500"],
            ['nama_barang' => "PENSIL STADLER 2B"],
            ['nama_barang' => "PENGHAPUS STADLER"],
            ['nama_barang' => "PENGHAPUS PELIKAN"],
            ['nama_barang' => "JEPITAN ID CARD MODEL LAMA"],
            ['nama_barang' => "RE-TYPE/STIPO/TIPE-X"],
            ['nama_barang' => "REMOVER STAPLES"],
            ['nama_barang' => "ISI STAPLES 23/10"],
            ['nama_barang' => "ISI STAPLES 23/13"],
            ['nama_barang' => "ISI STAPLES 23/15"],
            ['nama_barang' => "ISI STAPLES 23/17"],
            ['nama_barang' => "ISI STAPLES 24/6"],
            ['nama_barang' => "ISI STAPLES 10-1 M"],
            ['nama_barang' => "TINTA SPIDOL/REFILL BIRU"],
            ['nama_barang' => "TINTA SPIDOL/REFILL HITAM"],
            ['nama_barang' => "TINTA STAMPEL UNGU"],
            ['nama_barang' => "TINTA STAMPEL BIRU"],
            ['nama_barang' => "TINTA STAMPEL HITAM"],
            ['nama_barang' => "BOLPOIN"],
            ['nama_barang' => "BUKU EXPEDISI"],
            ['nama_barang' => "STABILLO WARNA WARNI"],
            ['nama_barang' => "SOLASI UKURAN 1/4 BENING (KECIL)"],
            ['nama_barang' => "SOLASI UKURAN 1 BENING (BESAR)"],
            ['nama_barang' => "SOLASI UKURAN 1/2 BENING (SEDANG)"],
            ['nama_barang' => "LAKBAN HITAM UKURAN 1 (BESAR)"],
            ['nama_barang' => "NOTES 76 X 51 MM - 3 X 2 INCH"],
            ['nama_barang' => "GLUE STICK/UHU STICK BANTEX LEM KERTAS"],
            ['nama_barang' => "LEM CASTOL"],
            ['nama_barang' => "AMPLOP BESAR"],
            ['nama_barang' => "AMPLOP KECIL"],
            ['nama_barang' => "PENGGARIS 60 CM PLAT"],
            ['nama_barang' => "NOTES 40 MM X 12 MM"],
            ['nama_barang' => "POST-IT SIGH HERE"],
            ['nama_barang' => "CUTTER BESAR L-500"],
            ['nama_barang' => "CUTTER KECIL A-300"],
            ['nama_barang' => "ISI CUTTER L-150"],
            ['nama_barang' => "ISI CUTTER BA-100"],
            ['nama_barang' => "STAPLER HD-50"],
            ['nama_barang' => "STAPLER HD-10"],
            ['nama_barang' => "GUNTING SEDANG"],
            ['nama_barang' => "DOUBLE TAPE 1/2"],
            ['nama_barang' => "PEPER CLIPS"],
            ['nama_barang' => "BINDER CLIPS NO. 155"],
            ['nama_barang' => "BINDER CLIPS NO. 111"],
            ['nama_barang' => "BINDER CLIPS NO. 107"],
            ['nama_barang' => "PENGGARIS 30 CM PLAT"],
            ['nama_barang' => "PITA MESIN TIK"],
            ['nama_barang' => "STAMP PAD RUBBER STAMP"],
            ['nama_barang' => "DATE STAMP/TRODAT"],
            ['nama_barang' => "SCOTCH SELO TYPE"],
            ['nama_barang' => "RAUTAN / OROTAN"],
            ['nama_barang' => "BOARD ERASER"],
            ['nama_barang' => "LAMINATING FILM F4 / A4"],
            ['nama_barang' => "KARET GELANG"],
            ['nama_barang' => "IBM RIBBON CASETTTE"],
            ['nama_barang' => "BUKU CATATAN KELUAR MASUK KAPAL"],
            ['nama_barang' => "PENGHAPUS PAPAN"],
            ['nama_barang' => "BENDERA MERAH PUTIH"],
            ['nama_barang' => "LEM KERTAS BIASA"],
            ['nama_barang' => "MAP PLASTIK JEPIT FILE A350 SG"],
            ['nama_barang' => "CLIP BOARD"],
            ['nama_barang' => "TINTA STAMPLE FLASH"],
            ['nama_barang' => "KERTAS BUFFALO WARNA BIRU"],
            ['nama_barang' => "BATERAI REMOT GATE PORTAL"],
            ['nama_barang' => "ADHESIVE LABLE"],
            ['nama_barang' => "MAP MODE PLONG"],
            ['nama_barang' => "AMPLOP PG KECIL"],
            ['nama_barang' => "AMPLOP PG SEDANG"],
            ['nama_barang' => "AMPLOP PG BESAR"],
        ];

        
    }
}
