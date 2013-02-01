<?php


namespace YouTrackPHP\Object;


interface IssueChangeGroupObject extends YouTrackObject
{
    /**
     * @param string $className
     */
    public function setIssueChangeClass($className);

    /**
     * @return string
     */
    public function getIssueChangeClass();

    /**
     * @param IssueChangeObject $issueChange
     * @return mixed
     */
    public function addChange(IssueChangeObject $issueChange);

    /**
     * @return IssueChangeObject[]
     */
    public function getChanges();

    /**
     * @param string $name
     * @return IssueChangeObject
     */
    public function getChangeByName($name);

    /**
     * @return int|null
     */
    public function getUpdated();
}