<?php

namespace Tests\Unit;

use App\Libraries\Keranjang;
use App\Libraries\OrderStatus;
use CodeIgniter\Test\CIUnitTestCase;
use Config\Toko;

/**
 * @internal
 */
final class OrderStatusTest extends CIUnitTestCase
{
    public function testPembeliHanyaBolehUploadBuktiAtauBatalSaatMenungguPembayaran(): void
    {
        $this->assertSame(
            [OrderStatus::MENUNGGU_VERIFIKASI, OrderStatus::DIBATALKAN],
            OrderStatus::tujuan(OrderStatus::MENUNGGU_PEMBAYARAN, 'pembeli'),
        );
        $this->assertFalse(OrderStatus::izinkan(OrderStatus::MENUNGGU_VERIFIKASI, OrderStatus::DIBATALKAN, 'pembeli'));
    }

    public function testAdminMemverifikasiAtauMenolakPembayaran(): void
    {
        $this->assertTrue(OrderStatus::izinkan(OrderStatus::MENUNGGU_VERIFIKASI, OrderStatus::DIPROSES, 'admin'));
        $this->assertTrue(OrderStatus::izinkan(OrderStatus::MENUNGGU_VERIFIKASI, OrderStatus::MENUNGGU_PEMBAYARAN, 'admin'));
        $this->assertFalse(OrderStatus::izinkan(OrderStatus::MENUNGGU_PEMBAYARAN, OrderStatus::MENUNGGU_VERIFIKASI, 'admin'));
    }

    public function testTidakBolehMelompatiStatus(): void
    {
        $this->assertFalse(OrderStatus::izinkan(OrderStatus::MENUNGGU_PEMBAYARAN, OrderStatus::DIKIRIM, 'admin'));
        $this->assertFalse(OrderStatus::izinkan(OrderStatus::DIPROSES, OrderStatus::SELESAI, 'admin'));
    }

    public function testStatusAkhirTidakPunyaTujuan(): void
    {
        $this->assertSame([], OrderStatus::tujuan(OrderStatus::SELESAI, 'admin'));
        $this->assertSame([], OrderStatus::tujuan(OrderStatus::DIBATALKAN, 'admin'));
    }

    public function testHanyaPembatalanYangMengembalikanStok(): void
    {
        $this->assertTrue(OrderStatus::kembalikanStok(OrderStatus::DIBATALKAN));
        $this->assertFalse(OrderStatus::kembalikanStok(OrderStatus::SELESAI));
    }

    public function testOngkirGratisMulaiBatasMinimal(): void
    {
        $toko = new Toko();

        $this->assertSame(['subtotal' => 199999, 'ongkir' => 15000, 'total' => 214999, 'kurang_gratis' => 1], Keranjang::hitungOngkir(199999, $toko));
        $this->assertSame(['subtotal' => 200000, 'ongkir' => 0, 'total' => 200000, 'kurang_gratis' => 0], Keranjang::hitungOngkir(200000, $toko));
        $this->assertSame(0, Keranjang::hitungOngkir(0, $toko)['ongkir']);
    }
}
