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
     * @param string $name
     * @param mixed $value
     */
    public function addProperty($name, $value)
    {
        $this->properties[$name] = $value;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getProperty($name)
    {
        if (isset($this->properties[$name])) {
            return $this->properties[$name];
        }
        return null;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }
}
