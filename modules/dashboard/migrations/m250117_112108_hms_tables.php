<?php

use yii\db\Migration;

/**
 * Class m250117_112108_hms_tables
 */
class m250117_112108_hms_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      
        $this->createTable('status', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'is_deleted' => $this->boolean()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),

        ]);
        $this->batchInsert('status', ['name', 'is_deleted', 'created_at', 'updated_at'], [
            ['Available', 0, time(), time()],
            ['Occupied', 0, time(), time()],
            ['Pending Approval', 0, time(), time()],
            ['Active', 0, time(), time()],
            ['Inactive', 0, time(), time()],
            ['Resolved', 0, time(), time()],
            ['In Progress', 0, time(), time()],
            ['vacant', 0, time(), time()],
           
        ]);
        $this->createTable('{{%property}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'address' => $this->text()->notNull(),
            'type' => $this->string()->notNull(),
            'description' => $this->text(),
            'owner_id' => $this->bigInteger(),
            'status_id' => $this->integer()->notNull(),
            'is_deleted' => $this->boolean()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY (owner_id) REFERENCES  {{%users}} ([[user_id]])'.
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY (status_id) REFERENCES {{%status}} ([[id]])'.
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);
        $this->createTable('{{%unit}}', [
            'id' => $this->primaryKey(),
            'property_id' => $this->integer()->notNull(),
            'unit_number' => $this->string()->notNull(),
            'monthly_rent' => $this->decimal(10,2)->notNull(),
            'status_id' => $this->integer()->notNull(),
            'is_deleted' => $this->boolean()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY (property_id) REFERENCES {{%property}} ([[id]])'.
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY (status_id) REFERENCES {{%status}} ([[id]])'.
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
    
        ]);
        $this->createTable('{{%tenancy}}', [
            'id' => $this->primaryKey(),
            'unit_id' => $this->integer()->notNull(),
            'tenant_id' => $this->bigInteger(),
            'start_date' => $this->date()->notNull(),
            'end_date' => $this->date()->null(),
            'payment_status' => $this->integer()->notNull()->defaultValue(0),
            'is_deleted' => $this->boolean()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY (unit_id) REFERENCES {{%unit}} ([[id]])'.
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY (tenant_id) REFERENCES {{%users}} ([[user_id]])'.
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
         
        ]);
        $this->createTable('{{%maintenance_request}}', [
            'id' => $this->primaryKey(),
            'unit_id' => $this->integer()->notNull(),
            'tenant_id' => $this->bigInteger(),
            'description' => $this->text()->notNull(),
            'status_id' => $this->integer()->notNull(),
            'is_deleted' => $this->boolean()->defaultValue(0),
            'requested_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'resolved_at' => $this->timestamp()->null(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY (unit_id) REFERENCES {{%unit}} ([[id]])'.
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY (tenant_id) REFERENCES {{%users}} ([[user_id]])'.
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY (status_id) REFERENCES {{%status}} ([[id]])'.
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250117_112108_hms_tables cannot be reverted.\n";

        return false;
    }
    protected function buildFkClause($delete = '', $update = '')
    {
        return implode(' ', ['', $delete, $update]);
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250117_112108_hms_tables cannot be reverted.\n";

        return false;
    }
    */
}
