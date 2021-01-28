<?php

namespace kriss\swiper\animate;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class AnimatedSwiperSlideWidget extends Widget
{
    /**
     * 图片的基础地址
     * @var string
     */
    public $imageBaseUrl;
    /**
     * 背景url
     * @var string
     */
    public $bgUrl;
    /**
     * 多个图片地址配置
     * [
     *     ['imageSrc', ['width', 'height', 'top', 'left'], ['animate', 'duration', 'delay']],
     *     ['a.png', [100, 200, 0, 50], ['bounceIn', 0.5, 1.5]],
     * ]
     * @var array
     */
    public $items = [];
    /**
     * @var string
     */
    public $itemSizeUnit = 'px';

    public function run()
    {
        $this->registerAssets();

        $tags = [];
        foreach ($this->items as $item) {
            list($imageSrc, $box, $animate) = $item;
            list($width, $height, $top, $left) = $box;
            list($animate, $duration, $delay) = $animate;
            $tags[] = Html::img($this->getImageUrl($imageSrc), [
                'style' => "width: {$this->getSize($width)}; height: {$this->getSize($height)}; top: {$this->getSize($top)}; left: {$this->getSize($left)};",
                'class' => 'ani',
                'swiper-animate-effect' => $animate,
                'swiper-animate-duration' => $duration . 's',
                'swiper-animate-delay' => $delay . 's',
            ]);
        }
        return Html::tag('div', implode("\n", $tags), [
            'class' => 'slide-item-box',
            'style' => "background: url('{$this->getImageUrl($this->bgUrl)}')",
        ]);
    }

    protected function registerAssets()
    {
        SwiperAnimateAsset::register($this->view);

        $css = <<<CSS
.swiper-container {
  width: 100%;
  height: 100%;
  position: relative;
}

.swiper-slide,
.slide-item-box {
  width:100%;
  height:100%;
  background-size:100% 100%;
}

.swiper-slide .ani {
  position: absolute;
}
CSS;
        $this->view->registerCss($css);
    }

    /**
     * @param $src
     * @return string
     */
    protected function getImageUrl($src)
    {
        return Yii::getAlias(rtrim($this->imageBaseUrl, '/') . '/' . ltrim($src, '/'));
    }

    protected function getSize($size)
    {
        if (is_numeric($size)) {
            return $size . $this->itemSizeUnit;
        }
        return $size;
    }
}