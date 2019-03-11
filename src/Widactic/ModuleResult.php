<?php

namespace Widactic;


class ModuleResult extends Entry
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var int
     */
    protected $individual;

    /**
     * @var float
     */
    protected $estimatedTime;

    /**
     * @var string
     */
    protected $startedAt;

    /**
     * @var string
     */
    protected $finishedAt;

    /**
     * @var int
     */
    protected $index;

    /**
     * @var array
     */
    protected $answers;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getIndividual()
    {
        return $this->individual;
    }

    /**
     * @return float
     */
    public function getEstimatedTime()
    {
        return $this->estimatedTime;
    }

    /**
     * @return string
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * @return string
     */
    public function getFinishedAt()
    {
        return $this->finishedAt;
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @return array
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    public function save()
    {
        return false;
    }

    public function sync($fieldName)
    {
        return false;
    }
}