<?php

use yii\db\Migration;

/**
 * Class m201027_135546_statistic
 */
class m201027_135546_statistic extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('statistics', [
            'id' => $this->primaryKey(),
            'campaign_id' => $this->integer()->notNull(),
            'cid' => $this->string(255)->notNull(),
            'install' => $this->boolean()->defaultValue(false)->notNull(),
            'trial' => $this->boolean()->defaultValue(false)->notNull(),
            'click' => $this->boolean()->defaultValue(false)->notNull(),
            'sub1' => $this->string(255),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('statistics');
    }
}
