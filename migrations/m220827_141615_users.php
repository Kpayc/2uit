<?php

use yii\db\Migration;

/**
 * Class m220827_141615_users
 */
class m220827_141615_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('app__users', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'name' => $this->string(255),
            'email' => $this->string(255),
            'phone' => $this->string(12)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('app__users');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220827_141615_users cannot be reverted.\n";

        return false;
    }
    */
}
