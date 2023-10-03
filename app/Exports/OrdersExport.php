<?php

namespace App\Exports;

use App\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    protected $dateBegin;
    protected $dateEnd;

    //Deze functie wordt aangeroepen wanneer een nieuwe OrdersExport aanmaakt
    public function __construct($dateBegin, $dateEnd)
    {
        $this->dateBegin = $dateBegin;
        $this->dateEnd = $dateEnd;
    }

    public function collection()
    {
        if ($this->dateBegin && $this->dateEnd) {
            $orders = Order::whereBetween('created_at', [$this->dateBegin, $this->dateEnd])->get();
        } else {
            $orders = Order::all();
        }

        return $orders;
    }

    public function headings(): array
    {
        return [
            'Bestelnummer',
            'Referentiecode',
            'Status bestelling',
            'Totale prijs',
        ];
    }
}