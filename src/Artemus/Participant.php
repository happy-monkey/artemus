<?php
/**
 * Created by PhpStorm.
 * User: comic0
 * Date: 01/03/2019
 * Time: 09:09
 */

namespace Artemus;


class Participant extends Entry
{
    public static $API_ENDPOINT = "participants";

    protected $binds = [
        "user" => "Artemus\User",
        "results[]" => "Artemus\ModuleResult"
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