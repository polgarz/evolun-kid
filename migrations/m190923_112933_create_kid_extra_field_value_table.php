<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kid_extra_field_value}}`.
 */
class m190923_112933_create_kid_extra_field_value_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kid_extra_field_value}}', [
            'id' => $this->primaryKey(),
            'kid_extra_field_id' => $this->integer(),
            'kid_id' => $this->integer(),
            'value' => $this->text(),
            ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_kid_extra_field_kid_extra_field_id', '{{%kid_extra_field_value}}', 'kid_extra_field_id', '{{%kid_extra_field}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_kid_extra_field_kid_id', '{{%kid_extra_field_value}}', 'kid_id', '{{%kid}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%kid_extra_field_value}}');
    }
}
