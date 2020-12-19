<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingDetailsResource extends JsonResource
{
    public function toArray( $request )
    {
        return [
            'arrival'        => $this->arrival,
            'checkout'       => $this->checkout,
            'room'           => $this->room,
            'customer'       => $this->customer,
            'payments'       => $this->payments,
            'book_time'      => $this->book_time,
            'payment_status' => $this->payment_status,
        ];
    }
}