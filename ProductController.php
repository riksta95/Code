<?php

namespace App\Http\Controllers;

use App\Http\Traits\Flow;
use Buzz\Control\Campaign\Customer;
use Buzz\Control\Campaign\Product;
use Buzz\Control\Filter;
use Carbon\Carbon;
use RegCore\Http\Controllers as Core;

class ProductController extends Core\ProductController
{
    use Flow;

    /**
     * @return Filter
     */
    protected function getFilters()
    {
        return (new Filter())
            ->add('destination', 'is', 'organization')
            ->add('identifier', 'is not', 'additional-exhibitor-badge')
            ->add('active', 'is', 'yes')
            ->add('publish', 'is', 'yes')
            ->add('exhibitor_id', 'is null');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Buzz\EssentialsSdk\Exceptions\ErrorException
     */
    public function index()
    {
        customer()->expand(['assignedOrderProducts'])->reload();

        $freeVisitorTicket = [
            'p-access',
            'rights',
            'ww',
            'writers-summit',
            'forum',
        ];

        $basketInfo  = [];

        $visIncluded = false;

        $basket = getBasket();

        if ($basket && $basket->basket_products) {
            foreach ($basket->basket_products as $product) {
                $basketInfo[$product->product->identifier] = 'basket';

                if (in_array($product->product->identifier, $freeVisitorTicket)) {
                    $visIncluded = true;
                }
            }
        }

        if (customer()->assigned_order_products) {
            foreach (customer()->assigned_order_products as $product) {
                if ($product['order']['status'] != 'cancelled') {
                    $basketInfo[$product['identifier']] = 'booked';
                }
                if (in_array($product['identifier'], $freeVisitorTicket)) {
                    $visIncluded = true;
                }
            }
        }

        if (customer()->getPropertyByIdentifier('foc')) {
            $basketInfo['visitor'] = 'booked';
        }

        if ($visIncluded) {
            $basketInfo['visitor'] = 'included';
        }

        $productClashes = getProductClashes($basketInfo);

        // Convert the object to an array for custom sort order
        $productsRaw = (new Product())->get($this->getFilters(), 1, 1000)->keyBy('identifier');
        $products    = [];

        foreach ($productsRaw as $productRaw) {
            $products[$productRaw->identifier] = $productRaw;
        }

        $now = date_format(Carbon::now(), "Y-m-d H:i:s");

        $mondayEnd = date_format(date_create("2020-03-09 18:00:00"), "Y-m-d H:i:s");
        $tuesdayEnd = date_format(date_create("2020-03-10 13:00:00"), "Y-m-d H:i:s");
        $wednesdayEnd = date_format(date_create("2020-03-11 13:00:00"), "Y-m-d H:i:s");

        if ($now >= $mondayEnd) {
            unset($products['rights']);
        }

        if ($now >= $tuesdayEnd) {
            unset($products['ww']);
            unset($products['writers-summit']);
        }

        if ($now >= $wednesdayEnd) {
            unset($products['forum']);
        }

        $order = [
            'visitor',
            'p-access',
            'rights',
            'ww',
            'writers-summit',
            'forum',
        ];

        usort($products, function ($a, $b) use ($order) {
            $pos_a = array_search($a->identifier, $order);
            $pos_b = array_search($b->identifier, $order);

            return $pos_a - $pos_b;
        });

        return view('product.index', compact('products', 'basketInfo', 'productClashes'));
    }

    /**
     * @param $product_id
     * @param null $customer_id
     *
     * @return array|\Buzz\Helpers\Utilities\Bark|string
     * @throws \Buzz\EssentialsSdk\Exceptions\ErrorException
     */
    public function addProduct($product_id, $customer_id = null)
    {
        $product = (new Product())->first($this->getFilters()->add('id', 'is', $product_id));
        $customer = customer();

        if ($customer_id) {
            $customer = (new Customer())->find($customer_id);
        }

        $basket = getBasket();

        if (focVisitor() == 'student') {
            $basket->addProduct($product->id, $customer->id, 1, reducedRate());
        } else {
            $basket->addProduct($product->id, $customer->id);
        }

        session()->flash('flash_message', [
            'type'    => 'success',
            'title'   => transUi('Success!'),
            'message' => $product->name . ' ' . transUi('added to the basket.'),
        ]);

        if ($product->identifier == 'ww'){
            wwDiscounts();
        }

        if ($basket->basket_products) {
            foreach ($basket->basket_products as $product) {
                if ($product->product->identifier == 'visitor') {
                    $basket->removeByProduct($product->product->id);
                }
            }
        }

        return redirect()->route('basket');
    }

    public function removeProduct($product_id)
    {
        $product = (new Product())->first($this->getFilters()->add('id', 'is', $product_id));

        $basket = getBasket();

        if ($basket) {
            $basket->removeByProduct($product_id);
        }

        session()->flash('flash_message', [
            'type'    => 'success',
            'title'   => transUi('Success!'),
            'message' => $product->name . ' ' . transUi('removed from the basket.'),
        ]);

        return redirect()->route('products');
    }
}
