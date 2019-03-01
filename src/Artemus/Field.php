<?php
/**
 * Created by PhpStorm.
 * User: comic0
 * Date: 28/02/2019
 * Time: 16:41
 */

namespace Artemus;


class Field extends Entry
{
    public static $API_ENDPOINT = "fields";

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $api_name;

    /**
     * @var array
     */
    protected $values = [];

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getApiName()
    {
        return $this->api_name;
    }

    /**
     * @param string $api_name
     */
    public function setApiName($api_name)
    {
        $this->api_name = $api_name;
    }

    /**
     * @param array $values
     */
    public function setValues($values)
    {
        $this->values = $values;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    public function addValue( $value, $attr=null )
    {
        if( !is_null($attr) )
        {
            foreach( $this->values as $i=>$object )
            {
                if( $object->attr = $attr )
                {
                    $this->values[$i]->value = $value;
                    return $this;
                }
            }
        }

        $object = new \stdClass();
        $object->attr = $attr;
        $object->value = $value;
        $this->values[] = $object;

        return $this;
    }

    public function sync($fieldName=null)
    {
        // TODO: FUNCTION NOT AVAILABLE
    }
}