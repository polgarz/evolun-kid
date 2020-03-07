<?php

namespace evolun\kid;

use yii;

/**
 * Gyerekek modul
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'evolun\kid\controllers';

    /**
     * A gyerekek modelje
     * @var string
     */
    public $kidModelClass = 'evolun\kid\models\Kid';

    /**
     * A gyerekek kereso modelje
     * @var string
     */
    public $kidSearchModelClass = 'evolun\kid\models\KidSearch';

    /**
     * A gyerek adatlapjának bal oldalán megjelenő dobozok (a fő doboz alatt)
     * @var array
     */
    public $widgets = [
        \evolun\kid\widgets\ResponsibleUsers::class,
        \evolun\kid\widgets\OtherData::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (Yii::$app->user->identity && !Yii::$app->user->identity instanceof \evolun\user\models\User) {
            throw new \yii\base\InvalidConfigException('You have to install \'evolun-user\' to use this module');
        }

        $this->registerTranslations();
    }

    public function registerTranslations()
    {
        if (!isset(Yii::$app->get('i18n')->translations['kid'])) {
            Yii::$app->get('i18n')->translations['kid*'] = [
                'class' => \yii\i18n\PhpMessageSource::className(),
                'basePath' => __DIR__ . '/messages',
                'sourceLanguage' => 'en-US',
                'fileMap' => [
                    'kid' => 'kid.php',
                ]
            ];
        }
    }
}
