<?php

use yii\db\Migration;

/**
 * Class m191019_174052_rbac_init
 */
class m191019_174052_rbac_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $admin = $auth->getRole('admin');

        $manageKids = $auth->createPermission('manageKids');
        $manageKids->description = 'Add, edit, or delete kids';
        $auth->add($manageKids);

        $showKids = $auth->createPermission('showKids');
        $showKids->description = 'Show kids list, and data';
        $auth->add($showKids);

        $auth->addChild($admin, $showKids);
        $auth->addChild($admin, $manageKids);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $manageKids = $auth->getPermission('manageKids');
        $auth->remove($manageKids);
        $showKids = $auth->getPermission('showKids');
        $auth->remove($showKids);
    }
}
