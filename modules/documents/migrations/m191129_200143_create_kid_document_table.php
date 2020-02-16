<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kid_document}}`.
 */
class m191129_200143_create_kid_document_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kid_document}}', [
            'id' => $this->primaryKey(),
            'kid_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'file' => $this->string()->notNull(),
            'created_at' => $this->datetime(),
            'created_by' => $this->integer(),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_kid_document_created_by', '{{%kid_document}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_kid_document_kid_id', '{{%kid_document}}', 'kid_id', '{{%kid}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%kid_document}}');
    }
}
