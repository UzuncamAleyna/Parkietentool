<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Parkietenringtool</title>

    </head>
    <body>
        <main>
            <header>
                <nav class="flex-nav">
                    <a href="/">
                        <img id="logo-img" src="../BVP_logo.png" alt="logo">
                    </a>
                    <a id="login-link" href="/dashboard">Login</a>
                </nav>
            </header>
            @vite('resources/css/welcome.css')
            <div class="container-box">
                <div class="container">
                    <section id="section1">
                        <div class="home-img">
                            <h2>Welkom bij onze nieuwe parkietenbesteltool</h2>
                            <!-- Scrollt naar section2 -->
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
                                <!-- Als de index even is -> afbeelding links plaatsen, als index oneven is -> afbeelding rechts plaatsen  -->
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
        </main>
        </body>
</html>