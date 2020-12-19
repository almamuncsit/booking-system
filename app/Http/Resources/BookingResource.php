<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray( $request )
    {
        return [
            'arrival'        => $this->arrival,
            'checkout'       => $this->checkout,
            'room_number'    => $this->room->room_number,
            'amount'         => $this->room->price,
            'customer_id'    => $this->customer_id,
            'customer'       => $this->customer->first_name . ' ' . $this->customer->last_name,
            'book_time'      => $this->book_time,
            'payment_status' => $this->payment_status,
        ];
    }
}