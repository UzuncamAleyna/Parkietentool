<x-app-layout> <!-- This is the layout that is used for all pages -->
    <x-slot name="header"> <!-- This is the header of the page. --> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        
            {{ Auth::user()->firstname }}'s {{ __('Winkelmandje') }}
   
        </h2>
    </x-slot>
    @vite('resources/css/shopping-cart.css')
    @if ($order)
    <h2 id="order-id">Bestelnummer: #{{ $order->id }}</h2>
    <div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Ring naam</th>
                <th>Jaarkleur</th>
                <th>Diameter</th>
                <th>Prijs per ring</th>
                <th>Aantal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->ring->name }}</td>
                    <td>{{ $item->ring->color }}</td>
                    <td>{{ $item->ring->size }}mm</td>
                    <td>€{{ $item->ring->price }}</td>
                    <td>{{ $item->amount }}</td>
                    <td>
                        <form action="{{ route('shopping-cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-secondary-button type="submit" class="btn-remove">Verwijder</x-secondary-button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    <div class="shipping-container">
        <div class="shipping-box">
            <div class="shipping-info">
                <h2 class="big-title">Verzendingsgegevens</h2>
                <h2 class="mini-title">Bezorgadres</h2>
                <p>{{Auth::user()->firstname}} {{Auth::user()->lastname}}</p>
                <p>{{Auth::user()->address_street}} {{Auth::user()->address_nr}}</p>
                <p>{{Auth::user()->address_zipcode}} {{Auth::user()->address_city}}</p>
                <p>Tel: {{Auth::user()->phone}}</p>
            </div>
        </div>
        
        <div class="shipping-box">
            <div class="radio-box">
            @foreach ($shippingFees as $shippingFee)
                <label class="shipping-radio">
                    <input type="radio" name="shipping_fee" value="{{ $shippingFee->price }}" class="shipping-fee" data-price="{{ $shippingFee->price }}"> <!-- De data-price attribute zorgt ervoor dat de value kan gelezen worden met Javascript -->
                    {{ $shippingFee->name }} - €{{ $shippingFee->price }}
                </label>
            @endforeach
            <p id="total-price">Totale Prijs: €{{ number_format($order->total_price, 2) }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('shopping-cart.checkout') }}" method="POST" id="checkout-form">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        <input type="hidden" name="shipping_fee" value="{{ $order->shipping_data }}" id="selected-shipping-fee">
        <x-primary-button type="submit" class="btn-checkout">Betalen</x-primary-button>
    </form>

    <script>
        const shippingFees = document.querySelectorAll('.shipping-fee');

        shippingFees.forEach(shippingFee => {
            shippingFee.addEventListener('change', () => {
                const selectedShippingFeeValue = parseFloat(shippingFee.dataset.price);
                document.querySelector('#selected-shipping-fee').value = selectedShippingFeeValue.toFixed(2);
                updatePrice();
             });
        });

        function updatePrice() {
            //valideer betaal knop, verzendingsmethode MOET geselecteerd zijn
            document.getElementById('checkout-form').addEventListener('submit', function (event) {
                const selectedShippingFee = document.querySelector('.shipping-fee:checked');
            
                if (!selectedShippingFee) {
                    event.preventDefault();
                    alert('Selecteer een verzendingsmethode voordat u doorgaat.');
                }
            });

            const selectedShippingFee = document.querySelector('.shipping-fee:checked');
            
            if (selectedShippingFee) {
               shippingFeeValue = parseFloat(selectedShippingFee.dataset.price); //parseFloat zorgt ervoor dat de value een getal wordt | dataset.price is de value van de data-price attribute
            } else {
               shippingFeeValue = 0;
            }

            let orderTotal = shippingFeeValue;

            //Totale prijs van de ringen berekenen
            @if ($order)
                @foreach ($order->items as $item) 
                    orderTotal += {{ $item->ring->price }} * {{ $item->amount }};
                @endforeach
            @endif

            //Totale prijs bijwerken
            const totalElement = document.querySelector('#total-price');
            totalElement.textContent = 'Totale Prijs: €' + orderTotal.toFixed(2); //toFixed -> 2 cijfers na de komma
        }

        updatePrice();
    </script>

    @else
        <p id="empty-cart">Uw winkelmandje is leeg</p>
    @endif
    
</x-app-layout>