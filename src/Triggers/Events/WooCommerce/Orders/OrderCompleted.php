<?php

namespace Mantiq\Triggers\Events\WooCommerce\Orders;

use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Models\TriggerEvent;
use Mantiq\Support\WooCommerceDataTypes;
use Mantiq\Support\WooCommerceDataWrappers;

class OrderCompleted extends TriggerEvent
{
    public function getId()
    {
        return 'woocommerce_order_status_completed';
    }

    public function getName()
    {
        return __('Order marked as completed', 'mantiq');
    }

    public function getGroup()
    {
        return __('Orders - WooCommerce', 'mantiq');
    }

    public function getOutputs()
    {
        return [
            new OutputDefinition(
                [
                    'id'   => 'order_id',
                    'name' => __('Order ID', 'mantiq'),
                    'type' => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'order_permalink',
                    'name' => __('Order permalink', 'mantiq'),
                    'type' => DataType::string(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'order',
                    'name' => __('Order object', 'mantiq'),
                    'type' => WooCommerceDataTypes::WC_Order(),
                ]
            ),
        ];
    }

    public function getNamedArgumentsFromRawEvent($eventArgs)
    {
        return [
            'order_id'        => $eventArgs[0],
            'order_permalink' => get_permalink($eventArgs[0]),
            'order'           => WooCommerceDataWrappers::order($eventArgs[1]),
        ];
    }
}
