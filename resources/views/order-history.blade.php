<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Bestelgeschiedenis') }}
        </h2>
    </x-slot>
    @vite('resources/css/order-history.css')
        @if (auth()->user()->isAdmin())
            <form action="{{ route('export.orders') }}" method="GET" class="form-excel">
                <label class="label-dates" for="date-begin">Begin datum:</label>
                <input type="date" name="date-begin" id="date-begin">
            
                <label  class="label-dates" for="date-end">Eind Datum:</label>
                <input type="date" name="date-end" id="date-end">
            
                <button type="submit" class="export-btn">Exporteer naar Excel</button>
            </form>
        @endif
        @if($orders  && count($orders) > 0)
            @foreach ($orders as $order)
            <div class="order-container">
                <div class="order-detail">
                    <h1 class="order-title">Bestelnummer: #{{$order->id}}</h1>
                    <form action="{{route('eigendomsbewijs')}}" method="POST">
                        @csrf
                        <input type="hidden" value="{{$order->id}}" name="order_id">
                        <x-primary-button class="download-btn">Eigendomsbewijs</x-primary-button>
                    </form>
                </div>
                <div class="order-info">
                    <h1 class="info-code">Referentiecode: {{$order->reference}}</h1>
                    <p class="info-date">Besteld op: {{$order->created_at}}</p>
                </div>
                @foreach ($order->items as $item)
                <div class="order">
                    <p class="float">Aantal: {{$item->amount}}</p>
                    <div class="order-data">
                        <h1 class="data-title">{{$item->ring->name}}</h1>
                        <p class="data-title">{{$item->ring->color}}</p>
                    </div>
                    <div class="order-side-data">
                        <p class="side-data-style">{{$item->ring->size}}mm</p>
                        <p class="side-data-style">€ {{$item->ring->price}} p/ring</p>
                    </div>
                </div>
                @endforeach
                <div class="order-status">
                    <p class="status-style">Status: {{$order->status}}</p>
                    <p class="status-style">Totaalprijs: € {{$order->total_price}}</p>
                </div>
            </div>
            @endforeach
            @else
                <p id="empty-order">U heeft nog geen bestellingen geplaatst.</p>
        @endif
</x-app-layout>
