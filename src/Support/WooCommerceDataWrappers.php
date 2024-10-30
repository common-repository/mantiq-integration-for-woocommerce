<?php

namespace Mantiq\Support;

class WooCommerceDataWrappers
{
    public static function order(\WC_Order $order)
    {
        $data = $order->get_data();
        foreach (['line_items', 'tax_lines', 'shipping_lines', 'fee_lines', 'coupon_lines'] as $line) {
            $data["{$line}_formatted"] = [];

            $data[$line]               = array_map(
                static function (\WC_Order_Item $item) use ($order, &$data, $line) {
                    if ($item instanceof \WC_Order_Item_Product) {
                        $data["{$line}_formatted"][] = "• {$item->get_name()} × {$item->get_quantity()} (Total: {$item->get_total()} {$order->get_currency()})";
                    }

                    if ($item instanceof \WC_Order_Item_Coupon) {
                        $data["{$line}_formatted"][] = "• {$item->get_name()} (Discount: {$item->get_discount()} {$order->get_currency()})";
                    }

                    if ($item instanceof \WC_Order_Item_Tax) {
                        $data["{$line}_formatted"][] = "• {$item->get_name()} (Total: {$item->get_tax_total()} {$order->get_currency()})";
                    }

                    if ($item instanceof \WC_Order_Item_Fee) {
                        $data["{$line}_formatted"][] = "• {$item->get_name()} (Amount: {$item->get_amount()} {$order->get_currency()})";
                    }

                    return $item->get_data();
                },
                $data[$line]
            );
            $data["{$line}_formatted"] = implode("\r\n", $data["{$line}_formatted"]);
        }
        $data['total_formatted'] = html_entity_decode(strip_tags($order->get_formatted_order_total()));
        $data['view_url']        = $order->get_view_order_url();
        $data['edit_url']        = $order->get_edit_order_url();

        return $data;
    }

    public static function product(\WC_Product $product)
    {
        return $product->get_data();
    }

    public static function review(\WP_Comment $comment)
    {
        return $comment->to_array();
    }

    public static function note($note)
    {
        return get_object_vars($note);
    }

    public static function customer(\WC_Customer $customer)
    {
        return $customer->get_data();
    }

    public static function coupon(\WC_Coupon $coupon)
    {
        return $coupon->get_data();
    }
}
