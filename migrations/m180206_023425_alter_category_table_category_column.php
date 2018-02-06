<?php

use yii\db\Migration;

/**
 * Class m180206_023425_alter_category_table_category_column
 */
class m180206_023425_alter_category_table_category_column extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
	    $col = $this->string(64)->notNull()->unique()->comment('used in setting getter and setter');
	    $this->alterColumn('bs_setting_category', 'category', $col);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
    
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180206_023425_alter_category_table_category_column cannot be reverted.\n";

        return false;
    }
    */
}
