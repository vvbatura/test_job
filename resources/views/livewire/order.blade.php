<div class="p-3">
    <div class="mb-3">
        <label for="name" class="form-label">{{ __('page_orders.Product name') }}</label>
        <input type="text" id="name" class="form-control" wire:model="product_name">
        @error('product_name') <span class="text-red">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label for="amount" class="form-label">{{ __('page_orders.Amount') }}</label>
        <input type="number" id="amount" class="form-control" wire:model="amount">
        @error('amount') <span class="text-red">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">{{ __('page_orders.Status') }}</label>
        <select id="status" wire:model="status">
            @foreach(\App\Enums\OrderStatusesEnum::toArrayFromOne() as $key => $item)
                <option value="{{ $key }}">{{ __('page_orders.statuses.' . $item) }}</option>
            @endforeach
        </select>
    </div>

    <button wire:click="save" class="border-2 p-1">{{ __('page_orders.Save') }}</button>
</div>
