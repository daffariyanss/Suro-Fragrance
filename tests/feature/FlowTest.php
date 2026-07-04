<?php

use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class FlowTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testGuestIsRedirectedFromDashboard(): void
    {
        $result = $this->call('get', '/dashboard');

        $result->assertRedirectTo('/');
    }

    public function testCustomerCanOpenShopWhenLoggedIn(): void
    {
        $result = $this->withSession([
            'isLoggedIn' => true,
            'role'       => 'customer',
            'username'    => 'daffa',
            'email'       => 'daffa@mail.com',
        ])->call('get', '/barang');

        $result->assertOK();
    }

    public function testCustomerCanOpenPurchaseHistoryRoute(): void
    {
        $result = $this->withSession([
            'isLoggedIn' => true,
            'role'       => 'customer',
            'username'    => 'daffa',
            'email'       => 'daffa@mail.com',
        ])->call('get', '/riwayat-pembelian');

        $result->assertOK();
    }

    public function testAdminCanOpenDashboard(): void
    {
        $result = $this->withSession([
            'isLoggedIn' => true,
            'role'       => 'admin',
            'username'    => 'admin',
            'email'       => 'admin@gmail.com',
        ])->call('get', '/dashboard');

        $result->assertOK();
    }
}

