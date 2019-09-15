<?php
declare(strict_types=1);

namespace harlequiin\Patterns\ActiveRecord;

use DateTime;

class Post extends ActiveRecord
{
    /**
     * @var string post's content
     */
    protected $content;

    /**
     * @var DateTime DateTime date posted
     */
    protected $date;

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $text): void
    {
        $this->content = $text;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    protected function collectProperties(): array
    {
        return [
            "content" => $this->getContent(),
            "date" => $this->getDate()
        ];
    }

    public static function find(int $id): Post
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE `id` = :id ;";

        try {
            $pdoStatement = $this->pdo->prepare($sql);
            $pdoStatement->execute(["id" => $id]);
            $pdoObject = $pdoStatement->fetch(PDO::FETCH_OBJ);
            $post = new Post($this->pdo);
            $post->setText($pdoObject->id);
            $post->setDate($pdoObject->username);
            return $post;
        } catch (Exception $e) {
            throw new ActiveRecordException($e->getMessage());
        }
    }
}
