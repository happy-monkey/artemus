<?php
/**
 * Created by PhpStorm.
 * User: comic0
 * Date: 19/02/2019
 * Time: 20:51
 */

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

    public function save()
    {
        return Client::save($this);
    }

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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}