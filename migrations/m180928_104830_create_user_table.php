<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180928_104830_create_user_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user}}', [
            'id' => $this->string(36)->notNull()->unique(),
            'username' => $this->string(36)->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(32)->notNull(),
            'password_hash' => $this->string(255)->notNull(),
            'phone' => $this->string(32),
            'name' => $this->string(64),
        ], $tableOptions);

        $this->addPrimaryKey('pk_user', '{{%user}}', 'id');
    }
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
