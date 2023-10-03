<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Bestellen') }}
        </h2>
    </x-slot>
    <div class="container-box">
        @vite('resources/css/order.css')
        <div class="container">
            <h2 class="products-title">Onze {{$type->name}} </h2> 
            <div class="flex-articles">
                @foreach ($rings as $ring)
                <article class="article-box"> 
                        <form action="{{ route('shopping-cart.store')}}" method="POST">
                            <div class="article-img">
                                <img src={{$type->image}} alt="ring">
                            </div>
                            <div class="flex-info">
                                <div>
                                    <p class="info-title">{{$ring->name}}</p>
                                    <p class="info-title">{{$ring->color}}</p>
                                </div>
                                @csrf
                                <input type="hidden" name="ring_id" value="{{$ring->id}}">

                                <!-- Input voor Inox ringen -->
                                @if ($ring->slug === 'inox')
                                    <input type="number" name="amount" id="amount" class="input-style" required min="1" max="50">
                                @endif

                                <!-- Input voor Verharde ringen -->
                                @if ($ring->slug === 'alu') 
                                    <select name="amount" id="amount" class="dropdown-style">
                                    @for ($i = 10; $i <= 50; $i += 5)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                    </select>
                                @endif
                            </div>
                            <div class="flex-info">
                                <p class="ring-info">{{$ring->size}}mm</p>
                                <p class="ring-info">€{{$ring->price}}</p>
                            </div>
                            <x-secondary-button type="submit" class="bestel-btn">Toevoegen aan winkelmandje</x-secondary-button>
                        </form>
                </article>
                @endforeach
        </div>
    </div>
</x-app-layout>