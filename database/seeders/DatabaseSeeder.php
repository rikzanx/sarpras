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

        // Satuan Unit
        $satuanUnit = Satuan::create([
            'nama' => 'Unit',
            'deskripsi' => 'Unit'
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
            'penerima' => 'Divisi IT',
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
    }
}
