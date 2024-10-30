<?php
/*
 * Plugin Name: Mantiq Integration for WooCommerce
 * Plugin URI: https://wpmantiq.com/
 * Description: An integration between WooCommerce and Mantiq that allows you to build the automations you need in your WooCommerce-based shop with LEGO-like building blocks instead of writing code.
 * Version: 1.0.0
 * Author: Mantiq
 * Text Domain: mantiq
 * Domain Path: languages
 * Requires at least: 5.0
 * Requires PHP: 7.0
 * Tested up to: 5.8.2
 *
 * @package Mantiq
 * @category Core
 * @author Mantiq
 * @version 1.0.0
 */

use Mantiq\Actions\WooCommerce\Cart\AddProductToCart;
use Mantiq\Actions\WooCommerce\Cart\ApplyCouponOnCart;
use Mantiq\Actions\WooCommerce\Cart\EmptyCart;
use Mantiq\Actions\WooCommerce\Cart\RemoveCouponAppliedOnCart;
use Mantiq\Actions\WooCommerce\Cart\RemoveProductFromCart;
use Mantiq\Actions\WooCommerce\Coupons\CreateCoupon;
use Mantiq\Actions\WooCommerce\Coupons\DeleteCoupon;
use Mantiq\Actions\WooCommerce\Orders\AddFeeItemToOrder;
use Mantiq\Actions\WooCommerce\Orders\AddNoteToOrder;
use Mantiq\Actions\WooCommerce\Orders\AddProductItemToOrder;
use Mantiq\Actions\WooCommerce\Orders\ApplyCouponOnOrder;
use Mantiq\Actions\WooCommerce\Orders\ChangeOrderStatus;
use Mantiq\Actions\WooCommerce\Orders\GetOrder;
use Mantiq\Actions\WooCommerce\Orders\RefundOrder;
use Mantiq\Actions\WooCommerce\Orders\RemoveCouponFromOrder;
use Mantiq\Actions\WooCommerce\Orders\RemoveProductItemToOrder;
use Mantiq\Actions\WooCommerce\Orders\ResendNewOrderNotification;
use Mantiq\Actions\WooCommerce\Orders\ResendOrderDetailsToCustomer;
use Mantiq\Triggers\Events\WooCommerce\Customers\AccountCreated;
use Mantiq\Triggers\Events\WooCommerce\Developers\CartLoaded;
use Mantiq\Triggers\Events\WooCommerce\Developers\WooCommerceInit;
use Mantiq\Triggers\Events\WooCommerce\Developers\WooCommerceLoaded;
use Mantiq\Triggers\Events\WooCommerce\Orders\OrderCreated;
use Mantiq\Triggers\Events\WooCommerce\Orders\OrderNoteAdded;
use Mantiq\Triggers\Events\WooCommerce\Orders\OrderStatusChanged;
use Mantiq\Triggers\Events\WooCommerce\Reviews\ReviewPosted;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WooCommerceIntegrationWithMantiq')) {
    class WooCommerceIntegrationWithMantiq
    {
        public static function bootstrap(\Mantiq\Plugin $plugin)
        {
            if (!$plugin::isPluginActive('woocommerce/woocommerce.php')) {
                add_action('admin_notices', function () {
                    if (get_current_screen()->base === 'plugins' && is_admin() && current_user_can('manage_options')) {
                        echo '<div class="notice error"><p>Mantiq WooCommerce integration requires WooCommerce to be active. Please install and activate WooCommerce plugin.</p></div>';
                    }
                });

                return;
            }

            $plugin->loader->addPsr4('Mantiq\\', [__DIR__.'/src']);

            // Orders
            OrderCreated::register();
            //OrderPending::register();
            //OrderProcessing::register();
            //OrderOnHold::register();
            //OrderCompleted::register();
            //OrderRefunded::register();
            //OrderCancelled::register();
            OrderStatusChanged::register();
            OrderNoteAdded::register();

            // Accounts
            AccountCreated::register();

            // Reviews
            ReviewPosted::register();

            // Carts (soon)
            // CartAbandoned::register();

            // Coupons
            CreateCoupon::register();
            DeleteCoupon::register();

            // Orders
            GetOrder::register();
            AddProductItemToOrder::register();
            RemoveProductItemToOrder::register();
            AddFeeItemToOrder::register();
            ChangeOrderStatus::register();
            AddNoteToOrder::register();
            RefundOrder::register();
            ApplyCouponOnOrder::register();
            RemoveCouponFromOrder::register();
            ResendNewOrderNotification::register();
            ResendOrderDetailsToCustomer::register();

            // Cart
            AddProductToCart::register();
            RemoveProductFromCart::register();
            ApplyCouponOnCart::register();
            RemoveCouponAppliedOnCart::register();
            EmptyCart::register();

            // Developers
            WooCommerceLoaded::register();
            WooCommerceInit::register();
            CartLoaded::register();
        }

        /**
         * @param  string  $path
         *
         * @return string
         */
        public static function getPath(string $path = ''): string
        {
            return wp_normalize_path(__DIR__.DIRECTORY_SEPARATOR.$path);
        }

    }

    add_action('mantiq/init', ['WooCommerceIntegrationWithMantiq', 'bootstrap']);
}
