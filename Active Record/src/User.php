<?php
declare(strict_types=1);

namespace harlequiin\Patterns\ActiveRecord;

class User extends ActiveRecord
{
    /**
     * @var integer|string|null ID of the particular user record
     * null if new (unpersisted) user object
     */
    protected $id;

    /**
     * @var array array of user fields
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

    public function getUserId()
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->fields["username"];
    }

    public function setUsername(string $username): void
    {
        $this->fields["username"] = $username;
    }
}
