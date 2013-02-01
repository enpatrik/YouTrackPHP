<?php
namespace YouTrackPHP\Object;


class ObjectCreator
{
    const ISSUE = 'Issue';
    const ISSUE_CHANGE = 'IssueChange';
    const ISSUE_CHANGE_GROUP = 'IssueChangeGroup';
    /** @var array */
    protected $availableObjectNames = array(
        self::ISSUE,
        self::ISSUE_CHANGE,
        self::ISSUE_CHANGE_GROUP
    );
    /** @var array */
    protected $objectClasses = array();

    /**
     * @param array $objectClasses
     */
    public function __construct($objectClasses = array())
    {
        $this->setObjectClasses($objectClasses);
    }

    /**
     * @param array $objectClasses
     */
    public function setObjectClasses(array $objectClasses)
    {
        foreach ($objectClasses as $objectName => $className) {
            $this->setObjectClass($objectName, $className);
        }
    }

    /**
     * @param $objectName
     * @param $className
     * @throws \Exception
     */
    public function setObjectClass($objectName, $className)
    {
        if (in_array($objectName, $this->availableObjectNames)) {
            $this->objectClasses[$objectName] = $className;
        } else {
            throw new \Exception('Invalid object name:' . $objectName);
        }
    }

    /**
     * @param string $objectName
     * @return string
     * @throws \Exception
     */
    public function getObjectClass($objectName)
    {
        if (! in_array($objectName, $this->availableObjectNames)) {
            throw new \Exception('Invalid object name: ' . $objectName);
        } else if (isset($this->objectClasses[$objectName])) {
            $className = $this->objectClasses[$objectName];
        } else {
            // Standard
            $className = __NAMESPACE__ . "\\Standard\\" . $objectName;
        }

        if (! class_exists($className)) {
            throw new \Exception('Invalid class name: ' . $className);
        }

        return $className;
    }

    /**
     * @param $objectName
     * @return IssueObject
     * @throws \Exception
     */
    public function getNewObjectClass($objectName)
    {
        $className = $this->getObjectClass($objectName);
        return new $className;
    }

    /**
     * @return IssueObject
     */
    public function createIssue()
    {
        return $this->getNewObjectClass(self::ISSUE);
    }

    public function createIssueChangeGroup()
    {
        /** @var IssueChangeGroupObject $issueChangeGroup */
        $issueChangeGroup = $this->getNewObjectClass(self::ISSUE_CHANGE_GROUP);
        $issueChangeGroup->setIssueChangeClass($this->getObjectClass(self::ISSUE_CHANGE));
        return $issueChangeGroup;
    }
}