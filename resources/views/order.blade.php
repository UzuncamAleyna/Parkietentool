<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Bestellen') }}
        </h2>
    </x-slot>
    <div class="container-box">
        @vite('resources/css/order.css')
        <div class="container">
            <div class="intro">
                <h1 class="intro-title">Bestel hier uw ringen</h1>
                <p class="intro-text">U kunt op een snelle en eenvoudige manier uw ringen bestellen. Wij doen de rest.</p>
            </div>
            <div>
                <h2 class="products-title">Onze Ringen</h2>
                <div class="flex-articles">
                    @foreach ($types as $type)
                    <article class="article-box">
                        <a href="{{ route('order.detail', ['slug' => $type->slug]) }}">
                        <div class="article-img">
                            <img src="{{$type->image}}" alt="ringen">
                        </div>
                        <h3 class="article-title">{{$type->name}}</h3>
                    </a>
                    </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>