<?php

namespace App\Http\Controllers;

use Mollie\Laravel\Facades\Mollie;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function checkout(Request $r)
    {
        $webhookUrl = route('webhooks.mollie');

        if (App::environment('local')) {
            $webhookUrl = 'https://3b21-2a02-1812-1415-1e00-382a-82dd-b31f-2445.ngrok-free.app/webhooks/mollie';
        }

        Log::alert('De totale prijs moet voor de betaling berekend worden.');

        $user = auth()->user();

        $selectedShippingFee = $r->input('shipping_fee');
        $order = Order::where('user_id', $user->id)
                      ->where('status', 'in_afwachting')
                      ->first();
    
        if (!$order) {
            return back()->with('error', 'Geen in_afwachting order gevonden.');
        }
    
        //Totale prijs van de order berekenen
        $orderTotal = 0;
    
        foreach ($order->items as $item) {
            $orderTotal += $item->ring->price * $item->amount;
        }
    
        //Voeg de geselecteerde shipping fee toe aan de totale prijs van de order
        $orderTotal += $selectedShippingFee;
    
        //Update de totale prijs van de order en de status
        $order->total_price = $orderTotal;
        //Maak een random reference code aan
        $referenceCode = Str::random(15);
        $order->reference = $referenceCode;
        $order->status = 'Afgerond';
        $order->save();

        //Maak Mollie betaling aan
        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => number_format($orderTotal, 2),
            ],
            'description' => 'Uw referentiecode '. $order->reference,
            'redirectUrl' => route('checkout.success'),
            'webhookUrl' => $webhookUrl, 
        ]);

        $order->status = 'Betaald';
        $order->save();
        // redirect de user naar de Mollie checkout pagina
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function success()
    {
        return 'uurright';
    }
}
