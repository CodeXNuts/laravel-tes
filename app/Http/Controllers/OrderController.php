<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    /**
     * fetch order details
     * @param $id
     * @return array
     */
    public function fetchOrderData($id)
    {

        $data = Order::select(['orderNumber', 'orderDate', 'status','customerNumber'])
            ->with([
                'orderDetails' => function ($query) {
                    $query->select(['priceEach', 'quantityOrdered', 'productCode', 'orderNumber']);
                }, 'orderDetails.product' => function ($query) {
                    $query->select(['productLine', 'productName', 'productCode']);
                },
                'customer' => function ($query) {
                    $query->select(['contactFirstName as first_name', 'contactLastName as last_name', 'phone', 'country as country_code', 'customerNumber']);
                }
            ])
            ->find($id);

        if (!empty($data)) {
            return new OrderResource($data);
        }

        return Response::json([], 400);
    }
}
