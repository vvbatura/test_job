<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'id';
    public string $sortDirection = 'asc';
    public string $filterStatus = '';

    public function render(): View
    {
        $orders = Order::query()
            ->where('product_name', 'like', '%' . $this->search . '%')
            ->when($this->filterStatus, fn($query) => $query->where('status', $this->filterStatus))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(2);

        return view('livewire.orders', ['orders' => $orders]);
    }

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
}
