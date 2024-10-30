<?php

namespace Mantiq\Actions\WooCommerce\Orders;

use Mantiq\Exceptions\ErrorException;
use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Support\WooCommerceDataTypes;
use WooCommerceIntegrationWithMantiq;

class AddProductItemToOrder extends Action
{
    public function getName()
    {
        return __('Add product item to order', 'mantiq');
    }

    public function getDescription()
    {
        return __('Add a product item to an order', 'mantiq');
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
        return WooCommerceIntegrationWithMantiq::getPath('views/actions/orders/add-product-item-to-order.php');
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
                'id'                  => (string) $orderId,
                'items'               => (array) $invocation->getArgument('items', []),
                'recalculate_totals'  => (boolean) $invocation->getEvaluatedArgument('recalculate_totals', false),
                'override_quantities' => (boolean) $invocation->getEvaluatedArgument('override_quantities', false),
                'only_non_existing'   => (boolean) $invocation->getEvaluatedArgument('only_non_existing', false),
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

        $orderProducts = [];
        foreach ($order->get_items() as $item) {
            $orderProducts[$item->get_product_id()] = $item;
        }

        foreach ($userArguments['items'] as $item) {
            if (!is_numeric($item['id'])) {
                $item['id'] = get_page_by_path(trim($item['id']), OBJECT, 'product')->ID;
            }

            if (isset($orderProducts[$item['id']]) && $userArguments['only_non_existing']) {
                if ($userArguments['override_quantities']) {
                    $orderProducts[$item['id']]->set_quantity($item['quantity']);
                    $orderProducts[$item['id']]->save();
                }

                continue;
            }

            $product = wc_get_product($item['id']);
            if ($product instanceof \WC_Product) {
                $order->add_product($product, $item['quantity']);
            }
        }

        if (!empty($userArguments['recalculate_totals'])) {
            $order->calculate_totals();
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
