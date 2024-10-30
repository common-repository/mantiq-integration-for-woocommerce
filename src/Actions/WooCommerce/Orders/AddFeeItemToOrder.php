<?php

namespace Mantiq\Actions\WooCommerce\Orders;

use Mantiq\Exceptions\ErrorException;
use WooCommerceIntegrationWithMantiq;
use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Support\WooCommerceDataTypes;
use WC_Order_Item_Fee;

class AddFeeItemToOrder extends Action
{
    public function getName()
    {
        return __('Add fee item to order', 'mantiq');
    }

    public function getDescription()
    {
        return __('Add a fee item to an order', 'mantiq');
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
                    'id'          => 'items',
                    'name'        => __('Item object', 'mantiq'),
                    'description' => __('The order item object.', 'mantiq'),
                    'type'        => WooCommerceDataTypes::WC_Order_Note(),
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
        return WooCommerceIntegrationWithMantiq::getPath('views/actions/orders/add-fee-item-to-order.php');
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
                'id'                 => (string) $orderId,
                'items'              => (array) $invocation->getArgument('items', []),
                'recalculate_totals' => (boolean) $invocation->getEvaluatedArgument('recalculate_totals', false),
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
                'items'    => [],
                'order'    => [],
            ];
        }

        $orderFees = [];
        /**
         * @var $item \WC_Order_Item_Fee
         * @var $orderFees \WC_Order_Item_Fee[]
         */
        foreach ($order->get_items('fee') as $item) {
            $orderFees[$item->get_name()] = $item;
        }

        $calculate_tax_args = [
            'country'  => $order->get_billing_country(),
            'state'    => $order->get_billing_state(),
            'postcode' => $order->get_billing_postcode(),
            'city'     => $order->get_billing_city(),
        ];

        foreach ($userArguments['items'] as $item) {
            $amount = wc_clean(wp_unslash($item['amount']));

            if (strpos($amount, '%') !== false) {
                $order->calculate_totals(false);
                $formatted_amount = $amount;
                $percent          = (float) trim($amount, '%');
                $amount           = $order->get_total() * ($percent / 100);
            } else {
                $amount           = (float) $amount;
                $formatted_amount = wc_price($amount, ['currency' => $order->get_currency()]);
            }

            $name = $item['name'] ?: sprintf(__('%s fee', 'woocommerce'), wc_clean($formatted_amount));

            $fee = $orderFees[$name] ?? new WC_Order_Item_Fee();

            $fee->set_amount($amount);
            $fee->set_total($amount);
            $fee->set_name($name);
            $fee->save();

            if (empty($orderFees[$name])) {
                $order->add_item($fee);
            }

            $order->calculate_taxes($calculate_tax_args);
            $order->calculate_totals(false);
        }

        return [
            'success'  => true,
            'order_id' => $orderId,
            'order'    => $order->get_data(),
            'items'    => array_map(
                static function (\WC_Order_Item $item) {
                    return $item->get_data();
                },
                $order->get_items()
            ),
        ];
    }
}
