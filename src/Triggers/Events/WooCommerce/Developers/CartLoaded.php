<?php

namespace Mantiq\Triggers\Events\WooCommerce\Developers;

use Mantiq\Models\TriggerEvent;

class CartLoaded extends TriggerEvent
{
    public function getId()
    {
        return 'woocommerce_cart_loaded_from_session';
    }

    public function getName()
    {
        return __('Cart loaded', 'mantiq');
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
