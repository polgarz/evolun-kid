<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kid_extra_field}}`.
 */
class m190923_112917_create_kid_extra_field_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kid_extra_field}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'type' => $this->string()->defaultValue('textarea'),
            ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%kid_extra_field}}');
    }
}
