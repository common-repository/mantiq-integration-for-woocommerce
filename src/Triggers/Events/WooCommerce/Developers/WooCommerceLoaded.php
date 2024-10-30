<?php

namespace Mantiq\Triggers\Events\WooCommerce\Developers;

use Mantiq\Models\TriggerEvent;

class WooCommerceLoaded extends TriggerEvent
{
    public function getId()
    {
        return 'woocommerce_loaded';
    }

    public function getName()
    {
        return __('WooCommerce loaded', 'mantiq');
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
