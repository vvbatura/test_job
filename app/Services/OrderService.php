<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;


class OrderService
{

    /**
     * @param array $params
     * @return Builder
     */
    public function getItemsQuery(array $params = []): Builder
    {
        return Order::query()
            ->when($search = $params['search'] ,
                fn($query) => $query->where('product_name', 'like', '%' . $search . '%'))
            ->when($status = $params['status'],
                fn($query) => $query->where('status', $status))
            ->orderBy($params['sortField'] ?? 'id', $params['sortDirection'] ?? 'desc');
    }

    /**
     * @param array $params
     * @return Paginator
     */
    public function getItemsPaginate(array $params = []): Paginator
    {
        return $this->getItemsQuery($params)->paginate($params['perPage']);
    }

    /**
     * @param int $orderId
     * @return Order|null
     */
    public function getItem(int $orderId): Order|null
    {
        return Order::query()->find($orderId);
    }

    /**
     * @param Order $order
     * @param array $data
     * @return Order
     */
    public function updateItem(Order $order, array $data): Order
    {
        try {
            $order->fill($data);
            $order->save();
        } catch (\Exception $e) {
            Log::error('Error while updating order: ' . $e->getMessage());
        }
        return $order;
    }

    /**
     * @param int $orderId
     * @return Order
     */
    public function deleteItem(int $orderId): void
    {
        try {
            Order::query()
                ->where('id', $orderId)
                ->delete();
        } catch (\Exception $e) {
            Log::error('Error while deleting: ' . $e->getMessage());
        }

    }

}
