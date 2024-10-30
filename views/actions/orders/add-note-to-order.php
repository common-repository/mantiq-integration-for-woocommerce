<div class="row gy-3">
    <div class="col-12">
        <label for="order-id" class="form-label"><?php _e('Order ID', 'mantiq'); ?></label>

        <reference-input-helper :single="true">
            <input type="text"
                   id="order-id"
                   class="form-control form-control-sm"
                   placeholder="<?php _e('Order ID...', 'mantiq'); ?>"
                   v-model="arguments.id"
                   v-variable-finder-trigger>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <label class="form-check-label form-label" for="order-note">
            <?php _e('Note', 'mantiq'); ?>
        </label>

        <reference-input-helper>
                    <textarea id="order-note"
                              class="form-control form-control-sm"
                              placeholder="<?php _e('Order note...', 'mantiq'); ?>"
                              rows="4"
                              v-model="arguments.note" v-variable-finder-trigger></textarea>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is-customer-note"
                   id="is-customer-note" v-model="arguments.is_customer_note"
                   value="1">
            <label class="form-check-label" for="is-customer-note">
                Send note to customer
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
                   href="https://woocommerce.github.io/code-reference/classes/WC-Order.html#add_order_note">
                    <?php _e('Docs', 'mantiq'); ?>
                    <span class="material-icons">open_in_new</span></a>
            </summary>

            <json-editor id="post-arguments" v-model="arguments.customArguments"></json-editor>
        </details>
    </div>
</div>
