<?php


namespace YouTrackPHP\Action\Result;

use YouTrackPHP\Object\YouTrackObject;

class IssueChangeResult extends AbstractActionResult
{
    /**
     * @param array $arr
     * @return YouTrackObject|null
     */
    protected function createObjectFromArray(array $arr)
    {
        $issueChangeGroup = $this->objectCreator->createIssueChangeGroup();
        $issueChangeGroup->populate($arr);
        return $issueChangeGroup;
    }

    /**
     * @return YouTrackObject[]
     */
    public function asObjectCollection()
    {
        $changeGroups = array();
        $result = $this->asArray();
        foreach ($result['change'] as $changeArray) {
            $changeGroups[] = $this->createObjectFromArray($changeArray);
        }
        return $changeGroups;
    }
}