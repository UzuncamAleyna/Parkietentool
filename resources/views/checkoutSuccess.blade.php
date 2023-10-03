<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Parkietenringtool</title>

    </head>
    @vite('resources/css/success.css')
    <body>
        <div class="container">
            <p class="text-style"> Bedankt voor uw bestelling.</p>
            <p class="text-style"> Uw bestelling zal zo snel mogelijk worden verzonden.</p>
           <p class="text-style">Binnen enkele seconden zal u terug doorverwezen worden naar de homepagina.</p>
           <img src="../bird.gif" alt="gif">
        </div>
        <script>
            setTimeout(function(){
               window.location.href = "{{ route('dashboard') }}";
            }, 6000);
         </script>
    </body>
</html>