<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray( $request )
    {
        return [
            'booking_id' => $this->booking_id,
            'customer_id'    => $this->customer_id,
            'customer'   => $this->customer->first_name . ' ' . $this->customer->last_name,
            'amount'     => $this->amount,
            'date'       => $this->date,
        ];
    }
}