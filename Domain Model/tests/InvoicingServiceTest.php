<?php
declare(strict_types=1);

use harlequiin\Patterns\DomainModel\Repository\OrderRepositoryInterface;
use harlequiin\Patterns\DomainModel\Entity\Order;
use harlequiin\Patterns\DomainModel\Entity\Invoice;
use harlequiin\Patterns\DomainModel\Factory\InvoiceFactory;
use harlequiin\Patterns\DomainModel\Service\InvoicingService;
use PHPUnit\Framework\TestCase;

class InvoicingServiceTest extends TestCase
{
    public function testGenerateInvoicesQueriesTheRepositoryForUninvoicedOrders()
    {
        $orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $orderRepository->expects($this->once())
                        ->method("getUninvoicedOrders")
                        ->willReturn([]);
        $factory = $this->createMock(InvoiceFactory::class);

        $service = new InvoicingService($orderRepository, $factory);

        $service->generateInvoices();
    }

    public function testGenerateInvoicesReturnsAnInstanceOfInvoiceForEachOrder()
    {
        $orders = [new Order(), new Order()];
        $orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $orderRepository->method("getUninvoicedOrders")
                        ->willReturn($orders);
        $factory = $this->createMock(InvoiceFactory::class);
        $factory->method("createFromOrder")
                ->withConsecutive($orders[0])
                ->willReturnOnConsecutiveCalls(new Invoice(), new Invoice());


        $service = new InvoicingService($orderRepository, $factory);
        $invoices = $service->generateInvoices();

        $this->assertEquals(
            count($orders),
            count($invoices)
        );
        $this->assertInstanceOf(Invoice::class, $invoices[0]);
    }
}
