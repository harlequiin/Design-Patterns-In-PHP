<?php
declare(strict_types=1);

namespace harlequiin\Patterns\ActiveRecord;

class ActiveRecord
{
    /**
     * @var DatabaseInterface database class which provides lower lever
     * modification query options
     */
    protected $db;

    /**
     * @var string table for the particular record set
     */
    protected $table;

    public function __construct(DatabaseInterface $db, string $table)
    {
       $this->db = $db; 
       $this->table = $table;
    }

    public function save()
    {
        try {
            $this->db->create($this->table, $this->fields);
        } catch (\DatabaseException $e) {
            $this->db->update($this->table, $this->id ,$this->fields);
        } catch (\DatabaseException $e) {
            throw new ModelException($e->getMessage());
        }
        
    }

    public function delete()
    {
        try {
            $this->db->deleteById($this->table, $this->id);
        } catch (\DatabaseException $e) {
            throw new ModelException($e->getMessage());
        } 
    }
}
