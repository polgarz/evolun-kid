<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kid_image}}`.
 */
class m191108_125912_create_kid_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kid_image}}', [
            'id' => $this->primaryKey(),
            'kid_id' => $this->integer()->notNull(),
            'image' => $this->string()->notNull(),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('fk_kid_image_created_by', '{{%kid_image}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_kid_image_updated_by', '{{%kid_image}}', 'updated_by', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_kid_image_kid_id', '{{%kid_image}}', 'kid_id', '{{%kid}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%kid_image}}');
    }
}
