<?php
namespace evolun\kid\modules\gallery\assets;

use yii\web\AssetBundle;

class KidGalleryAsset extends AssetBundle
{
    public $sourcePath = '@vendor/polgarz/evolun-kid/modules/gallery/assets/dist';

    public $depends = [
        'app\assets\AppAsset',
    ];

    public $js = [
        'gallery.js'
    ];
}
