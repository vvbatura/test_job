<?php

namespace App\Livewire;

use App\Models\Order as ModelsOrder;
use App\Services\OrderService;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Order extends Component
{

    protected ?OrderService $service = null;
    public ModelsOrder $order;
    #[Validate('required|min:3')]
    public string $product_name = '';
    #[Validate('required|numeric|min:1')]
    public float $amount = 0;
    #[Validate('required')]
    public int $status = 1;

    /**
     * @param OrderService $service
     * @return void
     */
    public function boot(OrderService $service): void
    {
        $this->service = $service;
    }

    /**
     * @param ModelsOrder $order
     * @return void
     */
    public function mount(ModelsOrder $order): void
    {
        $this->order = $order;
        $this->product_name = $order->product_name ?? '';
        $this->amount = $order->amount ?? 0;
        $this->status = $order->status ?? 1;
    }

    public function save()
    {
        $validated = $this->validate();

        $validated['user_id'] = auth()->id();

        $id = $this->order->id;

        $this->order = $this->service->updateItem($this->order, $validated);

        if (!$id) {
            return redirect()->route('orders.edit', ['order' => $this->order->id ]);
        }
    }

    public function render(): View
    {
        return view('livewire.order');
    }
}
