<?php

namespace Artemus;


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
    protected $groups;

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
     * @param string $name
     * @param mixed $value
     */
    public function setField( $name, $value, $atts=null )
    {
        if( !is_array($this->fields) )
        {
            $this->fields = [];
        }

        if( !is_null($atts) )
        {
            $value = [
                'value' => $value,
                'atts' => $atts
            ];
        }

        $this->fields[$name] = $value;
    }

    /**
     * @param array $groups
     */
    public function setGroups($groups)
    {
        if( !is_array($groups) )
        {
            $groups = [$groups];
        }

        $this->groups = $groups;
    }

    /**
     * @return array
     */
    public function getGroups()
    {
        return $this->groups;
    }
}