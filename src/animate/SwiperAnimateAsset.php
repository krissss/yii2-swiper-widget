<?php

namespace kriss\swiper\animate;

use kriss\swiper\SwiperAssest;
use yii\web\AssetBundle;

/**
 * @see https://www.swiper.com.cn/usage/animate/index.html
 */
class SwiperAnimateAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/assets/1.0.3';

    public $css = [
        'animate.min.css'
    ];

    public $js = [
        'swiper.animate1.0.3.min.js'
    ];

    public $depends = [
        SwiperAssest::class,
    ];
}