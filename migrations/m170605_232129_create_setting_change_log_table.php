<?php

use yii\db\Migration;

class m170605_232129_create_setting_change_log_table extends Migration
{
    private function tableName(){
        return 'bs_setting_change_log';
    }

    public function up()
    {
        $this->createTable($this->tableName(), [
            'id' => $this->primaryKey(),
            'key' => $this->string(64)->notNull(),            
            'oldValue' => $this->text()->defaultValue(null),
            'newValue' => $this->text()->defaultValue(null),
            'userId' => $this->integer(),
            'createdAt' => $this->datetime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    public function down()
    {
        $this->dropTable($this->tableName());
        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
