<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $res =  [
            'order_id' => $this->orderNumber ?? '',
            'order_date' => $this->orderDate ?? '',
            'status' => !empty($this->status) ? Str::title($this->status) : '',
            'order_details' => []
        ];

        $bill_amount = 0.00;
        if (!empty($this->orderDetails)) {
            foreach ($this->orderDetails as $eachDetails) {

                $bill_amount += (!empty($eachDetails->priceEach) && is_numeric($eachDetails->priceEach)) && (!empty($eachDetails->quantityOrdered) && is_numeric($eachDetails->quantityOrdered)) ? number_format($eachDetails->priceEach * $eachDetails->quantityOrdered, 2, '.', '') : '';
                array_push($res['order_details'], [
                    'product' => $eachDetails['product']['productName'] ?? '',
                    'product_line' => $eachDetails['product']['productLine'] ?? '',
                    'unit_price' => !empty($eachDetails->priceEach) && is_numeric($eachDetails->priceEach) ? floatval($eachDetails->priceEach) : '',
                    'qty' => !empty($eachDetails->quantityOrdered) && is_numeric($eachDetails->quantityOrdered) ? intval($eachDetails->quantityOrdered) : '',
                    'line_total' => (!empty($eachDetails->priceEach) && is_numeric($eachDetails->priceEach)) && (!empty($eachDetails->quantityOrdered) && is_numeric($eachDetails->quantityOrdered)) ? number_format($eachDetails->priceEach * $eachDetails->quantityOrdered, 2, '.', '') : ''
                ]);
            }
        }

        $res['bill_amount'] = number_format($bill_amount, 2, '.', '');

        !empty($this->customer) ? $this->customer->makeHidden('customerNumber') : '';
        $res['customer'] = $this->customer ?? '';
        return $res;
    }
}
