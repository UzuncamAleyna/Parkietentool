<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dag') }}, {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
        </h2>
    </x-slot>
    @vite('resources/css/dashboard.css')
    <div class="container-box">
        <div class="container">
            <section id="section1">
                <div class="home-img">
                    <h2>Welkom bij onze nieuwe parkietenbesteltool</h2>
                    <a href="#section2" id="scroll">Neem een kijkje</a>
                </div>
            </section>
        </div>
        <section id="section2">
            <h2 class="products-title">Onze Ringen</h2>
            <div class="articles-container">
                @foreach ($types as $index => $type)
                <section class="article-section">
                    <div class="article-content">
                        <img class="image-{{ $index % 2 === 0 ? 'left' : 'right' }}" src="{{$type->image}}" alt="ringen">
                        <div class="text-border">
                            <h3 class="article-title">{{$type->name}}</h3>
                            <p class="article-text">{{$type->description}}</p>
                        </div>
                    </div>
                </section>
                @endforeach
            </div>
        </section>
        </div>
    </div>
</x-app-layout>