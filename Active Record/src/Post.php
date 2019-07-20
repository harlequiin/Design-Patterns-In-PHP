<?php
declare(strict_types=1);

namespace harlequiin\Patterns\ActiveRecord;

class Post extends ActiveRecord
{
    /**
     * @var integer|string|null ID of the particular post record
     * null if the post object is new (unpersisted)
     */
    protected $id;

    /**
     * @var array array of post fields
     */
    protected $fields;

    public function __construct(
        DatabaseInterface $db, 
        array $fields
    )
    {
        parent::__construct($db, "user");

        $this->id = $fields["id"] ?? null;
        unset($fields["id"]);
        $this->fields = $fields;
    }

    public function getText(): string
    {
       return $this->fields["text"]; 
    }

    public function setText(string $text): void
    {
       $this->fields["text"] = $text; 
    }

}
