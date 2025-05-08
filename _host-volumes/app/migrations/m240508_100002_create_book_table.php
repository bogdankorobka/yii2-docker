<?php

declare(strict_types=1);

use yii\db\Migration;

class m240508_100002_create_book_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'published_at' => $this->date(),
        ]);

        $this->createIndex('idx-book-author_id', 'book', 'author_id');

        $this->addForeignKey(
            'fk-book-author_id',
            'book',
            'author_id',
            'author',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown(): void
    {
        $this->dropForeignKey('fk-book-author_id', 'book');
        $this->dropIndex('idx-book-author_id', 'book');
        $this->dropTable('book');
    }
}
