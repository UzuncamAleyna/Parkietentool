<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Parkietenringtool</title>

    </head>
    @vite('resources/css/eigendomsbewijs.css')
    <body>
        <div class="container">
            <div class="flex-link-btn">
                <a id="terug-link" href="{{route('order-history')}}">Terug</a>
                <form action="{{ route('eigendomsbewijs.genereerPDf') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $order->id }}" name="order_id">
                    <button id="pdf-button">Genereer PDF</button>
                </form>
            </div>
            <img id="logo" src="BVP_logo.png" alt="logo">
            <div class="eigendomsbewijs-title">
                <p>EIGENDOMSBEWIJS KWEEKRINGEN BVP seizoen 2023</p>
                <p>De volgende ringen behoren toe aan Mr/Mevr</p>
            </div>

            <div class="flex-userinfo">
                <p id="name-style">NAAM: {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</p>
        
                <p id="userinfo-nr">Stamnummer: {{Auth::user()->stamnr}}</p>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>BVP</th>
                            <th>stamnr</th>
                            <th>maat</th>
                            <th>code</th>
                            <th>aantal</th>
                            <th>beginnr</th>
                            <th>eindnr</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>BVP</td>
                                <td>{{Auth::user()->stamnr}}</td>
                                <td>{{$item->ring->size}}mm</td>
                                <td>{{$item->ring->color}}</td>
                                <td>{{$item->amount}}</td>
                                <td>001</td>
                                <td>0{{$item->amount}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        
            <p class="text-under">Uitgereikt door de ringendienst BVP, volgens het reglement goedgekeurd door BVP Nationaal.</p>

        </div>
    </body>
</html>