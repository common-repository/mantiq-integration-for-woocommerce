<?php

namespace Mantiq\Actions\WooCommerce\Orders;

use Mantiq\Exceptions\ErrorException;
use WooCommerceIntegrationWithMantiq;
use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Support\WooCommerceDataTypes;
use WC_Data_Store;

class RegenerateDownloadPermissions extends Action
{
    public function getName()
    {
        return __('Regenerate download permissions', 'mantiq');
    }

    public function getDescription()
    {
        return __('Regenerate download permissions', 'mantiq');
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
        return WooCommerceIntegrationWithMantiq::getPath('views/actions/orders/regenerate-download-permissions.php');
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

        $data_store = WC_Data_Store::load('customer-download');
        $data_store->delete_by_order_id($order->get_id());
        wc_downloadable_product_permissions($order->get_id(), true);

        return [
            'success'  => true,
            'order_id' => $orderId,
            'order'    => $order->get_data(),
        ];
    }
}
