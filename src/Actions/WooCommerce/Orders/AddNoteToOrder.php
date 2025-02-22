<?php

namespace Mantiq\Actions\WooCommerce\Orders;

use Mantiq\Exceptions\ErrorException;
use WooCommerceIntegrationWithMantiq;
use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Support\WooCommerceDataTypes;

class AddNoteToOrder extends Action
{
    public function getName()
    {
        return __('Add order note', 'mantiq');
    }

    public function getDescription()
    {
        return __('Add a note to an order.', 'mantiq');
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
                    'id'          => 'note',
                    'name'        => __('Note object', 'mantiq'),
                    'description' => __('The order note object.', 'mantiq'),
                    'type'        => WooCommerceDataTypes::WC_Order_Note(),
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
        return WooCommerceIntegrationWithMantiq::getPath('views/actions/orders/add-note-to-order.php');
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
                'id'               => (string) $orderId,
                'note'             => (string) $invocation->getEvaluatedArgument('note', ''),
                'is_customer_note' => (boolean) $invocation->getEvaluatedArgument('is_customer_note', ''),
            ],
            $customArguments ?: []
        );

        $order   = wc_get_order($userArguments['id']);
        $success = $order instanceof \WC_Order;

        if ($success) {
            $orderNoteId = $order->add_order_note($userArguments['note'], $userArguments['is_customer_note']);
        }

        if (!$success || !$orderNoteId) {
            return [
                'success'  => false,
                'error'    => new ErrorException(
                    sprintf("The order note could not be added: %s", $orderId)
                ),
                'order_id' => $orderId,
                'note'     => [],
                'order'    => [],
            ];
        }

        return [
            'success'  => true,
            'order_id' => $orderId,
            'note'     => get_comment($orderNoteId),
            'order'    => $order->get_data(),
        ];
    }
}
