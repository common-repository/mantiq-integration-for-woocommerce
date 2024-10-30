<?php

namespace Mantiq\Support;

use Mantiq\Models\DataType;

class WooCommerceDataTypes
{
    public static function WC_Order()
    {
        return DataType::object(
            [
                [
                    'id'   => 'id',
                    'name' => 'Order ID',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'status',
                    'name' => 'Order status',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'currency',
                    'name' => 'Order currency',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'order_key',
                    'name' => 'Order Key',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'customer_id',
                    'name' => 'Order customer ID',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'date_created',
                    'name' => 'Order creation date',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'date_modified',
                    'name' => 'Order modification date',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'discount_total',
                    'name' => 'Order discount total',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'shipping_total',
                    'name' => 'Order shipping total',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'total',
                    'name' => 'Order total',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'total_formatted',
                    'name' => 'Order total (formatted)',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'total_tax',
                    'name' => 'Order total (with taxes)',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'parent_id',
                    'name' => 'Order parent ID',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'order_status',
                    'name' => 'Order status',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'payment_method',
                    'name' => 'Payment method ID',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'payment_method_title',
                    'name' => 'Payment method title',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'transaction_id',
                    'name' => 'Transaction ID',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'customer_ip_address',
                    'name' => 'Customer IP',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'customer_user_agent',
                    'name' => 'Customer User Agent',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'customer_note',
                    'name' => 'Customer note',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'date_paid',
                    'name' => 'Date paid',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'date_completed',
                    'name' => 'Date completed',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'created_via',
                    'name' => 'Created via',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'cart_hash',
                    'name' => 'Cart hash',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'view_url',
                    'name' => 'Order URL',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'edit_url',
                    'name' => 'Order edit URL',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'billing',
                    'name' => 'Billing',
                    'type' => DataType::map(
                        [
                            [
                                'id'   => 'first_name',
                                'name' => 'First name',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'last_name',
                                'name' => 'Last name',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'company',
                                'name' => 'Company',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'address_1',
                                'name' => 'Address 1',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'address_2',
                                'name' => 'Address 2',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'city',
                                'name' => 'City',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'state',
                                'name' => 'State',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'postcode',
                                'name' => 'Postcode',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'country',
                                'name' => 'Country',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'email',
                                'name' => 'Email',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'phone',
                                'name' => 'Phone',
                                'type' => DataType::string(),
                            ],
                        ]
                    ),
                ],
                [
                    'id'   => 'shipping',
                    'name' => 'Shipping',
                    'type' => DataType::map(
                        [
                            [
                                'id'   => 'first_name',
                                'name' => 'First name',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'last_name',
                                'name' => 'Last name',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'company',
                                'name' => 'Company',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'address_1',
                                'name' => 'Address 1',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'address_2',
                                'name' => 'Address 2',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'city',
                                'name' => 'City',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'state',
                                'name' => 'State',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'postcode',
                                'name' => 'Postcode',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'country',
                                'name' => 'Country',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'email',
                                'name' => 'Email',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'phone',
                                'name' => 'Phone',
                                'type' => DataType::string(),
                            ],
                        ]
                    ),
                ],
            ]
        );
    }

    public static function WC_Customer()
    {
        return DataType::object(
            [
                [
                    'id'   => 'username',
                    'name' => 'Customer username',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'display_name',
                    'name' => 'Customer display name',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'last_name',
                    'name' => 'Customer last name',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'first_name',
                    'name' => 'Customer first name',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'email',
                    'name' => 'Customer email',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'date_created',
                    'name' => 'Order creation date',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'date_modified',
                    'name' => 'Order modification date',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'is_paying_customer',
                    'name' => 'Is paying customer',
                    'type' => DataType::boolean(),
                ],
                [
                    'id'   => 'billing',
                    'name' => 'Billing',
                    'type' => DataType::map(
                        [
                            [
                                'id'   => 'first_name',
                                'name' => 'First name',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'last_name',
                                'name' => 'Last name',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'company',
                                'name' => 'Company',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'address_1',
                                'name' => 'Address 1',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'address_2',
                                'name' => 'Address 2',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'city',
                                'name' => 'City',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'state',
                                'name' => 'State',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'postcode',
                                'name' => 'Postcode',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'country',
                                'name' => 'Country',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'email',
                                'name' => 'Email',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'phone',
                                'name' => 'Phone',
                                'type' => DataType::string(),
                            ],
                        ]
                    ),
                ],
                [
                    'id'   => 'shipping',
                    'name' => 'Shipping',
                    'type' => DataType::map(
                        [
                            [
                                'id'   => 'first_name',
                                'name' => 'First name',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'last_name',
                                'name' => 'Last name',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'company',
                                'name' => 'Company',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'address_1',
                                'name' => 'Address 1',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'address_2',
                                'name' => 'Address 2',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'city',
                                'name' => 'City',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'state',
                                'name' => 'State',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'postcode',
                                'name' => 'Postcode',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'country',
                                'name' => 'Country',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'email',
                                'name' => 'Email',
                                'type' => DataType::string(),
                            ],
                            [
                                'id'   => 'phone',
                                'name' => 'Phone',
                                'type' => DataType::string(),
                            ],
                        ]
                    ),
                ],
            ]
        );
    }

