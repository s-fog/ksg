<?php
return [
    'cities' => [
        'Москва' => [
            'phone' => '+7 (495) 015-70-17',
            'phoneLink' => '+74950157017',
            'email' => Yii::$app->params['adminEmail'],
            'address' => '109004, г. Москва, ул. Земляной вал, д. 64, стр. 2',
            'addressBr' => '109004, г. Москва,<br> ул. Земляной вал, д. 64, стр. 2',
            'addressBrSchema' => '<span itemprop="postalCode">109004</span>, г. <span itemprop="addressLocality">Москва</span>,<br> ул. <span itemprop="streetAddress">Земляной вал, д. 64, стр. 2</span>',
        ],
        'Others' => [
            'phone' => '8 (800) 350 06 08',
            'phoneLink' => '+78003500608',
            'email' => Yii::$app->params['adminEmail'],
            'address' => '109004, г. Москва, ул. Земляной вал, д. 64, стр. 2',
            'addressBr' => '109004, г. Москва,<br> ул. Земляной вал, д. 64, стр. 2',
        ],
    ]
];
