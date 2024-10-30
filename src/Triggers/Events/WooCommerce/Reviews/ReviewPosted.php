<?php

namespace Mantiq\Triggers\Events\WooCommerce\Reviews;

use Mantiq\Models\DataType;
use Mantiq\Models\OutputDefinition;
use Mantiq\Models\TriggerEvent;
use Mantiq\Support\WooCommerceDataTypes;
use Mantiq\Support\WooCommerceDataWrappers;

add_action('comment_post', static function ($commentId) {
    $comment = get_comment($commentId);
    if ($comment->comment_type === 'review') {
        do_action('woocommerce_review_posted', $commentId, $comment);
    }
});

class ReviewPosted extends TriggerEvent
{
    public function getId()
    {
        return 'woocommerce_review_posted';
    }

    public function getName()
    {
        return __('Review posted', 'mantiq');
    }

    public function getGroup()
    {
        return __('Reviews - WooCommerce', 'mantiq');
    }

    public function getOutputs()
    {
        return [
            new OutputDefinition(
                [
                    'id'   => 'review_id',
                    'name' => __('Review ID', 'mantiq'),
                    'type' => DataType::integer(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'review_permalink',
                    'name' => __('Review permalink', 'mantiq'),
                    'type' => DataType::string(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'review',
                    'name' => __('Review object', 'mantiq'),
                    'type' => WooCommerceDataTypes::WC_Review(),
                ]
            ),
            new OutputDefinition(
                [
                    'id'   => 'product',
                    'name' => __('Product object', 'mantiq'),
                    'type' => WooCommerceDataTypes::WC_Product(),
                ]
            ),
        ];
    }

    public function getNamedArgumentsFromRawEvent($eventArgs)
    {
        return [
            'review_id'        => $eventArgs[0],
            'review_permalink' => get_comment_link($eventArgs[0]),
            'review'           => WooCommerceDataWrappers::review($eventArgs[1]),
            'product'          => WooCommerceDataWrappers::product(wc_get_product($eventArgs[1]->comment_post_ID)),
        ];
    }
}
