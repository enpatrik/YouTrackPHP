<?php
namespace YouTrackPHP\Object;


class ObjectCreator
{
    const ISSUE = 'Issue';
    /** @var array */
    protected $availableObjectNames = array(self::ISSUE);
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
     * @param $objectName
     * @return IssueObject
     * @throws \Exception
     */
    public function getNewObjectClass($objectName)
    {
        if (! in_array($objectName, $this->availableObjectNames)) {
            throw new \Exception('Invalid object name:' . $objectName);
        } else if (isset($this->objectClasses[$objectName])) {
            return new $this->objectClasses[$objectName];
        }
        $standardClassName = __NAMESPACE__ . "\\Standard\\" . $objectName;
        return new $standardClassName;
    }

    /**
     * @return IssueObject
     */
    public function createIssue()
    {
        return $this->getNewObjectClass(self::ISSUE);
    }
}