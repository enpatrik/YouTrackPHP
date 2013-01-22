<?php
namespace YouTrackPHP\Action;

use YouTrackPHP\Object\Issue;
use Guzzle\Http\QueryString;
use YouTrackPHP\Object\IssueChangeGroup;
use YouTrackPHP\Action\AbstractAction;

class IssueAction extends AbstractAction
{
    /**
     * @return string
     */
    protected function getObjectUrl()
    {
        return 'issue';
    }

    /**
     * @param $issueId
     * @return Issue
     */
    public function getById($issueId)
    {
        $result = $this->performAction(self::TYPE_GET, array($issueId));
        $issue = new Issue();
        $issue->populate($result);
        return $issue;
    }

    /**
     * @param $issueId
     * @return array
     */
    public function getChanges($issueId)
    {
        $result = $this->performAction(self::TYPE_GET, array($issueId, 'changes'));
        if (!isset($result['change'])) {
            return null;
        }
        $changeGroups = array();
        foreach ($result['change'] as $changeArray) {
            $issueChangeGroup = new IssueChangeGroup();
            $issueChangeGroup->populate($changeArray);
            $changeGroups[] = $issueChangeGroup;
        }
        return $changeGroups;
    }

    /**
     * @param string $searchStr
     * @param int $max
     * @param int $after
     * @return array
     */
    public function getIssuesBySearch($searchStr, $max = 10, $after = 0/*, $updatedAfter = null*/)
    {
        $queryString = new QueryString();
        $queryString->add('filter', $searchStr);
        $queryString->add('max', $max);
        $queryString->add('after', $after);
//        if (!is_null($updatedAfter)) {
//            $queryString->add('updatedAfter', $updatedAfter);
//        }
        $issuesFound = $this->performAction(self::TYPE_GET, array(), $queryString);
        $issues = array();
        foreach ($issuesFound['issue'] as $issueArray) {
            $issue = new Issue();
            $issue->populate($issueArray);
            $issues[] = $issue;
        }
        return $issues;
    }
}
