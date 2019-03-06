<?php
/**
 * Created by PhpStorm.
 * User: comic0
 * Date: 01/03/2019
 * Time: 09:09
 */

namespace Artemus;


class Formation extends Entry
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $api_name;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $api_name
     */
    public function setApiName($api_name)
    {
        $this->api_name = $api_name;
    }

    /**
     * @return string
     */
    public function getApiName()
    {
        return $this->api_name;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}