<?php

namespace kriss\swiper;

use yii\base\InvalidValueException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

class SwiperWidget extends Widget
{
    /**
     * 层的属性
     * @var array
     */
    public $wrapOptions = [];
    /**
     * 图片是否显示最大宽度
     * @var bool
     */
    public $slideImageFullWidth = true;
    /**
     * swiper js params
     * [
     *     'speed' => 400,
     *     'on' => [
     *         'init' => new JsExpression('function() {}')
     *     ],
     * ]
     * @link https://swiperjs.com/swiper-api
     * @var array
     */
    public $clientOptions = [];
    /**
     * 轮播内容
     * 例如：
     * [
     *      Html::img('http://img.zcool.cn/community/01665258173c34a84a0d304fc68fdf.jpg'),
     *      Html::img('http://img.zcool.cn/community/01665258173c34a84a0d304fc68fdf.jpg'),
     *      Html::img('http://img.zcool.cn/community/01665258173c34a84a0d304fc68fdf.jpg'),
     * ]
     * 可以使用 AnimatedSwiperSlideWidget 作为值
     * @var array
     */
    public $slides = [];
    /**
     * 分页器
     * false：不显示
     * true：使用默认值显示
     * array：配置参数 @link https://swiperjs.com/swiper-api#pagination
     * @var bool|array
     */
    public $pagination = false;
    /**
     * 左右导航
     * false：不显示
     * true：使用默认值显示
     * array：配置参数 @link https://swiperjs.com/swiper-api#navigation
     * @var bool|array
     */
    public $navigation = false;
    /**
     * 底部 scroll 导航
     * false：不显示
     * true：使用默认值显示
     * array：配置参数 @link https://swiperjs.com/swiper-api#scrollbar
     * @var bool|array
     */
    public $scrollbar = false;
    /**
     * @var string
     */
    public $swiperEl;


    private $_wrapContainerId;
    private $_paginationId;
    private $_navigationNextId;
    private $_navigationPrevId;
    private $_scrollbarId;

    public function init()
    {
        if (!$this->slides) {
            throw new InvalidValueException('slides 必须');
        }

        $this->_wrapContainerId = $this->id . '-swiper-container';

        if ($this->pagination) {
            if (!is_array($this->pagination)) {
                $this->pagination = [];
            }
            $this->_paginationId = $this->id . '-swiper-pagination';
            $this->pagination['el'] = '#' . $this->_paginationId;
            $this->clientOptions['pagination'] = $this->pagination;
        }

        if ($this->navigation) {
            if (!is_array($this->navigation)) {
                $this->navigation = [];
            }
            $this->_navigationNextId = $this->id . '-swiper-button-next';
            $this->_navigationPrevId = $this->id . '-swiper-button-prev';
            $this->navigation['nextEl'] = '#' . $this->_navigationNextId;
            $this->navigation['prevEl'] = '#' . $this->_navigationPrevId;
            $this->clientOptions['navigation'] = $this->navigation;
        }

        if ($this->scrollbar) {
            if (!is_array($this->scrollbar)) {
                $this->scrollbar = [];
            }
            $this->_scrollbarId = $this->id . '-swiper-scrollbar';
            $this->scrollbar['el'] = '#' . $this->_scrollbarId;
            $this->clientOptions['scrollbar'] = $this->scrollbar;
        }

        if (!$this->swiperEl) {
            $this->swiperEl = $this->id . 'Swiper';
        }
    }

    public function run()
    {
        $containerContent = [];

        $slideContent = [];
        foreach ($this->slides as $index => $slide) {
            $slideContent[] = Html::tag('div', $slide, ['class' => 'swiper-slide slide-' . $index]);
        }
        $containerContent[] = Html::tag('div', implode("\n", $slideContent), ['class' => 'swiper-wrapper']);

        if ($this->pagination) {
            $containerContent[] = Html::tag('div', '', ['id' => $this->_paginationId, 'class' => 'swiper-pagination']);
        }

        if ($this->navigation) {
            $containerContent[] = Html::tag('div', '', ['id' => $this->_navigationPrevId, 'class' => 'swiper-button-prev']);
            $containerContent[] = Html::tag('div', '', ['id' => $this->_navigationNextId, 'class' => 'swiper-button-next']);
        }

        if ($this->scrollbar) {
            $containerContent[] = Html::tag('div', '', ['id' => $this->_scrollbarId, 'class' => 'swiper-scrollbar']);
        }

        Html::addCssClass($this->wrapOptions, 'swiper-container');
        $html = Html::tag('div', implode("\n", $containerContent), array_merge($this->wrapOptions, [
            'id' => $this->_wrapContainerId,
        ]));

        $this->registerAssets();

        return $html;
    }

    /**
     * 注册资源
     */
    protected function registerAssets()
    {
        SwiperAssest::register($this->view);

        if ($this->slideImageFullWidth) {
            $css = <<<CSS
        #{$this->_wrapContainerId} img{
            width: 100%;
        }
CSS;
            $this->view->registerCss($css);
        }

        $clientOptions = Json::encode($this->clientOptions);
        $js = new JsExpression("var {$this->swiperEl} = new Swiper('#{$this->_wrapContainerId}', {$clientOptions})");
        $this->view->registerJs($js);
    }
}
