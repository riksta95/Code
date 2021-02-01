<?php

namespace App\Http\Controllers;

use App\Http\Traits\Flow;
use RegCore\Http\Controllers as Core;
use Buzz\Control\Campaign\Order;

class OrderController extends Core\OrderController
{
    use Flow;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Buzz\EssentialsSdk\Exceptions\ErrorException
     */
    public function index()
    {
        $orders = (new Order())
            ->expand(['invoice', 'products'])
            ->get([['customer_id', 'is', customer()->id]]);

        if (request('order_id')) {
            foreach($orders as $order){
                if($order->id != request('order_id')){
                    
                    $refundOptions = ['visitor', 'p-access'];
                    
                    foreach($order->products as $product){
                        if(in_array($product->identifier, $refundOptions) && $product->cost != 0) {

                            $refunded = false;

                            foreach(customer()->tags as $tag){
                                if($tag->tag->name == 'visitor-refund'){
                                    $refunded = true;
                                }
                            }

                            if(!$refunded) {
                                customer()->sendEmailMessage('visitor-refund', 'lbf-2020@livebuzz.co.uk');
                                customer()->tag('visitor-refund');
                            }
                        }
                    }
                }
            }

            session()->flash('flash_message', [
                'type'    => 'success',
                'title'   => transUi('Success!'),
                'message' => transUi('Registration completed! Invite your friends or colleagues below'),
            ]);

            return redirect(route('profile'));
        }

        return view('order.index', compact('orders'));
    }
}
