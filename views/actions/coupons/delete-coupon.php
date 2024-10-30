<div class="row gy-3">
    <div class="col-12">
        <label class="form-check-label form-label" for="coupon">
            <?php _e('Coupon', 'mantiq'); ?>
        </label>

        <reference-input-helper>
            <input id="coupon"
                   type="text"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Coupon code...', 'mantiq'); ?>"
                   v-model="arguments.coupon" v-variable-finder-trigger>
        </reference-input-helper>
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
