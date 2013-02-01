<?php
namespace YouTrackPHP\Object\Basic;

use YouTrackPHP\Object\AbstractObject;
use YouTrackPHP\Object\IssueChangeGroupObject;
use YouTrackPHP\Object\IssueChangeObject;

class IssueChangeGroup extends AbstractObject implements IssueChangeGroupObject
{
    const UPDATER_NAME = 'updaterName';
    const UPDATED = 'updated';
    const COMMENTS = 'comments';
    const CHANGES = 'changes';

    /** @var IssueChange[] */
    protected $changes;
    /** @var string */
    protected $issueChangeClass;

    /**
     * @param string $className
     */
    public function setIssueChangeClass($className)
    {
        $this->issueChangeClass = $className;
    }

    /**
     * @return string
     */
    public function getIssueChangeClass()
    {
        return $this->issueChangeClass;
    }

    /**
     * @param array $arr
     * @throws \Exception
     */
    public function populateFromArray(array $arr)
    {
        $issueChangeClass = $this->getIssueChangeClass();
        if (!$issueChangeClass) {
            throw new \Exception('Issue change class not set.');
        } else if (!class_exists($issueChangeClass)) {
            throw new \Exception('Issue change class does not exist: ' . $issueChangeClass);
        }

        foreach ($arr as $name => $value) {
            if ($name === 'field') {
                $this->populateFromArray($value);
            } elseif (isset($value['newValue'])) {
                /** @var IssueChangeObject $issueChange */
                $issueChange = new $issueChangeClass;
                $issueChange->populateFromArray($value);
                $this->addChange($issueChange);
            } elseif (isset($value['name']) && isset($value['value'])) {
                $this->addProperty($value['name'], $value['value']);
            } else {
                $this->addProperty($name, $value);
            }
        }
    }

    /**
     * @param IssueChangeObject $issueChange
     * @return mixed|void
     */
    public function addChange(IssueChangeObject $issueChange)
    {
        $this->changes[ $issueChange->getName() ] = $issueChange;
    }

    /**
     * @return array
     */
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * @param string $name
     * @return IssueChangeObject
     */
    public function getChangeByName($name)
    {
        if (isset($this->changes[$name])) {
            return $this->changes[$name];
        }
        return null;
    }

    /**
     * @return int|null
     */
    public function getUpdated()
    {
        return $this->getProperty(self::UPDATED);
    }
}
