<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <style>
            body{
                font-family: 'Roboto', sans-serif;
            }

            .flex-link-btn{
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                margin: 1% 2%;
            }

            #terug-link{
                text-decoration: none;
                color: black;
            }

            #terug-link:hover{
                color: #e06624;
            }

            #pdf-button{
                background-color: #e06624;
                color: white;
                border: none;
                border-radius: 5px;
                padding-top: 5%;
                padding-bottom: 5%;
                font-size: 1rem;
                font-weight: 500;
            }

            #pdf-button:hover{
                cursor: pointer;
                background-color: white;
                color: #e06624;
                border: 1px solid #e06624;
            }

            #logo{
                width: 10%;
                display: block;
                margin-left: auto;
                margin-right: auto;
                margin-bottom: 3%;
            }

            .eigendomsbewijs-title{
                display: flex;
                flex-direction: column;
                gap: 4em;
                font-size: 1rem;
                font-weight: bold;
                color: black;
                text-align: center;
            }

            .flex-userinfo{
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                margin: 4% 10%;
            }

            #name-style{
                text-transform: uppercase;
                font-weight: bold;
            }

            #userinfo-nr{
                font-weight: bold;

            }

            .table-container {
                width: 80%;
                margin: 0 auto;
            }

            .table {
                width: 100%;
                border-collapse: collapse;
            }

            .table th, .table td {
                padding: 1%;
                text-align: left;
            }

            .table td {
                width: 15%;
            }

            .table th{
                padding-bottom: 4%;
            }

            .text-under{
                font-size: 1rem;
                color: black;
                text-align: center;
                margin-top: 80%;
                position: fixed;
            }
        </style>
    </head>
    <main>
        <div class="container">
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
    </main>
</html>