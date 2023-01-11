<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%review}}`.
 */
class m230111_083244_create_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%review}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(128)->notNull(),
            'text' => $this->text()->notNull(),
            'rating' => $this->tinyInteger(5)->notNull(),
            'img' => $this->binary(),
            'create_time' => $this->integer(),
            'city_id' => $this->integer(),
            'author_id' => $this->integer()
        ], $tableOptions);

        $this->addForeignKey(
            'FK_review_city',
            '{{%review}}',
            'city_id',
            '{{%city}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'FK_review_author',
            '{{%review}}',
            'author_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%review}}');
    }
}
