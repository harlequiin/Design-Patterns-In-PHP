<?php
declare(strict_types=1);

namespace harlequiin\Patterns\DomainModel\Service;

use harlequiin\Patterns\DomainModel\Repository\OrderRepositoryInterface;
use harlequiin\Patterns\DomainModel\Factory\InvoiceFactory;

class InvoicingService
{
    /**
     * @var OrderRepositoryInterface
     * */
    protected $orderRepository;

    /**
     * @var InvoiceFactory
     */
    protected $invoiceFactory;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        InvoiceFactory $invoiceFactory
    )
    {
        $this->orderRepository = $orderRepository;
        $this->invoiceFactory = $invoiceFactory;
    }

    public function generateInvoices(): array
    {
        $orders = $this->orderRepository->getUninvoicedOrders();
        $invoices = [];

        foreach ($orders as $order) {
            $invoices[] = $this->invoiceFactory->createFromOrder($order);
        }

        return $invoices;
    }
}
