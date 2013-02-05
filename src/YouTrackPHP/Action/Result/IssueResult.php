<?php

namespace YouTrackPHP\Action\Result;


use YouTrackPHP\Object\YouTrackObject;

class IssueResult extends AbstractActionResult
{
    /**
     * @param array $arr
     * @return YouTrackObject|null
     */
    protected function createObjectFromArray(array $arr)
    {
        $issue = $this->objectCreator->createIssue();
        $issue->populate($arr);
        return $issue;
    }

    /**
     * @return YouTrackObject[]
     */
    public function asObjectCollection()
    {
        $issues = array();
        foreach ($this->asArray() as $issueArray) {
            $issues[] = $this->createObjectFromArray($issueArray);
        }
        return $issues;
    }
}