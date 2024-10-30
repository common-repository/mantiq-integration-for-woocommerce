<?php

namespace Mantiq\Triggers\Events\WooCommerce\Developers;

use Mantiq\Models\TriggerEvent;

class WooCommerceInit extends TriggerEvent
{
    public function getId()
    {
        return 'woocommerce_init';
    }

    public function getName()
    {
        return __('WooCommerce init', 'mantiq');
    }

    public function getGroup()
    {
        return __('Developers - WooCommerce', 'mantiq');
    }

    public function getOutputs()
    {
        return [];
    }

    public function getNamedArgumentsFromRawEvent($eventArgs)
    {
        return [];
    }
}
