<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Order;
use App\Shipping;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{

    public function store(Request $r)
    {
        // dd($r->all());
        $r->validate([
            'ring_id' => 'required|exists:rings,id', 
            'amount' => 'required|integer|min:1',
        ]);

        $user = auth()->user(); //Haal de authenticated user op
        $ringId = $r->input('ring_id'); //Haal de ring_id op van de form data
        $amount = $r->input('amount'); //Haal de amount op van de form data
    
        //Haal de user's in_afwachting order op
        $order = $user->orders()->where('status', 'in_afwachting')->first();
    
        //Als 'in_afwachting' order niet bestaat, maak nieuwe order aan
        if (!$order) {
            //Maak nieuwe order aan
            $order = new Order();
            $order->status = 'in_afwachting';
            //Save order op in db
            $user->orders()->save($order);
        }
    
        //Maak nieuwe order_item aan
        $item = new OrderItem();
        $item->ring_id = $ringId;
        $item->amount = $amount;
        
        //Bewaar order_item in db
        $order->items()->save($item);
        
        //Redirect naar shopping cart met success message
        return redirect()->route('shopping-cart')->with('success', 'Item is toegevoegd aan winkelmandje.');
    }

    public function viewCart()
    {
        $user = auth()->user();

        //Haal de in_afwachting order op
        $order = $user->orders()->with('items')->where('status', 'in_afwachting')->first();

        //Haal alle shipping fees op
        $shippingFees = Shipping::all();

        return view('shopping-cart', compact('order', 'shippingFees'));
    }
    
    public function removeFromCart(Request $r, $ringId)
    {
        $user = auth()->user();
        $orderItem = OrderItem::findOrFail($ringId); 

        if ($orderItem->order->user_id === $user->id) { //Check of de user_id van de order overeenkomt met de user_id van de authenticated user
            $orderItem->delete();
            return redirect()->route('shopping-cart')->with('success', 'Item verwijderd uit winkelmandje.');
        }

        //Redirect naar shopping cart met error message
        return redirect()->route('shopping-cart')->with('error', 'Niet gelukt om item te verwijderen.');
    }    
}
