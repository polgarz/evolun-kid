<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kid}}`.
 */
class m190923_103939_create_kid_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kid}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'family' => $this->string(),
            'birth_date' => $this->date(),
            'address' => $this->string(),
            'phone' => $this->string(),
            'parent_contact' => $this->string(),
            'school_name' => $this->string(),
            'class_number' => $this->string(),
            'educator_name' => $this->string(),
            'educator_phone' => $this->string(),
            'educator_office_hours' => $this->text(),
            'inactive' => $this->boolean(),
            'image' => $this->string(),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_kid_created_by', '{{%kid}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_kid_updated_by', '{{%kid}}', 'updated_by', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%kid}}');
    }
}
