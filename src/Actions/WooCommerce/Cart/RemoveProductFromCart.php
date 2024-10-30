<?php

namespace Mantiq\Actions\WooCommerce\Cart;

use WooCommerceIntegrationWithMantiq;
use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Support\WooCommerceDataTypes;

class RemoveProductFromCart extends Action
{
    public function getName()
    {
        return __('Remove product from cart', 'mantiq');
    }

    public function getDescription()
    {
        return __('Remove a product from the current cart.', 'mantiq');
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
        return WooCommerceIntegrationWithMantiq::getPath('views/actions/cart/remove-product-from-cart.php');
    }

    /**
     * @throws \Exception
     */
    public function invoke(ActionInvocationContext $invocation)
    {
        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);

        $userArguments = array_merge(
            [
                'items' => (array) $invocation->getArgument('items', []),
            ],
            $customArguments ?: []
        );

        wc_load_cart();
        $cart           = WC()->cart;
        $productMapping = [];
        foreach ($cart->get_cart_contents() as $cartItem) {
            $productMapping[$cartItem['product_id']] = $cartItem['key'];
        }

        foreach ($userArguments['items'] as $item) {
            if (!is_numeric($item['id'])) {
                $item['id'] = get_page_by_path(trim($item['id']), OBJECT, 'product')->ID;
            }

            if (isset($productMapping[$item['id']])) {
                $cart->remove_cart_item($productMapping[$item['id']]);
            }
        }

        $cart->calculate_totals();

        return [
            'success' => true,
            'cart'    => $cart,
        ];
    }
}
