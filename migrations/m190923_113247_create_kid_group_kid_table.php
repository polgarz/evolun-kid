<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kid_group_kid}}`.
 */
class m190923_113247_create_kid_group_kid_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kid_group_kid}}', [
            'id' => $this->primaryKey(),
            'kid_group_id' => $this->integer(),
            'kid_id' => $this->integer(),
            ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_kid_group_kid_kid_group_id', '{{%kid_group_kid}}', 'kid_group_id', '{{%kid_group}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_kid_group_kid_id', '{{%kid_group_kid}}', 'kid_id', '{{%kid}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%kid_group_kid}}');
    }
}
