<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%city_review}}`.
 */
class m230116_124519_create_city_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%city_review}}', [
            'id' => $this->primaryKey(),
            'city_id' => $this->integer()->notNull(),
            'review_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey(
            'FK_relation_city',
            '{{%city_review}}',
            'city_id',
            '{{%city}}',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'FK_relation_review',
            '{{%city_review}}',
            'review_id',
            '{{%review}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%city_review}}');
    }
}
