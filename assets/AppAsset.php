<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'font-awesome/css/font-awesome.css',
        'css/animate.css',
        'css/style.css?v=2.2.0',
    ];
    public $js = [
        'js/bootstrap.min.js?v=3.4.0',
        'js/plugins/metisMenu/jquery.metisMenu.js',
        'js/plugins/slimscroll/jquery.slimscroll.min.js',
        'js/hplus.js?v=2.2.0',
        'js/plugins/pace/pace.min.js',
        'js/jquery-session.js',
        'app/common.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    /**
     * @desc   定义加载CSS 样式
     * @author RZLIAO
     * AppAsset::addCss($this,'@web/css/xxx.css')
     * @date   2016-1-14
     */
    public static function addCss($view, $cssFile) {
        $view->registerCssFile($cssFile, [AppAsset::className(), 'depends' => 'app\assets\AppAsset']);
    }

    /**
     * @desc   定义加载 JS 样式
     * @author RZLIAO
     * AppAsset::addCss($this,'@web/js/xxx.js')
     * @date   2016-1-14
     */
    public static function addJs($view, $jsFile) {
        $view->registerJsFile($jsFile, [AppAsset::className(), 'depends' => 'app\assets\AppAsset']);
    }
}
