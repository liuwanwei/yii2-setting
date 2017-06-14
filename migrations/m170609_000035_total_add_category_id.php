<?php

use yii\db\Migration;

class m170609_000035_total_add_category_id extends Migration
{
    private function settingTable(){
        return 'bs_setting';
    }

    private function changeLogTable(){
        return 'bs_setting_change_log';
    }

    private function upSettingTable(){
        $tableSchema = Yii::$app->db->getTableSchema($this->settingTable());

        if (isset($tableSchema->columns['category'])) {
            // delete old string type category column
            $this->dropColumn($this->settingTable(), 'category');
        }

        if (! isset($tableSchema->columns['categoryId'])) {
            // add categoryId after delete category
            $col = $this->integer()->defaultValue(0)->after('id');
            $this->addColumn($this->settingTable(), 'categoryId', $col);
        }        
    }

    private function upChangeLogTable(){
        $tableSchema = Yii::$app->db->getTableSchema($this->changeLogTable());
        if (! isset($tableSchema->columns['categoryId'])) {
            $col = $this->integer()->defaultValue(0)->after('id');
            // add categoryId according to setting table
            $this->addColumn($this->changeLogTable(), 'categoryId', $col);
        }
    }

    private function downSettingTable(){
        $tableSchema = Yii::$app->db->getTableSchema($this->settingTable());

        if (isset($tableSchema->columns['categoryId'])) {
            $this->dropColumn($this->settingTable(), 'categoryId');
        }
    }

    private function downChangeLogTable(){
        $tableSchema = Yii::$app->db->getTableSchema($this->changeLogTable());
        if (isset($tableSchema->columns['categoryId'])) {
            $this->dropColumn($this->changeLogTable(), 'categoryId');
        }
    }

    public function up()
    {
         $this->upSettingTable();
         $this->upChangeLogTable();       
    }

    public function down()
    {
        $this->downSettingTable();
        $this->downChangeLogTable();
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
