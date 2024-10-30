<?php

namespace Mantiq\Triggers\Events\WooCommerce\Carts;

use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Models\TriggerEvent;
use Mantiq\Support\WooCommerceDataTypes;

class CartAbandoned extends TriggerEvent
{
    public function getId()
    {
        return 'woocommerce_cart_abandoned';
    }

    public function getName()
    {
        return __('Cart abandoned', 'mantiq');
    }

    public function getGroup()
    {
        return __('Carts - WooCommerce', 'mantiq');
    }

    public function getOutputs()
    {
        return [
            new OutputDefinition(
                [
                    'id'   => 'cart_id',
                    'name' => __('Cart ID', 'mantiq'),
                    'type' => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'cart',
                    'name' => __('Cart object', 'mantiq'),
                    'type' => WooCommerceDataTypes::WC_Cart(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'customer',
                    'name' => __('Customer object', 'mantiq'),
                    'type' => WooCommerceDataTypes::WC_Customer(),
                ]
            ),
        ];
    }

    public function getNamedArgumentsFromRawEvent($eventArgs)
    {
        return [
            'cart_id'  => null,
            'cart'     => null,
            'customer' => null,
        ];
    }
}
