<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Order;
use App\Ring;
use Illuminate\Http\Request;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel; 
use Carbon\Carbon;


class OrderHistoryController extends Controller
{
    public function index(Request $r)
    {   
        //Haal de authenticated user op
        $user = auth()->user();

        //isAdmin() is een functie in de User model
        $isAdmin = $user->isAdmin();

        $dateBegin = $r->input('date-begin');
        $dateEnd = $r->input('date-end');
    
        if ($isAdmin) {
            if ($dateBegin && $dateEnd) {
                $orders = Order::whereBetween('created_at', [$dateBegin, $dateEnd])->get();
            } else {
                $orders = Order::all();
            }
            $rings = Ring::all();
        } else {
            //Haal alle orders op van de authenticated user
            $orders = Order::where('user_id', auth()->user()->id)->get();
            $rings = Ring::all();
        }
    
        return view('order-history', compact('orders', 'rings'));
    }
    
    public function export(Request $r)
    {
        $dateBegin = $r->input('date-begin');
        $dateEnd = $r->input('date-end');
    
        $orders = Order::get(); 
    
        if ($dateBegin && $dateEnd) {
            $orders->whereBetween('created_at', [$dateBegin, $dateEnd]);
        }
        
        return Excel::download(new OrdersExport($dateBegin, $dateEnd), 'BVP-orders.xlsx');
    }
}