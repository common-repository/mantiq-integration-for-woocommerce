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

    <div class="col-12" :items="argument('items', [])">
        <repeatable :model="{id: '', quantity: 1}" v-model="arguments.items" v-slot="{items, add, remove, form}">
            <table class="table table-borderless m-0">
                <thead>
                <tr class="bg-primary-light">
                    <th class="fw-light ">Product ID/Slug</th>
                    <th class="fw-light w-25">Quantity</th>
                    <th class="fw-light"></th>
                </tr>
                </thead>
                <tbody>
                <tr class="align-middle" v-for="(item, itemId) in items">
                    <td class="small ps-1" v-text="item.id"></td>
                    <td class="small ps-1 w-25" v-text="item.quantity"></td>
                    <td class="text-center pe-0">
                        <button class="btn btn-inline text-danger ms-auto" @click="remove(item)">
                            <span class="material-icons">delete</span>
                        </button>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td class="rounded px-0" colspan="3">
                        <div class="input-group input-group-sm flex-nowrap">
                            <reference-input-helper class="flex-fill">
                                <input type="text" class="form-control rounded-0"
                                       ref="valueInput"
                                       placeholder="Product ID, slug..."
                                       v-model="form.id"
                                       @keypress.enter="add"
                                       v-variable-finder-trigger>
                            </reference-input-helper>

                            <reference-input-helper class="flex-fill w-25">
                                <input type="text" class="form-control rounded-0"
                                       ref="quantityInput"
                                       placeholder="Quantity..."
                                       v-model="form.quantity"
                                       @keypress.enter="add"
                                       v-variable-finder-trigger>
                            </reference-input-helper>

                            <button class="btn btn-sm btn-primary" @click="add">
                                <span class="material-icons">add</span>
                            </button>
                        </div>
                    </td>
                </tr>
                </tfoot>
            </table>
        </repeatable>
    </div>

    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="recalculate-totals"
                   id="recalculate-totals" v-model="arguments.recalculate_totals"
                   value="1">
            <label class="form-check-label" for="recalculate-totals">
                Recalculate totals
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="only-if-not-existing"
                   id="only-if-not-existing" v-model="arguments.only_non_existing"
                   value="1">
            <label class="form-check-label" for="only-if-not-existing">
                Add products only if they not exist before
            </label>
        </div>

        <div class="form-check" v-if="arguments.only_non_existing">
            <input class="form-check-input" type="checkbox" name="override-quantities"
                   id="override-quantities" v-model="arguments.override_quantities"
                   value="1">
            <label class="form-check-label" for="override-quantities">
                Override quantities
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
