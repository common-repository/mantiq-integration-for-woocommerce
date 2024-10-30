<?php

namespace Mantiq\Triggers\Events\WooCommerce\Orders;

use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Models\TriggerEvent;
use Mantiq\Support\WooCommerceDataTypes;
use Mantiq\Support\WooCommerceDataWrappers;

class OrderNoteAdded extends TriggerEvent
{
    public function getId()
    {
        return 'woocommerce_order_note_added';
    }

    public function getName()
    {
        return __('Order note added', 'mantiq');
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
                    'id'   => 'order_note_id',
                    'name' => __('Order Note ID', 'mantiq'),
                    'type' => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'order_note',
                    'name' => __('Order note', 'mantiq'),
                    'type' => WooCommerceDataTypes::WC_Order_Note(),
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
            'order_note_id' => $eventArgs[0],
            'order_note'    => WooCommerceDataWrappers::note(wc_get_order_note($eventArgs[0])),
            'order'         => WooCommerceDataWrappers::order($eventArgs[1]),
        ];
    }
}
