<?php

namespace Mantiq\Actions\WooCommerce\Coupons;

use Mantiq\Exceptions\ErrorException;
use WooCommerceIntegrationWithMantiq;
use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Support\WooCommerceDataTypes;

class CreateCoupon extends Action
{
    public function getName()
    {
        return __('Create coupon', 'mantiq');
    }

    public function getDescription()
    {
        return __('Create a coupon.', 'mantiq');
    }

    public function getGroup()
    {
        return __('Coupons - WooCommerce', 'mantiq');
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
                    'id'          => 'coupon',
                    'name'        => __('Coupon Object', 'mantiq'),
                    'description' => __('The coupon object.', 'mantiq'),
                    'type'        => WooCommerceDataTypes::WC_Coupon(),
                ]
            ),
        ];
    }

    public function getTemplate()
    {
        return WooCommerceIntegrationWithMantiq::getPath('views/actions/coupons/create-coupon.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);

        $userArguments = array_merge(
            [
                'prefix'                => (string) $invocation->getEvaluatedArgument('prefix', 'GEN'),
                'discount_type'         => (string) $invocation->getEvaluatedArgument('discount_type', 'fixed_cart'),
                'amount'                => (float) $invocation->getEvaluatedArgument('amount', 0),
                'free_shipping'         => (boolean) $invocation->getEvaluatedArgument('free_shipping', false),
                'date_expires'          => (string) $invocation->getEvaluatedArgument('date_expires', ''),
                'date_expires_interval' => (integer) $invocation->getEvaluatedArgument('date_expires_interval', 0),
                'usage_limit'           => (integer) $invocation->getEvaluatedArgument('usage_limit', 0),
            ],
            $customArguments ?: []
        );

        $userArguments['code'] = strtoupper(
            wc_sanitize_coupon_code($userArguments['prefix'].'-'.wp_generate_password(6, false))
        );

        if (!empty($userArguments['date_expires']) && $userArguments['date_expires'] === 'days') {
            $userArguments['date_expires'] = wc_string_to_timestamp(
                "+{$userArguments['date_expires_interval']} days"
            );
        }

        $coupon = new \WC_Coupon($userArguments);

        foreach ($userArguments as $argument => $value) {
            $setter = "set_{$argument}";
            if (method_exists($coupon, $setter)) {
                $coupon->{$setter}($value);
            }
        }

        $couponId = $coupon->save();

        if ($couponId === 0) {
            return [
                'success' => false,
                'error'   => new ErrorException(
                    sprintf("The coupon could not be created: %s", $userArguments['code'])
                ),
            ];
        }

        return [
            'success'   => true,
            'coupon_id' => $couponId,
            'coupon'    => $coupon->get_data(),
        ];
    }
}
