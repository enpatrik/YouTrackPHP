<?php
namespace YouTrackPHP\Object;

class IssueChange extends AbstractObject
{
    const NAME = 'name';
    const OLD_VALUE = 'oldValue';
    const NEW_VALUE = 'newValue';

    /**
     * @param array $arr
     */
    public function populateFromArray(array $arr)
    {
        foreach ($arr as $name => $value) {
            $this->addProperty($name, $value);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getProperty(self::NAME);
    }

    /**
     * @return mixed
     */
    public function getOldValue()
    {
        return $this->getProperty(self::OLD_VALUE);
    }

    /**
     * @return mixed
     */
    public function getNewValue()
    {
        return $this->getProperty(self::NEW_VALUE);
    }
}
