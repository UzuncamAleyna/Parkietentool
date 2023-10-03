<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use PDF;

class EigendomsbewijsController extends Controller
{
    public function index(Request $r)
    {
        $orderId = $r -> input('order_id');

        $order = Order::find($orderId);

        return view('eigendomsbewijs' , compact('order'));
    }

    public function genereerPDf(Request $r)
    {
        $orderId = $r -> input('order_id');

        $order = Order::find($orderId);

        $pdf = PDF::loadView('eigendomsbewijs-pdf', ['order' => $order]);

        return $pdf->download('eigendomsbewijs-order#'.$orderId.'.pdf');
    }
}
