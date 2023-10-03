<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Mollie\Laravel\Facades\Mollie;
use Carbon\Carbon;

class MembershipController extends Controller
{
    public function payMembershipFee()
    {
        $webhookUrl = route('webhooks.mollie');

        if (App::environment('local')) {
            $webhookUrl = 'https://3b21-2a02-1812-1415-1e00-382a-82dd-b31f-2445.ngrok-free.app/webhooks/mollie';
        }

        Log::alert('De totale prijs moet voor de betaling berekend worden.');
        
        $membershipFee = 25;

        // User kan lidgeld jaarlijks betalen
        $user = auth()->user();
        $thisYear = Carbon::now()->year; // om huidige jaar te krijgen
        $membershipPaid = UserStatus::where('user_id', $user->id)
            ->whereYear('date', $thisYear)
            ->where('status', 'Betaald')
            ->exists(); // checkt of er al een betaling is voor dit jaar

        if ($membershipPaid) {
            return back()->with('error', 'Je hebt al betaald voor dit jaar.');
        }

        //Maak Mollie betaling aan
        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => number_format($membershipFee, 2),
            ],
            'description' => 'Jaarlijkse lidmaatschap',
            'redirectUrl' => route('profile.edit'),
            'webhookUrl' => $webhookUrl, 
        ]);

        UserStatus::create([
            'user_id' => auth()->user()->id,
            'status' => 'Betaald',
            'date' => date('Y-m-d'),
            'payment_data' => '25 euro',
        ]);

        // redirect de user naar de Mollie checkout pagina
        return redirect($payment->getCheckoutUrl(), 303);
    }
}
