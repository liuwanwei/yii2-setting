<?php

use yii\db\Migration;

class m170606_003235_setting_add_category extends Migration
{
    private function tableName(){
        return 'bs_setting';
    }

    public function up()
    {
        $col = $this->string(32)->defaultValue(null)->after('id');
        $this->addColumn($this->tableName(), 'category', $col);
    }

    public function down()
    {
        $this->dropColumn($this->tableName(), 'category');
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
