<?php
namespace YouTrackPHP\Object;


interface YouTrackObject {
    /**
     * @param $mixed
     * @throws \Exception
     */
    public function populate($mixed);

    /**
     * @param array $arr
     */
    public function populateFromArray(array $arr);

    /**
     * @param string $name
     * @param mixed $value
     */
    public function addProperty($name, $value);

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getProperty($name);

    /**
     * @return array
     */
    public function getProperties();

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getFirstPropertyValue($name);
}