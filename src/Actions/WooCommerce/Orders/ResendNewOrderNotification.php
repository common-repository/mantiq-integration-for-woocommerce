<?php

namespace Mantiq\Actions\WooCommerce\Orders;

use Mantiq\Exceptions\ErrorException;
use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Support\WooCommerceDataTypes;
use WooCommerceIntegrationWithMantiq;

class ResendNewOrderNotification extends Action
{
    public function getName()
    {
        return __('Resend new order notification', 'mantiq');
    }

    public function getDescription()
    {
        return __('Resend new order notification', 'mantiq');
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
        return WooCommerceIntegrationWithMantiq::getPath('views/actions/orders/resend-new-order-notification.php');
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
                'id' => (string) $orderId,
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

        do_action('woocommerce_before_resend_order_emails', $order, 'new_order');
        WC()->payment_gateways();
        WC()->shipping();
        add_filter('woocommerce_new_order_email_allows_resend', '__return_true');
        $email = WC()->mailer()->emails['WC_Email_New_Order'];
        if (!empty($userArguments['recipient'])) {
            $email->recipient = $userArguments['recipient'];
        }
        $email->trigger($order->get_id(), $order, true);
        remove_filter('woocommerce_new_order_email_allows_resend', '__return_true');
        do_action('woocommerce_after_resend_order_email', $order, 'new_order');

        return [
            'success'  => true,
            'order_id' => $orderId,
            'order'    => $order->get_data(),
        ];
    }
}
