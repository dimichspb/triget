<?php

use yii\db\Migration;

/**
 * Handles the creation of table `booking`.
 */
class m181003_060033_create_booking_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%booking}}', [
            'id' => $this->string(36)->notNull()->unique(),
            'room_id' => $this->string(36)->notNull(),
            'user_id' => $this->string(36)->notNull(),
            'start_date' => $this->date()->notNull(),
            'end_date' => $this->date()->notNull(),
            'confirmed' => $this->boolean()->notNull()->defaultValue(false),
        ], $tableOptions);

        $this->addPrimaryKey('pk_booking', '{{%booking}}', 'id');
        $this->addForeignKey('fk_booking_room', '{{%booking}}', 'room_id', '{{%room}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_booking_user', '{{%booking}}', 'user_id', '{{%user}}', 'id', 'RESTRICT','CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%booking}}');
    }
}
