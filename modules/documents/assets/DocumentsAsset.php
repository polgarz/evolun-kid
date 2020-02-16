<?php
namespace evolun\kid\modules\documents\assets;

use yii\web\AssetBundle;

class DocumentsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/polgarz/evolun-kid/modules/documents/assets/dist';

    public $depends = [
        'app\assets\AppAsset',
    ];

    public $js = [
        'documents.js'
    ];
}
