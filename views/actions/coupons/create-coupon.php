<div class="row gy-3">
    <div class="col-12">
        <label for="coupon-prefix" class="form-label"><?php _e('Prefix', 'mantiq'); ?></label>

        <reference-input-helper>
            <input type="text"
                   id="coupon-prefix"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Coupon prefix...', 'mantiq'); ?>"
                   v-model="arguments.prefix"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <label for="discount-type" class="form-label"><?php _e('Discount type', 'mantiq'); ?></label>
        <?php foreach (
            [
                'percent'    => __('Percentage discount'),
                'fixed_cart' => __('Fixed cart discount'),
            ] as $discountTypeId => $discountTypeLabel
        ): ?>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="discount-type"
                       id="discount-type-<?php echo esc_attr($discountTypeId); ?>" v-model="arguments.discount_type"
                       value="<?php echo esc_attr($discountTypeId); ?>">
                <label class="form-check-label" for="discount-type-<?php echo esc_attr($discountTypeId); ?>">
                    <?php echo esc_html($discountTypeLabel); ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="col-12">
        <label for="coupon-amount" class="form-label"><?php _e('Coupon amount', 'mantiq'); ?></label>

        <input type="text"
               id="coupon-amount"
               class="form-control form-control-sm"
               placeholder="<?php _e('Amount...', 'mantiq'); ?>"
               v-model="arguments.amount">
    </div>

    <div class="col-12">
        <label for="expiry-date" class="form-label"><?php _e('Expiration', 'mantiq'); ?></label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="expiry-date"
                   id="expiry-date-never" v-model="arguments.date_expires"
                   value="">
            <label class="form-check-label" for="expiry-date-never">
                <?php _e('Never', 'mantiq'); ?>
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="expiry-date"
                   id="expiry-date-interval" v-model="arguments.date_expires" value="days">
            <label class="form-check-label" for="expiry-date-interval">
                <?php _e('After a specific number of days', 'mantiq'); ?>
            </label>
            <input type="number"
                   min="1"
                   step="1"
                   id="expiry-days"
                   class="form-control form-control-sm mt-2"
                   placeholder="<?php _e('Number of days...', 'mantiq'); ?>"
                   v-model="arguments.date_expires_interval"
                   v-if="arguments.date_expires === 'days'">
        </div>
    </div>

    <div class="col-12">
        <label for="usage-limit" class="form-label"><?php _e('Usage limit', 'mantiq'); ?></label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="usage-limit"
                   id="usage-limit-never" v-model="arguments.usage_limit"
                   value="0">
            <label class="form-check-label" for="usage-limit-never">
                <?php _e('Unlimited', 'mantiq'); ?>
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="usage-limit"
                   id="usage-limit-once" v-model="arguments.usage_limit" value="1">
            <label class="form-check-label" for="usage-limit-once">
                <?php _e('Once', 'mantiq'); ?>
            </label>
        </div>
    </div>

    <div class="col-12">
        <label for="free-shipping" class="form-label"><?php _e('Shipping', 'mantiq'); ?></label>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="free-shipping"
                   id="free-shipping" v-model="arguments.free_shipping"
                   value="1">
            <label class="form-check-label" for="free-shipping">
                Allow free shipping
                <br>
                <small class="text-muted">A free <a
                            href="<?php echo esc_attr(admin_url('admin.php?page=wc-settings&tab=shipping')); ?>">shipping
                        method</a> must be enabled.</small>
            </label>
        </div>
    </div>

    <div class="col-12 d-flex align-items-center pt-3">
        <small class="text-uppercase text-primary"><?php _e('Advanced users zone', 'mantiq'); ?></small>
        <div class="border-bottom border-primary flex-fill ms-3"></div>
    </div>

    <div class="col-12">
        <details :open="arguments.customArguments ? true : undefined">
            <summary class="d-flex align-items-center form-label">
                <span><?php _e('Extra arguments', 'mantiq'); ?></span>
                <span class="badge bg-primary rounded-pill ms-2 fw-normal">JSON</span>
                <a class="ms-auto text-decoration-none small" target="_blank"
                   href="https://woocommerce.github.io/code-reference/files/woocommerce-includes-class-wc-coupon.html#source-view.28"><?php _e(
                        'Docs',
                        'mantiq'
                    ); ?> <span
                            class="material-icons">open_in_new</span></a>
            </summary>

            <json-editor id="post-arguments" v-model="arguments.customArguments"></json-editor>
        </details>
    </div>
</div>
