<?php

namespace Mantiq\Actions\WooCommerce\Cart;

use WooCommerceIntegrationWithMantiq;
use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Support\WooCommerceDataTypes;

class ApplyCouponOnCart extends Action
{
    public function getName()
    {
        return __('Apply coupon on cart', 'mantiq');
    }

    public function getDescription()
    {
        return __('Apply a coupon on the current cart.', 'mantiq');
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
            new OutputDefinition(
                [
                    'id'          => 'cart',
                    'name'        => __('Cart object', 'mantiq'),
                    'description' => __('The cart object.', 'mantiq'),
                    'type'        => WooCommerceDataTypes::WC_Cart(),
                ]
            ),
        ];
    }

    public function getTemplate()
    {
        return WooCommerceIntegrationWithMantiq::getPath('views/actions/cart/apply-coupon-on-cart.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);

        $userArguments = array_merge(
            [
                'coupon' => trim((string) $invocation->getEvaluatedArgument('coupon', '')),
            ],
            $customArguments ?: []
        );

        wc_load_cart();
        $success = false;

        if (!WC()->cart->has_discount($userArguments['coupon'])) {
            $success = WC()->cart->apply_coupon($userArguments['coupon']);
            WC()->cart->calculate_totals();
        }

        return [
            'success' => $success,
            'cart'    => WC()->cart,
        ];
    }
}
