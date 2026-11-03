<?php

namespace App\Database\Seeds;

use App\Models\KategoriModel;
use App\Models\OrderItemModel;
use App\Models\ProdukModel;
use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

/**
 * Data contoh KampusMart: 1 admin, 2 pembeli, 4 kategori, 14 produk,
 * dan beberapa pesanan dengan status berbeda untuk dashboard.
 */
class DatabaseSeeder extends Seeder
{
    /** [nama, ikon bootstrap-icons] */
    private const KATEGORI = [
        ['Alat Tulis', 'pencil'],
        ['Buku', 'book'],
        ['Merchandise', 'bag-heart'],
        ['Elektronik', 'usb-drive'],
    ];

    /** [index kategori, nama, harga, stok, deskripsi] */
    private const PRODUK = [
        [0, 'Pulpen Gel 0.5 mm Isi 3', 8500, 120, 'Pulpen gel tinta hitam, biru, dan merah. Tinta cepat kering dan tidak mudah luntur, cocok untuk mencatat kuliah.'],
        [0, 'Buku Catatan A5 Dot Grid', 27000, 60, 'Buku catatan 120 halaman kertas 100 gsm dengan pola titik, nyaman untuk catatan, sketsa, maupun bullet journal.'],
        [0, 'Stabilo Pastel Set 6 Warna', 54000, 25, 'Highlighter warna pastel yang lembut di mata, ujung pahat untuk garis tebal dan tipis.'],
        [0, 'Kalkulator Scientific FX-991', 289000, 8, 'Kalkulator ilmiah 552 fungsi, mendukung matriks, vektor, dan statistik. Diizinkan untuk ujian.'],
        [1, 'Pemrograman Web dengan CodeIgniter 4', 125000, 15, 'Panduan membangun aplikasi web MVC dengan CodeIgniter 4: routing, migration, model, filter, dan REST API.'],
        [1, 'Struktur Data dan Algoritma', 98000, 12, 'Buku ajar struktur data: array, linked list, stack, queue, tree, graph, beserta analisis kompleksitas.'],
        [1, 'Basis Data Relasional', 110000, 0, 'Konsep basis data relasional, normalisasi, SQL, transaksi, dan indeks dengan studi kasus MySQL.'],
        [2, 'Kaos Angkatan Teknik Informatika', 85000, 40, 'Kaos cotton combed 24s sablon plastisol, tersedia ukuran S sampai XXL.'],
        [2, 'Hoodie Kampus Navy', 189000, 18, 'Hoodie fleece tebal warna navy dengan bordir logo kampus di dada kiri.'],
        [2, 'Tumbler Stainless 500 ml', 75000, 30, 'Tumbler stainless dua lapis, menjaga minuman tetap dingin 12 jam dan panas 6 jam.'],
        [2, 'Lanyard dan ID Card Holder', 20000, 2, 'Tali lanyard printing dua sisi dengan holder kartu transparan.'],
        [3, 'Flashdisk 64 GB USB 3.2', 89000, 20, 'Flashdisk kecepatan baca hingga 150 MB/s, body logam dengan gantungan kunci.'],
        [3, 'Mouse Wireless Silent', 115000, 14, 'Mouse nirkabel 2.4 GHz klik senyap, baterai AA tahan hingga 12 bulan.'],
        [3, 'Powerbank 10.000 mAh', 199000, 9, 'Powerbank fast charging 20 W dengan port USB-C dan dua port USB-A.'],
    ];

    public function run(): void
    {
        $db = \App\Libraries\DemoSeedGuard::requireEmpty();
        $db->transException(true)->transBegin();
        try {
            $this->seedDemo();
            if (! $db->transStatus()) {
                throw new \RuntimeException('Demo seed gagal; transaksi dibatalkan.');
            }
            $db->transCommit();
        } catch (\Throwable $e) {
            $db->transRollback();
            throw $e;
        }
    }

