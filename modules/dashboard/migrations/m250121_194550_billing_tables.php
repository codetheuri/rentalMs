<?php

use yii\db\Migration;

/**
 * Class m250121_194550_billing_tables
 */
class m250121_194550_billing_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("payments",[
            "id"=> $this->primaryKey(),
            "transaction_id"=> $this->string(255)->notNull(),
            "amount"=> $this->double()->notNull(),
            "is_deleted"=> $this->tinyInteger(1)->defaultValue(0),
            "created_at"=> $this->dateTime()->notNull(),
            "updated_at"=> $this->dateTime()->notNull(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250121_194550_billing_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250121_194550_billing_tables cannot be reverted.\n";

        return false;
    }
    */
}
