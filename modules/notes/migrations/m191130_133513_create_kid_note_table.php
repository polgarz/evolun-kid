<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kid_note}}`.
 */
class m191130_133513_create_kid_note_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kid_note}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'note' => $this->text()->notNull(),
            'kid_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_kid_note_created_by_user_id', '{{%kid_note}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_kid_note_updated_by_user_id', '{{%kid_note}}', 'updated_by', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_kid_note_kid_id', '{{%kid_note}}', 'kid_id', '{{%kid}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%kid_note}}');
    }
}
