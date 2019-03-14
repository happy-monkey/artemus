<?php

namespace Widactic;


class Participant extends Entry
{
    public static $API_ENDPOINT = "participants";

    protected $binds = [
        "user" => "Widactic\User",
        "results[]" => "Widactic\ModuleResult"
    ];

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
     * @var User
     */
    protected $user;

    /**
     * @var ModuleResult[]
     */
    protected $results;

    /**
     * @var array
     */
    protected $fields;

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
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return ModuleResult[]
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param int $index
     * @return ModuleResult[]
     */
    public function getResultsAtIndex( $index )
    {
        return array_filter($this->results, function (ModuleResult $result) use ($index) {
           return $result->getIndex() == $index;
        });
    }

    /**
     * @param int $index
     * @return ModuleResult|null
     */
    public function getLastResultAtIndex( $index )
    {
        $results = array_reverse($this->getResultsAtIndex($index));
        return reset($results);
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
        if( !is_array($this->fields) )
        {
            $this->fields = (array) $this->fields;
        }

        return $this->fields;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function getField( $name )
    {
        if( !is_array($this->fields) )
        {
            $this->fields = (array) $this->fields;
        }

        if( isset($this->fields[$name]) )
        {
            return $this->fields[$name];
        }

        return null;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function getFieldValue( $name )
    {
        if( $field = $this->getField($name) )
        {
            return $field->value;
        }

        return null;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function getFieldAttribute( $name )
    {
        if( $field = $this->getField($name) )
        {
            return $field->attr;
        }

        return null;
    }


    public function loadJSON($json)
    {
        $this->results = [];

        parent::loadJSON($json);

        if( $this->user && !$this->user->exists() )
        {
            $this->user->setFirstname($this->firstname);
            $this->user->setLastname($this->lastname);
            $this->user->setEmail($this->email);
        }
    }
}