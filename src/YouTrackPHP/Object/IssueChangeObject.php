<?php


namespace YouTrackPHP\Object;

interface IssueChangeObject extends YouTrackObject
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getOldValue();

    /**
     * @return mixed
     */
    public function getNewValue();
}