<div class="product__selects js-product-jquery-ui-selects">
    <?php foreach($model->selects() as $param_id => $select) {?>
        <div class="product__select">
            <span class="product__selectName"><?=$select['name']?></span>
            <select name="<?=$select['name_en']?>"
                    class="js-product-jquery-ui-select
                    <?=$param_id === $model->main_param ? ' js-product-main-param' : ' js-product-additional-param'?>
                    select-<?=$select['name_en']?>-jquery-ui">
                <?php foreach($select['items'] as $item) { ?>
                    <option value="<?=$item['value']?>"
                        <?=$item['disabled'] === true ? 'disabled' : ''?>
                        <?=$item['selected'] === true ? 'selected' : ''?>><?=$item['value']?></option>
                <?php } ?>
            </select>
        </div>
    <?php } ?>
</div>