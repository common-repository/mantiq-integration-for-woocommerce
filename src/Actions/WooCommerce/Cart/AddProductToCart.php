<?php

namespace Mantiq\Actions\WooCommerce\Cart;

use WooCommerceIntegrationWithMantiq;
use Mantiq\Models\Action;
use Mantiq\Models\ActionInvocationContext;
use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Support\WooCommerceDataTypes;

class AddProductToCart extends Action
{
    public function getName()
    {
        return __('Add product to cart', 'mantiq');
    }

    public function getDescription()
    {
        return __('Add a product to the current cart.', 'mantiq');
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
        return WooCommerceIntegrationWithMantiq::getPath('views/actions/cart/add-product-to-cart.php');
    }

    /**
     * @throws \Exception
     */
    public function invoke(ActionInvocationContext $invocation)
    {
        $customArguments = json_decode($invocation->getEvaluatedArgument('customArguments', '{}'), true);

        $userArguments = array_merge(
            [
                'items'               => (array) $invocation->getArgument('items', []),
                'override_quantities' => (boolean) $invocation->getEvaluatedArgument('override_quantities', false),
                'only_non_existing'   => (boolean) $invocation->getEvaluatedArgument('only_non_existing', false),
            ],
            $customArguments ?: []
        );

        wc_load_cart();
        $cart = WC()->cart;
        foreach ($userArguments['items'] as $item) {
            if (!is_numeric($item['id'])) {
                $item['id'] = get_page_by_path(trim($item['id']), OBJECT, 'product')->ID;
            }

            $cartProductId = $cart->add_to_cart($item['id'], $item['quantity']);

            if ($userArguments['only_non_existing'] && $userArguments['override_quantities']) {
                $cart->set_quantity($cartProductId, $item['quantity']);
            }
        }

        $cart->calculate_totals();

        return [
            'success' => true,
            'cart'    => $cart,
        ];
    }
}
