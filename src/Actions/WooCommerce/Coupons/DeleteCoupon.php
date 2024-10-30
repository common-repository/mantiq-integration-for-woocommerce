<?php

namespace Mantiq\Actions\WooCommerce\Coupons;

use Mantiq\Exceptions\ErrorException;
use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Support\WooCommerceDataWrappers;
use WooCommerceIntegrationWithMantiq;

class DeleteCoupon extends Action
{
    public function getName()
    {
        return __('Delete coupon', 'mantiq');
    }

    public function getDescription()
    {
        return __('Delete a coupon.', 'mantiq');
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
        ];
    }

    public function getTemplate()
    {
        return WooCommerceIntegrationWithMantiq::getPath('views/actions/coupons/delete-coupon.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);

        $userArguments = array_merge(
            [
                'coupon' => wc_sanitize_coupon_code((string) $invocation->getEvaluatedArgument('coupon', '')),
            ],
            $customArguments ?: []
        );

        $coupon     = new \WC_Coupon($userArguments['coupon']);
        $couponData = WooCommerceDataWrappers::coupon($coupon);
        $couponId   = $coupon->delete($userArguments['force_delete'] ?? false);

        if (!$coupon->get_id() || !$couponId) {
            return [
                'success' => false,
                'error'   => new ErrorException(
                    sprintf("The coupon could not be deleted: %s", $userArguments['coupon'])
                ),
            ];
        }

        return [
            'success' => true,
            'coupon'  => $couponData,
        ];
    }
}
