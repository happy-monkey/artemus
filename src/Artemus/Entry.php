<?php

namespace Artemus;


class Entry implements \JsonSerializable
{
    public static $API_ENDPOINT = null;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $created_at;

    /**
     * @var string
     */
    private $updated_at;

    static public function fromArray( $array )
    {
        $result = [];
        foreach( $array as $json )
        {
            $result[] = static::fromJson($json);
        }
        return $result;
    }

    static public function fromJson( $json )
    {
        $obj = new static();
        $obj->loadJSON($json);
        return $obj;
    }

    static public function collection()
    {
        $collection = new EntryCollection(get_class(new static()));

        return $collection;
    }

    function __construct( $idEntry=null )
    {
        if( !is_null($idEntry) )
        {
            Client::get($this, $idEntry);
        }
    }

    public function loadJSON( $json )
    {
        foreach( $json as $key=>$value )
        {
            if( property_exists($this, $key) )
            {
                if( is_numeric($value) )
                {
                    $value = intval($value);
                }

                $this->$key = $value;
            }
        }
    }

    /**
     * List of objects for export in JSON or print_r
     *
     * @return array
     */
    public function toArray()
    {
        $vars = get_object_vars($this);
        $data = [];

        foreach( $vars as $property=>$value )
        {
            $getter = "get".str_replace(' ', '', ucwords(str_replace('_', ' ', $property)));
            if( method_exists($this, $getter) )
            {
                $data[$property] = call_user_func_array([$this, $getter], []);
            }
        }

        return $data;
    }

    /**
     * Call API to create or update object
     *
     * @return bool Return true if object is saved
     */
    public function save()
    {
        return Client::save($this);
    }

    /**
     * Call API to sync object
     *
     * @param string $fieldName Name of the field to use for check if object exists
     * @return bool Return true if object is synced
     */
    public function sync( $fieldName )
    {
        return Client::sync($this, $fieldName);
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
        return $this->toArray();
    }

    /**
     * ID of object
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Last update date in mysql DATETIME format
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Last update date in mysql DATETIME format
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}