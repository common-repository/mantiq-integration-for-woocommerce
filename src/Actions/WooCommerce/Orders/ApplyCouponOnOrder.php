<?php

namespace Mantiq\Actions\WooCommerce\Orders;

use Mantiq\Exceptions\ErrorException;
use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Support\WooCommerceDataTypes;
use WooCommerceIntegrationWithMantiq;

class ApplyCouponOnOrder extends Action
{
    public function getName()
    {
        return __('Apply coupon on order', 'mantiq');
    }

    public function getDescription()
    {
        return __('Apply a coupon on an order.', 'mantiq');
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
                    'id'          => 'success',
                    'name'        => __('Operation state', 'mantiq'),
                    'description' => __('Whether the operation succeeded or not.', 'mantiq'),
                    'type'        => DataType::boolean(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'          => 'order',
                    'name'        => __('Order object', 'mantiq'),
                    'description' => __('The order object.', 'mantiq'),
                    'type'        => WooCommerceDataTypes::WC_Order(),
                ]
            ),
        ];
    }

    public function getTemplate()
    {
        return WooCommerceIntegrationWithMantiq::getPath('views/actions/orders/apply-coupon-on-order.php');
    }

    public function invoke(ActionInvocationContext $invocation)
    {
        $rawOrderId = $invocation->getEvaluatedArgument('id');

        if (is_numeric($rawOrderId)) {
            $orderId = (int) $rawOrderId;
        } else {
            return [
                'success' => false,
                'error'   => new ErrorException("The order ID has not been provided."),
            ];
        }

        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);

        $userArguments = array_merge(
            [
                'id'     => (string) $orderId,
                'coupon' => trim((string) $invocation->getEvaluatedArgument('coupon', '')),
            ],
            $customArguments ?: []
        );

        $order = wc_get_order($userArguments['id']);
        $apply = $order instanceof \WC_Order;
        if (!$apply) {
            return [
                'success'  => false,
                'error'    => new ErrorException(
                    sprintf("The order could not be found: %s", $orderId)
                ),
                'order_id' => $orderId,
                'note'     => [],
                'order'    => [],
            ];
        }

        $order->remove_coupon($userArguments['coupon']);
        $apply = $order->apply_coupon($userArguments['coupon']);

        if ($apply instanceof \WP_Error) {
            return [
                'success'  => false,
                'error'    => new ErrorException(
                    sprintf("The coupon could not be applied: %s", $apply->get_error_message())
                ),
                'order_id' => $orderId,
                'order'    => [],
            ];
        }

        return [
            'success'  => true,
            'order_id' => $orderId,
            'order'    => $order->get_data(),
        ];
    }
}
