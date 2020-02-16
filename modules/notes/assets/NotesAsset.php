<?php
namespace evolun\kid\modules\notes\assets;

use yii\web\AssetBundle;

class NotesAsset extends AssetBundle
{
    public $sourcePath = '@vendor/polgarz/evolun-kid/modules/notes/assets/dist';

    public $depends = [
        'app\assets\AppAsset',
    ];

    public $js = [
        'notes.js'
    ];
}
