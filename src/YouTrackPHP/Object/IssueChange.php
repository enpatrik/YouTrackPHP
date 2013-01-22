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
}
