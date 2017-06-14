<?php

use yii\db\Migration;

class m170608_235529_create_setting_category_table extends Migration
{
    private function tableName(){
        return 'bs_setting_category';
    }

    public function up()
    {
        $this->createTable($this->tableName(), [
            'id' => $this->primaryKey(),
            'category' => $this->string(64)->notNull()->comment('used in setting getter and setter'),
            'title' => $this->string(64)->notNull()->comment('shown in management page and setting index page'),
            'weight' => $this->integer()->defaultValue(0),
            'createdAt' => $this->datetime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updatedAt' => $this->datetime()->defaultExpression('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'),
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
