<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Group;
use App\Models\Satuan;
use App\Models\Barang;
use App\Models\Stock;
use App\Models\TransaksiBarang;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    //================ ISMS================//
    public function isms_stock_barang()
    {
        $satuan = Satuan::get();
        $group = Group::get();
        $barangs = Barang::with(['kategori','satuan','group','stock','transaksi_masuk','transaksi_keluar','stock_opname'])
        ->withSum(['transaksi_masuk as total_barang_masuk'], 'transaksi_barangs.quantity')
        ->withSum(['transaksi_keluar as total_barang_keluar'], 'transaksi_barangs.quantity')
        ->withSum(['stock_opname as total_opname'], 'stock_opname_items.selisih')
        ->where('id_group',1)->get();
        dd($barangs);
        return view('transaksi/isms_stock_barang',[
            'barangs' => $barangs,
            'satuan' => $satuan,
            'group' => $group
        ]);
    }

    public function isms_show_transaksi_barang($id_transaksi)
    {
        $decryptId = Crypt::decryptString($id_transaksi);
        $transaksi = Transaksi::with(['transaksi_barangs'])->withCount('transaksi_barangs')->withSum('transaksi_barangs as total_barang', 'quantity')
        ->where('id_group',1)->where('id_transaksi',$decryptId)->firstOrFail();

        return response()->json($transaksi);
    }

    public function isms_list_transaksi_barang_masuk()
    {
        $transaksi_barang_masuk = Transaksi::with(['transaksi_barangs','group'])->withCount('transaksi_barangs')->withSum('transaksi_barangs as total_barang', 'quantity')->where('tipe','in')
        ->where('id_group',1)->get();
        $transaksi_barang_masuk->map(function($item){
            // dd($item);
        });
        $group = Group::get();
        $satuan = Satuan::get();
        $barang = Barang::where('id_group',1)->get();
        return view('transaksi/isms_list_transaksi_barang_masuk',[
            'transaksi_barang_masuk' => $transaksi_barang_masuk,
            'group' => $group,
            'satuan' => $satuan,
            'barang' => $barang   
        ]);
    }

    public function isms_add_transaksi_barang_masuk_action(Request $request)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'barang.*.id_barang' => 'required|exists:barangs,id_barang',
            'barang.*.quantity' => 'required|integer|min:1',
        ],$messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            $transaksi = Transaksi::create([
                "id_user" => Auth()->user()->id_user,
                "id_group" => 1,
                "tanggal" => Carbon::parse($request->tanggal)->format('Y-m-d H:i:s'),
                "deskripsi" => $request->deskripsi,
                "penerima" => $request->penerima,
                "tipe" => "in",
            ]);

            foreach($request->barang as $item){
                TransaksiBarang::create([
                    "id_transaksi" => $transaksi->id_transaksi,
                    "id_barang" => $item['id_barang'],
                    "quantity" => $item['quantity'],
                ]);
                $stock = Stock::where('id_barang',$item['id_barang'])->first();
                if($stock){
                    $stock->available_stock += $item['quantity'];
                    $stock->save();
                }else{
                    Stock::create([
                        "id_barang" => $item['id_barang'],
                        "available_stock" => $item['quantity'],
                    ]);
                }
            }
            DB::commit();

            return redirect()->route('isms_list_transaksi_barang_masuk')->with('success', "Sukses Menambahkan Data");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat menambah data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }

    public function isms_edit_transaksi_barang_masuk_action(Request $request, $id_transaksi)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];

        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'barang.*.id_barang' => 'required|exists:barangs,id_barang',
            'barang.*.quantity' => 'required|integer|min:1',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $decryptId = Crypt::decryptString($id_transaksi);
            $transaksi = Transaksi::with(['transaksi_barangs'])->where('id_transaksi', $decryptId)->firstOrFail();

            // Update transaksi
            $transaksi->update([
                "tanggal" => Carbon::parse($request->tanggal)->format('Y-m-d H:i:s'),
                "deskripsi" => $request->deskripsi,
                "penerima" => $request->penerima,
            ]);

            // Ambil semua barang ID dari request
            $inputBarangIds = collect($request->barang)->pluck('id_transaksi_barang')->filter()->all();
            $existingBarangIds = $transaksi->transaksi_barangs->pluck('id_transaksi_barang')->all();

            // Hapus barang yang tidak ada di input
            $toBeDeleted = array_diff($existingBarangIds, $inputBarangIds);

            foreach ($toBeDeleted as $idToDelete) {
                $transaksiBarang = TransaksiBarang::find($idToDelete);

                if ($transaksiBarang) {
                    $stock = Stock::where('id_barang', $transaksiBarang->id_barang)->first();
                    if ($stock) {
                        $stock->available_stock += $transaksiBarang->quantity;
                        $stock->save();
                    }
                    $transaksiBarang->delete();
                }
            }

            // Update atau tambahkan barang
            foreach ($request->barang as $item) {
                $quantity = $item['quantity'];
                $idBarang = $item['id_barang'];

                if (isset($item['id_transaksi_barang'])) {
                    // Update barang yang ada
                    $transaksiBarang = TransaksiBarang::findOrFail($item['id_transaksi_barang']);
                    $stock = Stock::where('id_barang', $idBarang)->first();

                    $difference = $quantity - $transaksiBarang->quantity;

                    if ($difference != 0 && $stock) {
                        $stock->available_stock += $difference;
                        $stock->save();
                    }

                    $transaksiBarang->update([
                        'quantity' => $quantity,
                    ]);
                } else {
                    // Tambahkan barang baru
                    TransaksiBarang::create([
                        "id_transaksi" => $transaksi->id_transaksi,
                        "id_barang" => $idBarang,
                        "quantity" => $quantity,
                    ]);

                    $stock = Stock::where('id_barang', $idBarang)->first();
                    if ($stock) {
                        $stock->available_stock += $quantity;
                    } else {
                        $stock = Stock::create([
                            "id_barang" => $idBarang,
                            "available_stock" => $quantity,
                        ]);
                    }
                    $stock->save();
                }
            }

            DB::commit();
            return redirect()->route('isms_list_transaksi_barang_masuk')->with('success', "Sukses Menambahkan Data");
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', "Terjadi Kesalahan: " . $e->getMessage());
        }
    }

    public function isms_delete_transaksi_barang_masuk_action($id_transaksi)
    {
        DB::beginTransaction();

        try {
            $decryptId = Crypt::decryptString($id_transaksi);
            $transaksi = Transaksi::with(['transaksi_barangs'])->where('id_transaksi', $decryptId)->firstOrFail();

            // Menghapus setiap transaksi barang yang terkait dan mengembalikan stok yang ditambahkan
            foreach ($transaksi->transaksi_barangs as $transaksiBarang) {
                $stock = Stock::where('id_barang', $transaksiBarang->id_barang)->first();
                if ($stock) {
                    // Mengecek apakah stok cukup untuk dikurangi (dalam kasus barang masuk, kita kurangi stok)
                    if ($stock->available_stock < $transaksiBarang->quantity) {
                        DB::rollback();
                        return redirect()->back()->with('error', 'Stok tidak mencukupi untuk pengembalian barang.');
                    }

                    $stock->available_stock -= $transaksiBarang->quantity; // Kurangi stok yang ditambah
                    $stock->save();
                }
                $transaksiBarang->delete(); // Hapus transaksi barang
            }

            // Hapus transaksi itu sendiri
            $transaksi->delete();

            DB::commit();
            return redirect()->route('isms_list_transaksi_barang_masuk')->with('success', 'Transaksi barang masuk berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus transaksi: ' . $e->getMessage());
        }
    }

    public function isms_list_transaksi_barang_keluar()
    {
        $transaksi_barang_keluar = Transaksi::with(['transaksi_barangs','group'])->withCount('transaksi_barangs')->withSum('transaksi_barangs as total_barang', 'quantity')->where('tipe','out')
        ->where('id_group',1)->get();
        $transaksi_barang_keluar->map(function($item){
            // dd($item);
        });
        $group = Group::get();
        $satuan = Satuan::get();
        $barang = Barang::where('id_group',1)->get();
        return view('transaksi/isms_list_transaksi_barang_keluar',[
            'transaksi_barang_keluar' => $transaksi_barang_keluar,
            'group' => $group,
            'satuan' => $satuan,
            'barang' => $barang   
        ]);
    }

    public function isms_add_transaksi_barang_keluar_action(Request $request)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'barang.*.id_barang' => 'required|exists:barangs,id_barang',
            'barang.*.quantity' => 'required|integer|min:1',
        ],$messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            $transaksi = Transaksi::create([
                "id_user" => Auth()->user()->id_user,
                "id_group" => 1,
                "tanggal" => Carbon::parse($request->tanggal)->format('Y-m-d H:i:s'),
                "deskripsi" => $request->deskripsi,
                "penerima" => $request->penerima,
                "tipe" => "out",
            ]);

            foreach($request->barang as $item){
                TransaksiBarang::create([
                    "id_transaksi" => $transaksi->id_transaksi,
                    "id_barang" => $item['id_barang'],
                    "quantity" => $item['quantity'],
                ]);
                $stock = Stock::where('id_barang',$item['id_barang'])->first();
                if($stock){
                    if($stock->available_stock < $item['quantity']){
                        DB::rollback();
                        return redirect()->back()->with('error', 'Stok tidak mencukupi untuk pengurangan.');
                    }
                    $stock->available_stock -= $item['quantity'];
                    $stock->save();
                }else{
                    DB::rollback();
                    return redirect()->back()->with('error', 'Stok tidak mencukupi untuk pengurangan.');
                }
            }
            DB::commit();

            return redirect()->route('isms_list_transaksi_barang_keluar')->with('success', "Sukses Menambahkan Data");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat menambah data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }

    public function isms_edit_transaksi_barang_keluar_action(Request $request, $id_transaksi)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];

        // Validasi request input
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'barang.*.id_barang' => 'required|exists:barangs,id_barang',
            'barang.*.quantity' => 'required|integer|min:1',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            // Dekripsi ID transaksi
            $decryptId = Crypt::decryptString($id_transaksi);
            $transaksi = Transaksi::with(['transaksi_barangs'])->where('id_transaksi', $decryptId)->firstOrFail();

            // Update data transaksi
            $transaksi->update([
                "tanggal" => Carbon::parse($request->tanggal)->format('Y-m-d H:i:s'),
                "deskripsi" => $request->deskripsi,
                "penerima" => $request->penerima,
            ]);

            // Ambil ID barang yang diinput
            $inputBarangIds = collect($request->barang)->pluck('id_transaksi_barang')->filter()->all();
            $existingBarangIds = $transaksi->transaksi_barangs->pluck('id_transaksi_barang')->all();

            // Hapus barang yang tidak ada di input dan kembalikan stok
            $toBeDeleted = array_diff($existingBarangIds, $inputBarangIds);

            foreach ($toBeDeleted as $idToDelete) {
                $transaksiBarang = TransaksiBarang::find($idToDelete);

                if ($transaksiBarang) {
                    $stock = Stock::where('id_barang', $transaksiBarang->id_barang)->first();
                    if ($stock) {
                        $stock->available_stock += $transaksiBarang->quantity; // Kembalikan stok
                        $stock->save();
                    }
                    $transaksiBarang->delete();
                }
            }

            // Update atau tambah barang baru
            foreach ($request->barang as $item) {
                $quantity = $item['quantity'];
                $idBarang = $item['id_barang'];

                if (isset($item['id_transaksi_barang'])) {
                    // Update barang yang ada
                    $transaksiBarang = TransaksiBarang::findOrFail($item['id_transaksi_barang']);
                    $stock = Stock::where('id_barang', $idBarang)->first();

                    // Hitung selisih antara quantity yang baru dan lama
                    $difference = $quantity - $transaksiBarang->quantity; // Selisih yang benar

                    if ($difference < 0) {
                        // Jika quantity baru lebih sedikit, kita menambah stok
                        if ($stock) {
                            $stock->available_stock += abs($difference); // Menambah stok
                            $stock->save();
                        }
                    } else {
                        // Jika quantity baru lebih banyak, kita mengurangi stok
                        if ($stock) {
                            if ($stock->available_stock < $difference) {
                                DB::rollback();
                                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk pengurangan.');
                            }
                            $stock->available_stock -= $difference; // Mengurangi stok
                            $stock->save();
                        }
                    }

                    $transaksiBarang->update([
                        'quantity' => $quantity,
                    ]);
                } else {
                    // Tambahkan barang baru
                    TransaksiBarang::create([
                        "id_transaksi" => $transaksi->id_transaksi,
                        "id_barang" => $idBarang,
                        "quantity" => $quantity,
                    ]);

                    // Update stok
                    $stock = Stock::where('id_barang', $idBarang)->first();
                    if ($stock) {
                        if ($stock->available_stock < $quantity) {
                            DB::rollback();
                            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk pengeluaran barang.');
                        }
                        $stock->available_stock -= $quantity; // Kurangi stok
                    } else {
                        // Jika stok tidak ada, buat stok baru
                        Stock::create([
                            "id_barang" => $idBarang,
                            "available_stock" => -$quantity, // Kurangi stok karena barang keluar
                        ]);
                    }
                    $stock->save();
                }
            }

            DB::commit();
            return redirect()->route('isms_list_transaksi_barang_keluar')->with('success', "Sukses Menambahkan Data");
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', "Terjadi Kesalahan: " . $e->getMessage());
        }
    }

    public function isms_delete_transaksi_barang_keluar_action($id_transaksi)
    {
        DB::beginTransaction();
    
        try {
            $decryptId = Crypt::decryptString($id_transaksi);
            $transaksi = Transaksi::with(['transaksi_barangs'])->where('id_transaksi', $decryptId)->firstOrFail();
    
            // Menghapus setiap transaksi barang yang terkait dan mengembalikan stok yang dikeluarkan
            foreach ($transaksi->transaksi_barangs as $transaksiBarang) {
                $stock = Stock::where('id_barang', $transaksiBarang->id_barang)->first();
                if ($stock) {
                    // Mengecek apakah stok cukup untuk ditambah (dalam kasus barang keluar, kita tambahkan stok)
                    if ($stock->available_stock < 0) {
                        DB::rollback();
                        return redirect()->back()->with('error', 'Stok tidak mencukupi untuk pengurangan barang.');
                    }
    
                    $stock->available_stock += $transaksiBarang->quantity; // Tambahkan stok yang dikeluarkan kembali
                    $stock->save();
                }
                $transaksiBarang->delete(); // Hapus transaksi barang
            }
    
            // Hapus transaksi itu sendiri
            $transaksi->delete();
    
            DB::commit();
            return redirect()->route('isms_list_transaksi_barang_keluar')->with('success', 'Transaksi barang keluar berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus transaksi: ' . $e->getMessage());
        }
    }
    //================ END ISMS ================//
    
    //================ ATK================//
    public function atk_stock_barang()
    {
        $satuan = Satuan::get();
        $group = Group::get();
        $barangs = Barang::with(['kategori','satuan','group','stock','transaksi_masuk','transaksi_keluar','stock_opname'])
        ->withSum(['transaksi_masuk as total_barang_masuk'], 'transaksi_barangs.quantity') // Untuk transaksi masuk
        ->withSum(['transaksi_keluar as total_barang_keluar'], 'transaksi_barangs.quantity') // Untuk transaksi keluar
        ->withSum(['stock_opname as total_opname'], 'stock_opname_items.selisih')
        ->where('id_group',2)->get();
        // dd($barangs);
        return view('transaksi/atk_stock_barang',[
            'barangs' => $barangs,
            'satuan' => $satuan,
            'group' => $group
        ]);
    }

    public function atk_show_transaksi_barang($id_transaksi)
    {
        $decryptId = Crypt::decryptString($id_transaksi);
        $transaksi = Transaksi::with(['transaksi_barangs'])->withCount('transaksi_barangs')->withSum('transaksi_barangs as total_barang', 'quantity')
        ->where('id_group',2)->where('id_transaksi',$decryptId)->firstOrFail();

        return response()->json($transaksi);
    }

    public function atk_list_transaksi_barang_masuk()
    {
        $transaksi_barang_masuk = Transaksi::with(['transaksi_barangs','group'])->withCount('transaksi_barangs')->withSum('transaksi_barangs as total_barang', 'quantity')->where('tipe','in')
        ->where('id_group',2)->get();
        $transaksi_barang_masuk->map(function($item){
            // dd($item);
        });
        $group = Group::get();
        $satuan = Satuan::get();
        $barang = Barang::where('id_group',2)->get();
        return view('transaksi/atk_list_transaksi_barang_masuk',[
            'transaksi_barang_masuk' => $transaksi_barang_masuk,
            'group' => $group,
            'satuan' => $satuan,
            'barang' => $barang   
        ]);
    }

    public function atk_add_transaksi_barang_masuk_action(Request $request)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'barang.*.id_barang' => 'required|exists:barangs,id_barang',
            'barang.*.quantity' => 'required|integer|min:1',
        ],$messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            $transaksi = Transaksi::create([
                "id_user" => Auth()->user()->id_user,
                "id_group" => 2,
                "tanggal" => Carbon::parse($request->tanggal)->format('Y-m-d H:i:s'),
                "deskripsi" => $request->deskripsi,
                "penerima" => $request->penerima,
                "tipe" => "in",
            ]);

            foreach($request->barang as $item){
                TransaksiBarang::create([
                    "id_transaksi" => $transaksi->id_transaksi,
                    "id_barang" => $item['id_barang'],
                    "quantity" => $item['quantity'],
                ]);
                $stock = Stock::where('id_barang',$item['id_barang'])->first();
                if($stock){
                    $stock->available_stock += $item['quantity'];
                    $stock->save();
                }else{
                    Stock::create([
                        "id_barang" => $item['id_barang'],
                        "available_stock" => $item['quantity'],
                    ]);
                }
            }
            DB::commit();

            return redirect()->route('atk_list_transaksi_barang_masuk')->with('success', "Sukses Menambahkan Data");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat menambah data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }

    public function atk_edit_transaksi_barang_masuk_action(Request $request, $id_transaksi)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];

        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'barang.*.id_barang' => 'required|exists:barangs,id_barang',
            'barang.*.quantity' => 'required|integer|min:1',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $decryptId = Crypt::decryptString($id_transaksi);
            $transaksi = Transaksi::with(['transaksi_barangs'])->where('id_transaksi', $decryptId)->firstOrFail();

            // Update transaksi
            $transaksi->update([
                "tanggal" => Carbon::parse($request->tanggal)->format('Y-m-d H:i:s'),
                "deskripsi" => $request->deskripsi,
                "penerima" => $request->penerima,
            ]);

            // Ambil semua barang ID dari request
            $inputBarangIds = collect($request->barang)->pluck('id_transaksi_barang')->filter()->all();
            $existingBarangIds = $transaksi->transaksi_barangs->pluck('id_transaksi_barang')->all();

            // Hapus barang yang tidak ada di input
            $toBeDeleted = array_diff($existingBarangIds, $inputBarangIds);

            foreach ($toBeDeleted as $idToDelete) {
                $transaksiBarang = TransaksiBarang::find($idToDelete);

                if ($transaksiBarang) {
                    $stock = Stock::where('id_barang', $transaksiBarang->id_barang)->first();
                    if ($stock) {
                        $stock->available_stock += $transaksiBarang->quantity;
                        $stock->save();
                    }
                    $transaksiBarang->delete();
                }
            }

            // Update atau tambahkan barang
            foreach ($request->barang as $item) {
                $quantity = $item['quantity'];
                $idBarang = $item['id_barang'];

                if (isset($item['id_transaksi_barang'])) {
                    // Update barang yang ada
                    $transaksiBarang = TransaksiBarang::findOrFail($item['id_transaksi_barang']);
                    $stock = Stock::where('id_barang', $idBarang)->first();

                    $difference = $quantity - $transaksiBarang->quantity;

                    if ($difference != 0 && $stock) {
                        $stock->available_stock += $difference;
                        $stock->save();
                    }

                    $transaksiBarang->update([
                        'quantity' => $quantity,
                    ]);
                } else {
                    // Tambahkan barang baru
                    TransaksiBarang::create([
                        "id_transaksi" => $transaksi->id_transaksi,
                        "id_barang" => $idBarang,
                        "quantity" => $quantity,
                    ]);

                    $stock = Stock::where('id_barang', $idBarang)->first();
                    if ($stock) {
                        $stock->available_stock += $quantity;
                    } else {
                        $stock = Stock::create([
                            "id_barang" => $idBarang,
                            "available_stock" => $quantity,
                        ]);
                    }
                    $stock->save();
                }
            }

            DB::commit();
            return redirect()->route('atk_list_transaksi_barang_masuk')->with('success', "Sukses Menambahkan Data");
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', "Terjadi Kesalahan: " . $e->getMessage());
        }
    }

    public function atk_delete_transaksi_barang_masuk_action($id_transaksi)
    {
        DB::beginTransaction();

        try {
            $decryptId = Crypt::decryptString($id_transaksi);
            $transaksi = Transaksi::with(['transaksi_barangs'])->where('id_transaksi', $decryptId)->firstOrFail();

            // Menghapus setiap transaksi barang yang terkait dan mengembalikan stok yang ditambahkan
            foreach ($transaksi->transaksi_barangs as $transaksiBarang) {
                $stock = Stock::where('id_barang', $transaksiBarang->id_barang)->first();
                if ($stock) {
                    // Mengecek apakah stok cukup untuk dikurangi (dalam kasus barang masuk, kita kurangi stok)
                    if ($stock->available_stock < $transaksiBarang->quantity) {
                        DB::rollback();
                        return redirect()->back()->with('error', 'Stok tidak mencukupi untuk pengembalian barang.');
                    }

                    $stock->available_stock -= $transaksiBarang->quantity; // Kurangi stok yang ditambah
                    $stock->save();
                }
                $transaksiBarang->delete(); // Hapus transaksi barang
            }

            // Hapus transaksi itu sendiri
            $transaksi->delete();

            DB::commit();
            return redirect()->route('atk_list_transaksi_barang_masuk')->with('success', 'Transaksi barang masuk berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus transaksi: ' . $e->getMessage());
        }
    }

    public function atk_list_transaksi_barang_keluar()
    {
        $transaksi_barang_keluar = Transaksi::with(['transaksi_barangs','group'])->withCount('transaksi_barangs')->withSum('transaksi_barangs as total_barang', 'quantity')->where('tipe','out')
        ->where('id_group',2)->get();
        $transaksi_barang_keluar->map(function($item){
            // dd($item);
        });
        $group = Group::get();
        $satuan = Satuan::get();
        $barang = Barang::where('id_group',2)->get();
        return view('transaksi/atk_list_transaksi_barang_keluar',[
            'transaksi_barang_keluar' => $transaksi_barang_keluar,
            'group' => $group,
            'satuan' => $satuan,
            'barang' => $barang   
        ]);
    }

    public function atk_add_transaksi_barang_keluar_action(Request $request)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'barang.*.id_barang' => 'required|exists:barangs,id_barang',
            'barang.*.quantity' => 'required|integer|min:1',
        ],$messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            $transaksi = Transaksi::create([
                "id_user" => Auth()->user()->id_user,
                "id_group" => 2,
                "tanggal" => Carbon::parse($request->tanggal)->format('Y-m-d H:i:s'),
                "deskripsi" => $request->deskripsi,
                "penerima" => $request->penerima,
                "tipe" => "out",
            ]);

            foreach($request->barang as $item){
                TransaksiBarang::create([
                    "id_transaksi" => $transaksi->id_transaksi,
                    "id_barang" => $item['id_barang'],
                    "quantity" => $item['quantity'],
                ]);
                $stock = Stock::where('id_barang',$item['id_barang'])->first();
                if($stock){
                    if($stock->available_stock < $item['quantity']){
                        DB::rollback();
                        return redirect()->back()->with('error', 'Stok tidak mencukupi untuk pengurangan.');
                    }
                    $stock->available_stock -= $item['quantity'];
                    $stock->save();
                }else{
                    DB::rollback();
                    return redirect()->back()->with('error', 'Stok tidak mencukupi untuk pengurangan.');
                }
            }
            DB::commit();

            return redirect()->route('atk_list_transaksi_barang_keluar')->with('success', "Sukses Menambahkan Data");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat menambah data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }

    public function atk_edit_transaksi_barang_keluar_action(Request $request, $id_transaksi)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];

        // Validasi request input
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'barang.*.id_barang' => 'required|exists:barangs,id_barang',
            'barang.*.quantity' => 'required|integer|min:1',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            // Dekripsi ID transaksi
            $decryptId = Crypt::decryptString($id_transaksi);
            $transaksi = Transaksi::with(['transaksi_barangs'])->where('id_transaksi', $decryptId)->firstOrFail();

            // Update data transaksi
            $transaksi->update([
                "tanggal" => Carbon::parse($request->tanggal)->format('Y-m-d H:i:s'),
                "deskripsi" => $request->deskripsi,
                "penerima" => $request->penerima,
            ]);

            // Ambil ID barang yang diinput
            $inputBarangIds = collect($request->barang)->pluck('id_transaksi_barang')->filter()->all();
            $existingBarangIds = $transaksi->transaksi_barangs->pluck('id_transaksi_barang')->all();

            // Hapus barang yang tidak ada di input dan kembalikan stok
            $toBeDeleted = array_diff($existingBarangIds, $inputBarangIds);

            foreach ($toBeDeleted as $idToDelete) {
                $transaksiBarang = TransaksiBarang::find($idToDelete);

                if ($transaksiBarang) {
                    $stock = Stock::where('id_barang', $transaksiBarang->id_barang)->first();
                    if ($stock) {
                        $stock->available_stock += $transaksiBarang->quantity; // Kembalikan stok
                        $stock->save();
                    }
                    $transaksiBarang->delete();
                }
            }

            // Update atau tambah barang baru
            foreach ($request->barang as $item) {
                $quantity = $item['quantity'];
                $idBarang = $item['id_barang'];

                if (isset($item['id_transaksi_barang'])) {
                    // Update barang yang ada
                    $transaksiBarang = TransaksiBarang::findOrFail($item['id_transaksi_barang']);
                    $stock = Stock::where('id_barang', $idBarang)->first();

                    // Hitung selisih antara quantity yang baru dan lama
                    $difference = $quantity - $transaksiBarang->quantity; // Selisih yang benar

                    if ($difference < 0) {
                        // Jika quantity baru lebih sedikit, kita menambah stok
                        if ($stock) {
                            $stock->available_stock += abs($difference); // Menambah stok
                            $stock->save();
                        }
                    } else {
                        // Jika quantity baru lebih banyak, kita mengurangi stok
                        if ($stock) {
                            if ($stock->available_stock < $difference) {
                                DB::rollback();
                                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk pengurangan.');
                            }
                            $stock->available_stock -= $difference; // Mengurangi stok
                            $stock->save();
                        }
                    }

                    $transaksiBarang->update([
                        'quantity' => $quantity,
                    ]);
                } else {
                    // Tambahkan barang baru
                    TransaksiBarang::create([
                        "id_transaksi" => $transaksi->id_transaksi,
                        "id_barang" => $idBarang,
                        "quantity" => $quantity,
                    ]);

                    // Update stok
                    $stock = Stock::where('id_barang', $idBarang)->first();
                    if ($stock) {
                        if ($stock->available_stock < $quantity) {
                            DB::rollback();
                            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk pengeluaran barang.');
                        }
                        $stock->available_stock -= $quantity; // Kurangi stok
                    } else {
                        // Jika stok tidak ada, buat stok baru
                        Stock::create([
                            "id_barang" => $idBarang,
                            "available_stock" => -$quantity, // Kurangi stok karena barang keluar
                        ]);
                    }
                    $stock->save();
                }
            }

            DB::commit();
            return redirect()->route('atk_list_transaksi_barang_keluar')->with('success', "Sukses Menambahkan Data");
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', "Terjadi Kesalahan: " . $e->getMessage());
        }
    }

    public function atk_delete_transaksi_barang_keluar_action($id_transaksi)
    {
        DB::beginTransaction();
    
        try {
            $decryptId = Crypt::decryptString($id_transaksi);
            $transaksi = Transaksi::with(['transaksi_barangs'])->where('id_transaksi', $decryptId)->firstOrFail();
    
            // Menghapus setiap transaksi barang yang terkait dan mengembalikan stok yang dikeluarkan
            foreach ($transaksi->transaksi_barangs as $transaksiBarang) {
                $stock = Stock::where('id_barang', $transaksiBarang->id_barang)->first();
                if ($stock) {
                    // Mengecek apakah stok cukup untuk ditambah (dalam kasus barang keluar, kita tambahkan stok)
                    if ($stock->available_stock < 0) {
                        DB::rollback();
                        return redirect()->back()->with('error', 'Stok tidak mencukupi untuk pengurangan barang.');
                    }
    
                    $stock->available_stock += $transaksiBarang->quantity; // Tambahkan stok yang dikeluarkan kembali
                    $stock->save();
                }
                $transaksiBarang->delete(); // Hapus transaksi barang
            }
    
            // Hapus transaksi itu sendiri
            $transaksi->delete();
    
            DB::commit();
            return redirect()->route('atk_list_transaksi_barang_keluar')->with('success', 'Transaksi barang keluar berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus transaksi: ' . $e->getMessage());
        }
    }    



}
