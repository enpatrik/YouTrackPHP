<?php
namespace YouTrackPHP\Object;

abstract class AbstractObject
{
    /** @var array */
    protected $properties = array();

    /**
     * @param $mixed
     * @throws \Exception
     */
    public function populate($mixed)
    {
        if (is_array($mixed)) {
            $this->populateFromArray($mixed);
        } else {
            throw new \Exception('Unsupported type to populate with.');
        }
    }

    /**
     * @abstract
     * @param array $arr
     */
    public abstract function populateFromArray(array $arr);

    /**
     * @param $name
     * @param $value
     */
    public function addProperty($name, $value)
    {
        $this->properties[$name] = $value;
    }

    public function getProperty($name)
    {
        if (isset($this->properties[$name])) {
            return $this->properties[$name];
        }
        throw new \Exception('Property not found: ' . $name);
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }
}
