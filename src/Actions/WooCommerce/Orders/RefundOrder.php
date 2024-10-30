<?php

namespace Mantiq\Actions\WooCommerce\Orders;

use Mantiq\Exceptions\ErrorException;
use WooCommerceIntegrationWithMantiq;
use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Support\WooCommerceDataTypes;

class RefundOrder extends Action
{
    public function getName()
    {
        return __('Refund', 'mantiq');
    }

    public function getDescription()
    {
        return __('Refund an order.', 'mantiq');
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
                    'description' => __('The updated order object.', 'mantiq'),
                    'type'        => WooCommerceDataTypes::WC_Order(),
                ]
            ),
        ];
    }

    public function getTemplate()
    {
        return WooCommerceIntegrationWithMantiq::getPath('views/actions/orders/refund-order.php');
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
                'id'      => (string) $orderId,
                'amount'  => (string) $invocation->getEvaluatedArgument('amount', ''),
                'restock' => (boolean) $invocation->getEvaluatedArgument('restock', false),
                'reason'  => (string) $invocation->getEvaluatedArgument('reason', ''),
            ],
            $customArguments ?: []
        );

        $order   = wc_get_order($userArguments['id']);
        $success = $order instanceof \WC_Order;

        if (!$success) {
            return [
                'success'  => false,
                'error'    => new ErrorException("The order could not be found"),
                'order_id' => $orderId,
                'order'    => [],
            ];
        }

        $refundAmount = $order->get_total();

        if (strpos($userArguments['amount'], '%') !== false) {
            $percent        = (float) trim($userArguments['amount'], '%');
            $refundedAmount = $refundAmount * ($percent / 100);
        } else {
            $refundedAmount = $refundAmount - (float) $userArguments['amount'];
        }

        try {
            // Create the refund object.
            $refund = wc_create_refund(
                [
                    'amount'         => $refundedAmount,
                    'reason'         => $userArguments['reason'],
                    'order_id'       => $orderId,
                    'refund_payment' => false,
                    'restock_items'  => $userArguments['restock'],
                ]
            );

            if (is_wp_error($refund)) {
                return [
                    'success'  => false,
                    'error'    => new ErrorException(
                        sprintf("The order could not be refunded: %s", $refund->get_error_message())
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
        } catch (\Exception $exception) {
            return [
                'success'  => false,
                'error'    => new ErrorException(
                    sprintf("The order could not be refunded: %s", $exception->get_error_message())
                ),
                'order_id' => $orderId,
                'order'    => [],
            ];
        }
    }
}
