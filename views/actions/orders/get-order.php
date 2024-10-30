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
</div>
