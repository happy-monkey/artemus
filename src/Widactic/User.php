<?php

namespace Widactic;


class User extends Entry
{
    public static $API_ENDPOINT = "users";

    /**
     * @var string
     */
    protected $firstname;

    /**
     * @var string
     */
    protected $lastname;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var array
     */
    protected $fields;

    /**
     * @var array
     */
    protected $entities;

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param array $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function getField( $name )
    {
        if( isset($this->fields[$name]) )
        {
            return $this->fields[$name];
        }

        return null;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param string $attr
     */
    public function setField( $name, $value, $attr=null )
    {
        if( !is_array($this->fields) )
        {
            $this->fields = [];
        }

        if( !is_null($attr) )
        {
            $value = [
                'value' => $value,
                'attr' => $attr
            ];
        }

        $this->fields[$name] = $value;
    }

    /**
     * @param array $groups
     */
    public function setEntities($entities)
    {
        if( !is_array($entities) )
        {
            $entities = [$entities];
        }

        $this->entities = $entities;
    }

    /**
     * @return array
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * @param $entity
     */
    public function setEntity( $entity )
    {
        $this->setEntities([$entity]);
    }

    public function loadJSON($json)
    {
        if( isset($json->fields) )
        {
            $json->fields = (array) $json->fields;
        }

        parent::loadJSON($json);
    }
}