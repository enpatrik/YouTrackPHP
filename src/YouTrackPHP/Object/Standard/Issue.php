<?php

namespace YouTrackPHP\Object\Standard;

use YouTrackPHP\Object\Basic\Issue as BasicIssue;

class Issue extends BasicIssue
{
    public function getSummary()
    {
        return $this->getProperty(self::SUMMARY);
    }

    public function getDescription()
    {
        return $this->getProperty(self::DESCRIPTION);
    }

    public function getUpdaterName()
    {
        return $this->getProperty(self::UPDATER_NAME);
    }

    public function getUpdaterFullName()
    {
        return $this->getProperty(self::UPDATER_FULL_NAME);
    }

    public function getReporterName()
    {
        return $this->getProperty(self::REPORTER_NAME);
    }

    public function getReporterFullName()
    {
        return $this->getProperty(self::REPORTER_FULL_NAME);
    }

    public function getPriority()
    {
        return $this->getFirstPropertyValue(self::PRIORITY);
    }

    public function getType()
    {
        return $this->getFirstPropertyValue(self::TYPE);
    }

    public function getState()
    {
        return $this->getFirstPropertyValue(self::STATE);
    }
}