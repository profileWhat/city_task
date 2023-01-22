<?php

use yii\db\Migration;

/**
 * Class m230122_101702_insert_values
 */
class m230122_101702_insert_values extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("INSERT INTO tbl_city (name) VALUES ('Izhevsk'), ('Moscow'), ('Mayami'), ('Saint Petersburg'), ('Paris')");
        $this->execute("INSERT INTO tbl_user (fio, email, phone, password) VALUES ('admin', 'admin@mail.ru', '+79199044486', '$2y$13\$pqL7ZSsBKYFb5RDDf0RsQ.lEbTkdpk43l/cM/dKMfzNLnCGNe8wpi')");
        $this->execute("INSERT INTO tbl_review (title, text, rating, img, author_id) VALUES 
            ('Admin', 'Admin', 5, NULL, '1'),
            ('Admin', 'Admin', 5, '43815f3075c79fcf84b013e4ad11df84.jpg', '1'),
            ('Admin', 'Admin', 5, 'n58yUoE2d18.jpg', '1')");
        $this->execute("INSERT INTO tbl_city_review (city_id, review_id) VALUES 
            (1, 1), (1, 2), (1, 3), (2, 1), (2, 2), (2, 3), (3, 1), (3, 2), (3, 3)");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230122_101702_insert_values cannot be reverted.\n";

        return false;
    }

}
