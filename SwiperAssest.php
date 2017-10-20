<?php

namespace kriss\swiper;

use yii\web\AssetBundle;

class SwiperAssest extends AssetBundle
{
    public $sourcePath = '@npm/swiper/dist';

    public $css = [
        'css/swiper.min.css'
    ];

    public $js = [
        'js/swiper.min.js'
    ];
}