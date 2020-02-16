<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kid_responsible_user}}`.
 */
class m190923_112644_create_kid_responsible_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kid_responsible_user}}', [
            'id' => $this->primaryKey(),
            'responsible_id' => $this->integer(),
            'user_id' => $this->integer(),
            'kid_id' => $this->integer(),
            ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_kid_responsible_responsible_id', '{{%kid_responsible_user}}', 'responsible_id', '{{%kid_responsible}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_kid_responsible_user_id', '{{%kid_responsible_user}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_kid_responsible_kid_id', '{{%kid_responsible_user}}', 'kid_id', '{{%kid}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%kid_responsible_user}}');
    }
}
