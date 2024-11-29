<div class="p-3">
    <input wire:model.live="search" type="text" placeholder="Search..." class="form-control mb-3">

    <select wire:model="filterStatus" class="select">
        @foreach(\App\Enums\OrderStatusesEnum::toArrayFromOne() as $key => $item)
            <option value="{{ $key }}">{{ __('page_orders.statuses.' . $item) }}</option>
        @endforeach
    </select>

    <a href="{{ route('orders.new') }}" class="button float-end">{{ __('page_orders.New Order') }}</a>

    <table class="table table-striped">
        <thead>
        <tr>
            <th wire:click="sortBy('id')" style="cursor: pointer;">
                {{ __('page_orders.ID') }}
                @if ($sortField === 'id')
                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                @endif
            </th>
            <th wire:click="sortBy('product_name')" style="cursor: pointer;">
                {{ __('page_orders.Product name') }}
                @if ($sortField === 'product_name')
                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                @endif
            </th>
            <th wire:click="sortBy('amount')" style="cursor: pointer;">
                {{ __('page_orders.Amount') }}
                @if ($sortField === 'amount')
                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                @endif
            </th>
            <th wire:click="sortBy('status')" style="cursor: pointer;">
                {{ __('page_orders.Status') }}
                @if ($sortField === 'status')
                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                @endif
            </th>
            <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                {{ __('page_orders.Date created') }}
            </th>
            <th wire:click="sortBy('updated_at')" style="cursor: pointer;">
                {{ __('page_orders.Date updated') }}
            </th>
            <th>{{ __('page_orders.Change Status') }}</th>
            <th>{{ __('page_orders.Action') }}</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->product_name }}</td>
                <td>{{ $order->amount }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->created_at->format('d.m.Y') }}</td>
                <td>{{ $order->updated_at->format('d.m.Y') }}</td>
                <td>
                    <div class="flex flex-col">
                        <select wire:model="changeStatus.{{ $order->id }}" class="select">
                            @foreach(\App\Enums\OrderStatusesEnum::toArrayFromOne() as $key => $item)
                                <option value="{{ $key }}" {{ $key == $order->status ? 'selected' : '' }}>
                                    {{ __('page_orders.statuses.' . $item) }}</option>
                            @endforeach
                        </select>
                        <button wire:click="changeStatusOrder({{ $order->id }})" class="button">{{ __('page_orders.Change') }}</button>
                    </div>

                </td>
                <td>
                    <div class="flex flex-col">
                        <a href="{{ route('orders.edit', $order) }}" class="button">{{ __('page_orders.Edit') }}</a>
                        <button wire:click="deleteOrder({{ $order->id }})" class="button">{{ __('page_orders.Delete') }}</button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">{{ __('page_orders.Empty Data') }}</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $orders->links() }}
</div>
