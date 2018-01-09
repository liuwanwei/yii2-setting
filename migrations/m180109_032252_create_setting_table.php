<?php

use yii\db\Migration;

/**
 * Handles the creation of table `setting`.
 */
class m180109_032252_create_setting_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('bs_setting', [
            'id' => $this->primaryKey(),
	        'categoryId' => $this->integer()->defaultValue(0),
	        'name' => $this->string(32)->notNull(),
	        'key' => $this->string(64)->notNull(),
	        'value' => $this->text()->defaultValue(null),
	        'description' => $this->text()->defaultValue(null),
	        'weight' => $this->integer()->defaultValue(0),
	        'updatedAt' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'),
        ]);
	
	    $this->createTable("bs_setting_change_log", [
		    'id' => $this->primaryKey(),
		    'categoryId' => $this->integer()->defaultValue(0),
		    'key' => $this->string(64)->notNull(),
		    'oldValue' => $this->text()->defaultValue(null),
		    'newValue' => $this->text()->defaultValue(null),
		    'userId' => $this->integer(),
		    'createdAt' => $this->datetime()->defaultExpression('CURRENT_TIMESTAMP'),
	    ]);
	
	    $this->createTable("bs_setting_category", [
		    'id' => $this->primaryKey(),
		    'category' => $this->string(64)->notNull()->comment('used in setting getter and setter'),
		    'title' => $this->string(64)->notNull()->comment('shown in management page and setting index page'),
		    'weight' => $this->integer()->defaultValue(0),
		    'createdAt' => $this->datetime()->defaultExpression('CURRENT_TIMESTAMP'),
		    'updatedAt' => $this->datetime()->defaultExpression('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'),
	    ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('bs_setting');
	    $this->dropTable('bs_setting_change_log');
	    $this->dropTable('bs_setting_category');
    }
}
