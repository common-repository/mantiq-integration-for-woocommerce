<?php

namespace Mantiq\Triggers\Events\WooCommerce\Customers;

use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Models\TriggerEvent;
use Mantiq\Support\WooCommerceDataTypes;
use Mantiq\Support\WooCommerceDataWrappers;

class AccountCreated extends TriggerEvent
{
    public function getId()
    {
        return 'woocommerce_created_customer';
    }

    public function getName()
    {
        return __('Account created', 'mantiq');
    }

    public function getGroup()
    {
        return __('Customers - WooCommerce', 'mantiq');
    }

    public function getOutputs()
    {
        return [
            new OutputDefinition(
                [
                    'id'   => 'customer_id',
                    'name' => __('Customer ID', 'mantiq'),
                    'type' => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'customer',
                    'name' => __('Customer object', 'mantiq'),
                    'type' => WooCommerceDataTypes::WC_Customer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'password_generated',
                    'name' => __('Generated password', 'mantiq'),
                    'type' => DataType::string(),
                ]
            ),
        ];
    }

    /**
     * @throws \Exception
     */
    public function getNamedArgumentsFromRawEvent($eventArgs)
    {
        return [
            'customer_id'        => $eventArgs[0],
            'customer'           => WooCommerceDataWrappers::customer(new \WC_Customer($eventArgs[0])),
            'password_generated' => $eventArgs[2],
        ];
    }
}