    private function seedDemo(): void
    {
        $users = new UserModel();
        $users->insert([
            'nama' => 'Admin KampusMart', 'email' => 'admin@kampusmart.test', 'role' => 'admin',
            'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
        ]);
        $budi = $users->insert([
            'nama' => 'Budi Setiawan', 'email' => 'budi@mail.test', 'role' => 'pembeli',
            'password_hash' => password_hash('pembeli123', PASSWORD_DEFAULT),
            'telepon' => '081234567890', 'alamat' => "Asrama Mahasiswa Blok C No. 12\nJl. Teknik Kimia, Sukolilo, Surabaya 60111",
        ]);
        $sari = $users->insert([
            'nama' => 'Sari Wulandari', 'email' => 'sari@mail.test', 'role' => 'pembeli',
            'password_hash' => password_hash('pembeli123', PASSWORD_DEFAULT),
            'telepon' => '085711112222', 'alamat' => "Jl. Keputih Tegal No. 8\nSukolilo, Surabaya 60111",
        ]);

        $kategoriModel = new KategoriModel();
        $kategori      = [];
        foreach (self::KATEGORI as [$nama, $ikon]) {
            $kategori[] = $kategoriModel->insert(['nama' => $nama, 'ikon' => $ikon]);
        }

        $produkModel = new ProdukModel();
        $produk      = [];
        foreach (self::PRODUK as $i => [$k, $nama, $harga, $stok, $deskripsi]) {
            $id = $produkModel->skipValidation(true)->insert([
                'kategori_id' => $kategori[$k], 'nama' => $nama, 'deskripsi' => $deskripsi,
                'harga' => $harga, 'stok' => $stok, 'aktif' => 1,
            ]);
            // Model selalu mengisi created_at = sekarang; tanggal dibuat berbeda agar urutan "Terbaru" bermakna.
            $this->db->table('produk')->where('id', $id)
                ->update(['created_at' => date('Y-m-d H:i:s', strtotime('-' . (count(self::PRODUK) - $i) . ' days'))]);
            $produk[] = $id;
        }

        // [user, status, hari lalu, [[index produk, qty]], resi]
        $pesanan = [
            [$budi, 'selesai', 6, [[4, 1], [1, 2]], 'JNE0011223344'],
            [$sari, 'selesai', 5, [[8, 1]], 'SICEPAT00998877'],
            [$budi, 'dikirim', 3, [[11, 1], [0, 3]], 'JNT8800112233'],
            [$sari, 'diproses', 1, [[9, 2], [2, 1]], null],
            [$budi, 'dibatalkan', 2, [[3, 1]], null],
            [$sari, 'menunggu_pembayaran', 0, [[7, 2]], null],
        ];
        $items  = new OrderItemModel();
        foreach ($pesanan as $n => [$userId, $status, $hari, $baris, $resi]) {
            $user     = $users->find($userId);
            $subtotal = 0;
            foreach ($baris as [$p, $qty]) {
                $subtotal += self::PRODUK[$p][2] * $qty;
            }
            $ongkir  = $subtotal >= 200000 ? 0 : 15000;
            $waktu   = date('Y-m-d H:i:s', strtotime("-{$hari} days 10:15"));
            // Builder dipakai langsung agar created_at bisa diisi tanggal lampau.
            $this->db->table('orders')->insert([
                'kode' => 'KM' . date('ymd', strtotime("-{$hari} days")) . '-' . sprintf('%04X', 0xA100 + $n),
                'user_id' => $userId, 'status' => $status, 'subtotal' => $subtotal, 'ongkir' => $ongkir,
                'total' => $subtotal + $ongkir, 'nama_penerima' => $user['nama'], 'telepon' => $user['telepon'],
                'alamat' => $user['alamat'], 'resi' => $resi, 'created_at' => $waktu, 'updated_at' => $waktu,
            ]);
            $orderId = $this->db->insertID();
            foreach ($baris as [$p, $qty]) {
                $items->insert([
                    'order_id' => $orderId, 'produk_id' => $produk[$p], 'nama_produk' => self::PRODUK[$p][1],
                    'harga' => self::PRODUK[$p][2], 'qty' => $qty, 'subtotal' => self::PRODUK[$p][2] * $qty,
                ]);
            }
        }
    }
}
