<?php
declare(strict_types=1);

use harlequiin\Patterns\DomainModel\Entity\Invoice;
use harlequiin\Patterns\DomainModel\Entity\Order;
use harlequiin\Patterns\DomainModel\Factory\InvoiceFactory;
use PHPUnit\Framework\TestCase;

class InvoiceFactoryTest extends TestCase
{
    public function testCreateFromOrderReturnsAnInstanceOfInvoice()
    {
        $order = $this->createMock(Order::class);
        $factory = new InvoiceFactory();
        $invoice = $factory->createFromOrder($order);

        $this->assertInstanceOf(Invoice::class, $invoice);
    }

    public function testCreateFromOrderShouldAssociateTheInvoiceToOrder()
    {
        $order = $this->createMock(Order::class);
        $factory = new InvoiceFactory();
        $invoice = $factory->createFromOrder($order);

        $this->assertEquals(
            $order,
            $invoice->getOrder()
        );
    }

    public function testCreateFromOrderSetsTotalOfTheInvoiceFromOrderTotal()
    {
        $order = new Order();
        $order->setTotal(500);

        $factory = new InvoiceFactory();
        $invoice = $factory->createFromOrder($order);

        $this->assertEquals(
            500,
            $invoice->getTotal()
        );
    }

    public function testCreateFromOrderSetsTheDateOfTheInvoice()
    {
        $order = $this->createMock(Order::class);
        $factory = new InvoiceFactory();
        $invoice = $factory->createFromOrder($order);

        $this->assertLessThan(
            new DateTime(),
            $invoice->getInvoiceDate()
        );
    }
}
