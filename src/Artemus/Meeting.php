<?php
/**
 * Created by PhpStorm.
 * User: comic0
 * Date: 01/03/2019
 * Time: 00:57
 */

namespace Artemus;


class Meeting extends Entry
{
    public static $API_ENDPOINT = "meetings";

    protected $binds = [
        "animator" => "Artemus\User",
        "formation" => "Artemus\Formation",
        "participants[]" => "Artemus\Participant"
    ];

    /**
     * @var string
     */
    protected $uid;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $place;

    /**
     * @var string
     */
    protected $started_at;

    /**
     * @var string
     */
    protected $ended_at;

    /**
     * @var User
     */
    protected $animator;

    /**
     * @var Formation
     */
    protected $formation;

    /**
     * @var Participant[]
     */
    protected $participants;

    /**
     * @param string $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

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
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param string $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * @param string $started_at
     */
    public function setStartedAt($started_at)
    {
        $this->started_at = $started_at;
    }

    /**
     * @return string
     */
    public function getStartedAt()
    {
        return $this->started_at;
    }

    /**
     * @param string $ended_at
     */
    public function setEndedAt($ended_at)
    {
        $this->ended_at = $ended_at;
    }

    /**
     * @return string
     */
    public function getEndedAt()
    {
        return $this->ended_at;
    }

    /**
     * @param User $animator
     */
    public function setAnimator($animator)
    {
        $this->animator = $animator;
    }

    /**
     * @return User
     */
    public function getAnimator()
    {
        return $this->animator;
    }

    /**
     * @param Formation $formation
     */
    public function setFormation($formation)
    {
        $this->formation = $formation;
    }

    /**
     * @return Formation
     */
    public function getFormation()
    {
        return $this->formation;
    }

    /**
     * @param Participant[] $participants
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;
    }

    /**
     * @return Participant[]
     */
    public function getParticipants()
    {
        return $this->participants;
    }
}