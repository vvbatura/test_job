<?php

namespace App\Livewire;

use App\Models\Order as ModelsOrder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Order extends Component
{
    public ModelsOrder $order;
    #[Validate('required|min:3')]
    public string $product_name = '';
    #[Validate('required|numeric|min:1')]
    public float $amount = 0;
    #[Validate('required')]
    public int $status = 1;

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

        $this->order->fill($validated);
        $this->order->save();
        return redirect('orders');
    }

    public function render(): View
    {
        return view('livewire.order');
    }
}
