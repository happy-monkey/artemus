<?php

namespace Artemus;


class EntryCollection implements \JsonSerializable
{
    /**
     * @var string
     */
    private $entryType;

    /**
     * @var string
     */
    private $endpoint;

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
            $this->entryType = $className;
            $this->endpoint = $className::$API_ENDPOINT;
        }
    }

    /**
     * @return string
     */
    public function _getEntryType()
    {
        return $this->entryType;
    }

    /**
     * @return string
     */
    public function _getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->entries);
    }

    /**
     * Get entry at first position
     *
     * @return Entry|bool
     */
    public function getFirst()
    {
        return reset($this->entries);
    }

    /**
     * Get entry at last position
     *
     * @return Entry|bool
     */
    public function getLast()
    {
        return end($this->entries);
    }

    /**
     * Get entry at a position
     *
     * @param int $index Index of entry
     * @return Entry|bool
     */
    public function get( $index )
    {
        if( isset($this->entries[$index]) )
        {
            return $this->entries[$index];
        }

        return false;
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
        return Client::bulk_sync($this, $fieldName);
    }

    /**
     * @param string $query
     */
    public function fetch( $query="" )
    {
        return Client::fetch($this, $query);
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