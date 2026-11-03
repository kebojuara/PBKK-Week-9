<?php

namespace App\Libraries;

use App\Models\OrderItemModel;
use App\Models\OrderModel;
use Config\Database;
use DomainException;
use Throwable;

/**
 * Checkout dan perubahan status pesanan, semuanya di dalam transaksi database.
 */
class PesananService
{
    private OrderModel $orders;
    private OrderItemModel $items;

    public function __construct()
    {
        $this->orders = model(OrderModel::class);
        $this->items  = model(OrderItemModel::class);
    }

    /**
     * Membuat pesanan dari keranjang. Stok dipotong dengan UPDATE bersyarat
     * (stok >= qty) sehingga dua pembeli tidak bisa membeli stok terakhir bersamaan.
     *
     * @param array{nama_penerima: string, telepon: string, alamat: string, catatan: string} $pengiriman
     */
    public function checkout(int $userId, Keranjang $keranjang, array $pengiriman): array
    {
        $isi = $keranjang->isi();
        if ($isi === []) {
            throw new DomainException('Keranjang masih kosong.');
        }
        foreach ($isi as $b) {
            if ($b['masalah'] !== null) {
                throw new DomainException($b['masalah']);
            }
        }
        $ringkasan = $keranjang->ringkasan($isi);

        $db = Database::connect();
        $db->transException(true)->transBegin();

        try {
            foreach ($isi as $b) {
                $db->query('UPDATE produk SET stok = stok - ? WHERE id = ? AND stok >= ? AND aktif = 1', [$b['qty'], $b['id'], $b['qty']]);
                if ($db->affectedRows() !== 1) {
                    throw new DomainException("Stok {$b['nama']} baru saja habis, silakan perbarui keranjang.");
                }
            }

            $orderId = $this->orders->insert([
                'kode'          => $this->orders->kodeBaru(),
                'user_id'       => $userId,
                'status'        => OrderStatus::MENUNGGU_PEMBAYARAN,
                'subtotal'      => $ringkasan['subtotal'],
                'ongkir'        => $ringkasan['ongkir'],
                'total'         => $ringkasan['total'],
                'nama_penerima' => $pengiriman['nama_penerima'],
                'telepon'       => $pengiriman['telepon'],
                'alamat'        => $pengiriman['alamat'],
                'catatan'       => $pengiriman['catatan'] === '' ? null : $pengiriman['catatan'],
            ]);
            if ($orderId === false) {
                throw new \RuntimeException('Pesanan gagal disimpan.');
            }

            foreach ($isi as $b) {
                $itemId = $this->items->insert([
                    'order_id'    => $orderId,
                    'produk_id'   => $b['id'],
                    'nama_produk' => $b['nama'],
                    'harga'       => $b['harga'],
                    'qty'         => $b['qty'],
                    'subtotal'    => $b['subtotal'],
                ]);
                if ($itemId === false) {
                    throw new \RuntimeException('Item pesanan gagal disimpan.');
                }
            }

            if (! $db->transStatus() || ! $db->transCommit()) {
                throw new \RuntimeException('Transaksi checkout gagal.');
            }
        } catch (Throwable $e) {
            $db->transRollback();

            throw $e;
        }

        $keranjang->kosongkan();

        return $this->orders->find($orderId);
    }

    /**
     * Mengubah status sesuai aturan OrderStatus. Pembatalan mengembalikan stok.
     *
     * @param array<string, mixed> $tambahan kolom lain yang ikut disimpan (resi, bukti_bayar, catatan_admin)
     */
    public function ubahStatus(array $order, string $ke, string $role, array $tambahan = []): void
    {
        if (! OrderStatus::izinkan($order['status'], $ke, $role)) {
            throw new DomainException(sprintf(
                'Status "%s" tidak dapat diubah menjadi "%s".',
                OrderStatus::label($order['status']),
                OrderStatus::label($ke),
            ));
        }
        if ($ke === OrderStatus::DIKIRIM && trim((string) ($tambahan['resi'] ?? '')) === '') {
            throw new DomainException('Nomor resi wajib diisi saat pesanan dikirim.');
        }

        $db = Database::connect();
        $db->transException(true)->transBegin();

        try {
            // Update bersyarat: gagal bila status sudah diubah orang lain (mencegah stok dikembalikan dua kali).
            $db->table('orders')
                ->where(['id' => $order['id'], 'status' => $order['status']])
                ->update(['status' => $ke, 'updated_at' => date('Y-m-d H:i:s')] + $tambahan);
            if ($db->affectedRows() !== 1) {
                throw new DomainException('Status pesanan sudah berubah, silakan muat ulang halaman.');
            }

            if (OrderStatus::kembalikanStok($ke)) {
                foreach ($this->items->where('order_id', $order['id'])->findAll() as $item) {
                    $db->query('UPDATE produk SET stok = stok + ? WHERE id = ?', [$item['qty'], $item['produk_id']]);
                }
            }
            if (! $db->transStatus() || ! $db->transCommit()) {
                throw new \RuntimeException('Transaksi status pesanan gagal.');
            }
        } catch (Throwable $e) {
            $db->transRollback();

            throw $e;
        }
    }
}
