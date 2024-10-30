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
        <label class="form-check-label form-label" for="amount">
            <?php _e('Amount', 'mantiq'); ?>
        </label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="amount"
                   id="amount-full"
                   :checked="arguments.amount === '100%'"
                   @click="arguments.amount = '100%'">
            <label class="form-check-label" for="amount-full">
                <?php _e('Full amount', 'mantiq'); ?>
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="amount"
                   id="amount-partial"
                   @click="arguments.amount = arguments.amount === '100%' ? '' : arguments.amount"
                   :checked="arguments.amount !== '100%'">
            <label class="form-check-label" for="amount-partial">
                <?php _e('Partial', 'mantiq'); ?>
            </label>
        </div>
        <input type="text" class="form-control mt-2"
               v-if="arguments.amount !== '100%'"
               v-model="arguments.amount"
               placeholder="<?php esc_attr_e('Fixed amount or percentage...', 'mantiq'); ?>">
    </div>

    <div class="col-12">
        <label class="form-check-label form-label" for="refund-reason">
            <?php _e('Reason', 'mantiq'); ?>
        </label>

        <reference-input-helper>
                    <textarea id="refund-reason"
                              class="form-control form-control-sm"
                              placeholder="<?php _e('Reason...', 'mantiq'); ?>"
                              rows="2"
                              v-model="arguments.reason" v-variable-finder-trigger></textarea>
        </reference-input-helper>
    </div>

    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="restock"
                   id="restock" v-model="arguments.restock"
                   value="1">
            <label class="form-check-label" for="restock">
                <?php _e('Restock refunded items', 'mantiq'); ?>
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
                   href="https://woocommerce.github.io/code-reference/classes/WC-Order.html#method_update_status">
                    <?php _e('Docs', 'mantiq'); ?>
                    <span class="material-icons">open_in_new</span></a>
            </summary>

            <json-editor id="post-arguments" v-model="arguments.customArguments"></json-editor>
        </details>
    </div>
</div>
