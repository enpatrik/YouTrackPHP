<?php
namespace YouTrackPHP\Object;

interface IssueObject extends YouTrackObject
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return int
     */
    public function getCreated();

    /**
     * @return int
     */
    public function getUpdated();
}