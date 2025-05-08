<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 * @property int $author_id
 * @property string|null $published_at
 *
 * @property Author $author
 */
class Book extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'book';
    }

    public function rules(): array
    {
        return [
            [['title', 'author_id'], 'required'],
            [['author_id'], 'integer'],
            [['published_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * Gets query for [[Author::class]].
     *
     * @return ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }
}
