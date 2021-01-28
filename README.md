Yii2 Swiper Widget
==================
Yii2 Swiper Widget

- 配置方便

- 同一个界面可以存在多个轮播，且不冲突

- [swiper 4.0 +](https://swiperjs.com/swiper-api)

安装
------------

```
composer require kriss/yii2-swiper-widget
```

```
"kriss/yii2-swiper-widget": "^1.0"
```

简单使用
-----
显示轮播

```php
<?php
use yii\helpers\Html;

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
        'on' => [
            'init' => new \yii\web\JsExpression('function() {}')
        ],
    ]
]);
```

高级使用
-----
自定义操控，自定义js

```php
<?php
use yii\helpers\Html;

// swiper js 初始化后赋值给的变量名
$swiperEl = 'swiper';
echo \kriss\swiper\SwiperWidget::widget([
    'slides' => [
        Html::img('http://img.zcool.cn/community/01665258173c34a84a0d304fc68fdf.jpg'),
        Html::img('http://img.zcool.cn/community/01665258173c34a84a0d304fc68fdf.jpg'),
        Html::img('http://img.zcool.cn/community/01665258173c34a84a0d304fc68fdf.jpg'),
    ],
    'pagination' => true,
    'navigation' => true,
    'scrollbar' => true,
    'swiperEl' => $swiperEl, // 在此处传入
    'clientOptions' => [
        'speed' => 200,
        'loop' => true,
    ]
]);
// 下一个触发按钮
echo Html::button('next', ['id' => 'to-next']);

$js = <<<JS
 // 点击之后触发下一个，更多js操作参考官方
 $('#to-next').click(function() {
   {$swiperEl}.slideNext();
 });
JS;
$this->registerJs($js);
```

单页面宣传海报，带动画
-----
使用 AnimatedSwiperSlideWidget

```php
echo SwiperWidget::widget([
    'slides' => [
        AnimatedSwiperSlideWidget::widget([
            'imageBaseUrl' => '@public/images/post',
            'bgUrl' => 'bg.jpg',
            'itemSizeUnit' => 'rem',
            'items' => [
                ['bonus_01.png', [6.4, .87, 0, .3], ['zoomIn', 1.5, 0]],
                ['bonus_02.jpg', [6.4, .55, 1.5, 0], ['fadeIn', 0.5, 1.5]],
                ['001.png', [6.4, 3.75, 2.8, 0], ['rotateInDownLeft', 0.5, 2]],
                ['002.png', [6.4, 3.75, 2.8, 0], ['bounceInDown', 1.5, 2.5]],
                ['003.png', [6.4, 2.25, 6.4, 0], ['fadeInUp', 0.5, 4]],
            ],
        ]),
        AnimatedSwiperSlideWidget::widget([
            'imageBaseUrl' => '@public/images/post',
            'bgUrl' => 'bg.jpg',
            'itemSizeUnit' => 'rem',
            'items' => [
                ['bonus_01.png', [6.4, .87, 0, .3], ['zoomIn', 1.5, 0]],
                ['bonus_02.jpg', [6.4, .55, 1.5, 0], ['fadeIn', 0.5, 1.5]],
                ['001.png', [6.4, 3.75, 2.8, 0], ['rotateInDownLeft', 0.5, 2]],
                ['002.png', [6.4, 3.75, 2.8, 0], ['bounceInDown', 1.5, 2.5]],
                ['003.png', [6.4, 2.25, 6.4, 0], ['fadeInUp', 0.5, 4]],
            ],
        ]),
    ],
    'pagination' => false,
    'navigation' => false,
    'clientOptions' => [
        'direction' => 'vertical',
        'on' => [
            'init' => new JsExpression('function() {swiperAnimateCache(this);swiperAnimate(this);}'),
            'slideChangeTransitionEnd' => new JsExpression('function() {swiperAnimate(this);}'),
        ],
    ],
]);
```
