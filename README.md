Yii2 Swiper Widget
==================
Yii2 Swiper Widget

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist kriss/yii2-swiper-widget "*"
```

or add

```
"kriss/yii2-swiper-widget": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?php
echo \kriss\swiper\SwiperWidget::widget([
    'slides' => [
        Html::img('http://img.zcool.cn/community/01665258173c34a84a0d304fc68fdf.jpg'),
        Html::img('http://img.zcool.cn/community/01665258173c34a84a0d304fc68fdf.jpg'),
        Html::img('http://img.zcool.cn/community/01665258173c34a84a0d304fc68fdf.jpg'),
    ],
    'pagination' => true,
    'navigation' => true,
    'scrollbar' => true,
    'clientOptions' => [
        'speed' => 200,
        'loop' => true,
    ]
]);
```