<?php

declare(strict_types=1);

use yii\db\Migration;

class m240508_100001_create_author_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('author', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    public function safeDown(): void
    {
        $this->dropTable('author');
    }
}
