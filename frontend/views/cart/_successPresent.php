<div class="successOrder__artikul">Артикул: <?=$artikul?></div>
<div class="successOrder__line successOrder__line_big">
    <div class="successOrder__lineLeft successOrder__lineLeft_big"><?=$i?>. <?=$present->name?></div>
    <div class="successOrder__lineMiddle successOrder__lineMiddle_big"></div>
    <div class="successOrder__lineRight">
        <div class="cart__price">
            <div class="cart__presentImage"></div>
            <div class="cart__oldPrice"><?=number_format($present->price, 0, '', ' ')?> <span class="rubl">₽</span></div>
            <div class="cart__presentText">подарок от KSG</div>
        </div>
    </div>
</div>

<?php $i++; ?>