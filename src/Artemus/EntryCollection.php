<?php

namespace Artemus;

class EntryCollection implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $className = null;

    /**
     * @var Entry[]
     */
    private $entries = [];

    public function __construct( $className )
    {
        if( !class_exists($className) )
        {
            $className =__NAMESPACE__."\\".$className;
        }

        if( class_exists($className) )
        {
            $path = explode("\\", $className);
            $this->className = end($path);
        }
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->entries);
    }

    /**
     * @param Entry $entry
     */
    public function add( $entry )
    {
        $this->entries[] = $entry;
    }

    /**
     * @return Entry[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @param Entry[] $entries
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;
    }

    /**
     * @param string $fieldName
     */
    public function sync( $fieldName )
    {
        $this->entries = Client::bulk_sync($this->className, $this->entries, $fieldName);
    }

    /**
     * @param string $query
     */
    public function fetch( $query="" )
    {
        $this->entries = Client::fetch($this->className, $query);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];

        foreach( $this->getEntries() as $entry )
        {
            $result[] = $entry->toArray();
        }

        return $result;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->getEntries();
    }
}