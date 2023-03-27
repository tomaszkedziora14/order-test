<?php

namespace App\Tests\MyBundle1\Service;

use PHPUnit\Framework\TestCase;
use App\MyBundle1\Service\OrderService;

class OrderServiceTests extends TestCase
{
    public function testGetTotalPrice()
    {
        $orderService = new OrderService();
        $orderService->addProduct('product1', 10.0);
        $orderService->addProduct('product2', 20.0);
        $this->assertEquals(30.0, $orderService->getTotalPrice());
    }
}
