<?php

use yii\db\Migration;

/**
 * Handles the creation of table `room`.
 */
class m181001_064314_create_room_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%room}}', [
            'id' => $this->string(36)->notNull()->unique(),
            'name' => $this->string(64)->notNull()->unique(),
            'description' => $this->text()->notNull(),
            'image' => $this->string(64),
        ], $tableOptions);

        $this->addPrimaryKey('pk_room', '{{%room}}', 'id');
    }
    public function safeDown()
    {
        $this->dropTable('{{%room}}');
    }
}