    public static function WC_Order_Note()
    {
        return DataType::object(
            [
                [
                    'id'   => 'id',
                    'name' => 'Note ID',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'date_created',
                    'name' => 'Note creation date',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'content',
                    'name' => 'Note content',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'customer_note',
                    'name' => 'Is customer note',
                    'type' => DataType::boolean(),
                ],
                [
                    'id'   => 'added_by',
                    'name' => 'Added by',
                    'type' => DataType::string(),
                ],
            ]
        );
    }

    public static function WC_Review()
    {
        return DataType::object(
            [
                [
                    'id'   => 'comment_ID',
                    'name' => 'Review ID',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'comment_post_ID',
                    'name' => 'Review post ID',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'comment_parent',
                    'name' => 'Review parent ID',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'user_id',
                    'name' => 'Review author user ID',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'comment_content',
                    'name' => 'Review content',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'comment_author',
                    'name' => 'Review author name',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'comment_author_email',
                    'name' => 'Review author email',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'comment_author_url',
                    'name' => 'Review author URL',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'comment_author_IP',
                    'name' => 'Review author IP',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'comment_date',
                    'name' => 'Review date',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'comment_date_gmt',
                    'name' => 'Review date (GMT)',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'comment_approved',
                    'name' => 'Review approval status',
                    'type' => DataType::integer(),
                ],
            ]
        );
    }

    public static function WC_Product()
    {
        return DataType::object(
            [
                [
                    'id'   => 'ID',
                    'name' => 'Product ID',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'name',
                    'name' => 'Product name',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'description',
                    'name' => 'Product description',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'short_description',
                    'name' => 'Short description',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'slug',
                    'name' => 'Product slug',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'date_created',
                    'name' => 'Product date',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'date_modified',
                    'name' => 'Product last update date',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'sku',
                    'name' => 'SKU',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'low_stock_amount',
                    'name' => 'Low stock amount',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'backorders',
                    'name' => 'Backorders',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'stock_status',
                    'name' => 'Stock status',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'stock_quantity',
                    'name' => 'Stock quantity',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'total_sales',
                    'name' => 'Total sales',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'price',
                    'name' => 'Price',
                    'type' => DataType::float(),
                ],
                [
                    'id'   => 'regular_price',
                    'name' => 'Regular price',
                    'type' => DataType::float(),
                ],
                [
                    'id'   => 'sale_price',
                    'name' => 'Sale price',
                    'type' => DataType::float(),
                ],
                [
                    'id'   => 'height',
                    'name' => 'Height',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'width',
                    'name' => 'Width',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'length',
                    'name' => 'Length',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'weight',
                    'name' => 'Weight',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'upsell_ids',
                    'name' => 'Upsell ids',
                    'type' => DataType::array(),
                ],
                [
                    'id'   => 'cross_sell_ids',
                    'name' => 'Cross sell ids',
                    'type' => DataType::array(),
                ],
                [
                    'id'   => 'post_parent',
                    'name' => 'Product parent ID',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'post_status',
                    'name' => 'Product status',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'purchase_note',
                    'name' => 'Purchase note',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'reviews_allowed',
                    'name' => 'Reviews allowed',
                    'type' => DataType::boolean(),
                ],
                [
                    'id'   => 'sold_individually',
                    'name' => 'Sold individually',
                    'type' => DataType::boolean(),
                ],
                [
                    'id'   => 'virtual',
                    'name' => 'Virtual',
                    'type' => DataType::boolean(),
                ],
                [
                    'id'   => 'downloadable',
                    'name' => 'Downloadable',
                    'type' => DataType::boolean(),
                ],
                [
                    'id'   => 'review_count',
                    'name' => 'Reviews count',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'average_rating',
                    'name' => 'Average rating',
                    'type' => DataType::float(),
                ],
            ]
        );
    }

