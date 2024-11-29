<?php

namespace App\Livewire;

use App\Services\OrderService;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    protected int $orderPerPage = 2;
    protected OrderService|null $service = null;
    public string $search = '';
    public string $sortField = 'id';
    public string $sortDirection = 'asc';
    public int $filterStatus = 0;
    public array $changeStatus = [];

    /**
     * @param OrderService $service
     * @return void
     */
    public function boot(OrderService $service): void
    {
        $this->service = $service;
    }

    /**
     *
     * @return View
     */
    public function render(): View
    {
        $orders = $this->service->getItemsPaginate([
            'search' => $this->search,
            'status' => $this->filterStatus,
            'sortField' => $this->sortField,
            'sortDirection' => $this->sortDirection,
            'perPage' => $this->orderPerPage,
        ]);
        $this->changeStatus = $orders->pluck('status', 'id')->toArray();

        return view('livewire.orders', ['orders' => $orders]);
    }

    /**
     * @param string $field
     * @return void
     */
    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    /**
     * @param int $orderId
     * @return void
     */
    public function changeStatusOrder(int $orderId): void
    {
        $order = $this->service->getItem($orderId);
        if (($this->changeStatus[$orderId] ?? 0) && $order->status != $this->changeStatus[$orderId]) {
            $this->service->updateItem($order, [ 'status' => $this->changeStatus[$orderId] ]);
        }
    }

    /**
     * @param int $orderId
     * @return void
     */
    public function deleteOrder(int $orderId): void
    {
        $this->service->deleteItem($orderId);
    }
}
