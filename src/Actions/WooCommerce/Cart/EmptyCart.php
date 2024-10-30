<?php

namespace Mantiq\Actions\WooCommerce\Cart;

use WooCommerceIntegrationWithMantiq;
use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;

class EmptyCart extends Action
{
    public function getName()
    {
        return __('Empty cart', 'mantiq');
    }

    public function getDescription()
    {
        return __('Empty the current cart.', 'mantiq');
    }

    public function getGroup()
    {
        return __('Cart - WooCommerce', 'mantiq');
    }

    public function getOutputs()
    {
        return [
            new OutputDefinition(
                [
                    'id'          => 'success',
                    'name'        => __('Operation state', 'mantiq'),
                    'description' => __('Whether the operation succeeded or not.', 'mantiq'),
                    'type'        => DataType::boolean(),
                ]
            ),
        ];
    }

    public function getTemplate()
    {
        return WooCommerceIntegrationWithMantiq::getPath('views/actions/cart/empty-cart.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        wc_load_cart();

        if (!WC()->cart->is_empty()) {
            WC()->cart->empty_cart();
        }

        return [
            'success' => true,
        ];
    }
}