    public static function WC_Cart()
    {
        return DataType::object(
            [
                [
                    'id'   => 'cart_contents',
                    'name' => 'Cart contents',
                    'type' => DataType::array(),
                ],
                [
                    'id'   => 'applied_coupons',
                    'name' => 'Applied coupons',
                    'type' => DataType::array(),
                ],
                [
                    'id'   => 'totals',
                    'name' => 'Totals',
                    'type' => DataType::map([
                                                [
                                                    'id'   => 'subtotal',
                                                    'name' => 'Subtotal',
                                                    'type' => DataType::float(),
                                                ],
                                                [
                                                    'id'   => 'subtotal_tax',
                                                    'name' => 'Subtotal tax',
                                                    'type' => DataType::float(),
                                                ],
                                                [
                                                    'id'   => 'total',
                                                    'name' => 'Total',
                                                    'type' => DataType::float(),
                                                ],
                                                [
                                                    'id'   => 'total_tax',
                                                    'name' => 'Total tax',
                                                    'type' => DataType::float(),
                                                ],
                                                [
                                                    'id'   => 'shipping_total',
                                                    'name' => 'Shipping total',
                                                    'type' => DataType::float(),
                                                ],
                                                [
                                                    'id'   => 'shipping_tax',
                                                    'name' => 'Shipping tax',
                                                    'type' => DataType::float(),
                                                ],
                                                [
                                                    'id'   => 'discount_total',
                                                    'name' => 'Discount total',
                                                    'type' => DataType::float(),
                                                ],
                                                [
                                                    'id'   => 'discount_tax',
                                                    'name' => 'Discount tax',
                                                    'type' => DataType::float(),
                                                ],
                                                [
                                                    'id'   => 'cart_contents_total',
                                                    'name' => 'Cart contents total',
                                                    'type' => DataType::float(),
                                                ],
                                                [
                                                    'id'   => 'cart_contents_tax',
                                                    'name' => 'Cart contents tax',
                                                    'type' => DataType::float(),
                                                ],
                                                [
                                                    'id'   => 'fee_total',
                                                    'name' => 'Fee total',
                                                    'type' => DataType::float(),
                                                ],
                                                [
                                                    'id'   => 'fee_tax',
                                                    'name' => 'Fee tax',
                                                    'type' => DataType::float(),
                                                ],
                                            ]),
                ],
            ]
        );
    }

    public static function WC_Coupon()
    {
        return DataType::object(
            [
                [
                    'id'   => 'code',
                    'name' => 'Code',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'amount',
                    'name' => 'Amount',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'date_created',
                    'name' => 'Date created',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'date_modified',
                    'name' => 'Date modified',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'date_expires',
                    'name' => 'Date expires',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'discount_type',
                    'name' => 'Discount type',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'description',
                    'name' => 'Description',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'usage_count',
                    'name' => 'Usage count',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'individual_use',
                    'name' => 'Individual use',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'product_ids',
                    'name' => 'Product ids',
                    'type' => DataType::array(),
                ],
                [
                    'id'   => 'excluded_product_ids',
                    'name' => 'Excluded product ids',
                    'type' => DataType::array(),
                ],
                [
                    'id'   => 'usage_limit',
                    'name' => 'Usage limit',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'usage_limit_per_user',
                    'name' => 'usage_limit_per_user',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'limit_usage_to_x_items',
                    'name' => 'Limit usage to x items',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'free_shipping',
                    'name' => 'Free shipping',
                    'type' => DataType::boolean(),
                ],
                [
                    'id'   => 'product_categories',
                    'name' => 'Product categories',
                    'type' => DataType::array(),
                ],
                [
                    'id'   => 'excluded_product_categories',
                    'name' => 'Excluded product categories',
                    'type' => DataType::array(),
                ],
                [
                    'id'   => 'exclude_sale_items',
                    'name' => 'Exclude sale items',
                    'type' => DataType::array(),
                ],
                [
                    'id'   => 'minimum_amount',
                    'name' => 'Minimum amount',
                    'type' => DataType::float(),
                ],
                [
                    'id'   => 'maximum_amount',
                    'name' => 'Maximum amount',
                    'type' => DataType::float(),
                ],
                [
                    'id'   => 'email_restrictions',
                    'name' => 'Email restrictions',
                    'type' => DataType::array(),
                ],
                [
                    'id'   => 'used_by',
                    'name' => 'Used by',
                    'type' => DataType::array(),
                ],
                [
                    'id'   => 'virtual',
                    'name' => 'virtual',
                    'type' => DataType::boolean(),
                ],
            ]
        );
    }
}
