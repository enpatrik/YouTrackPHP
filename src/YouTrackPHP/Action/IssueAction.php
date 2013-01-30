<?php
namespace YouTrackPHP\Action;

use YouTrackPHP\Object\IssueObject;
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
     * @return IssueObject
     */
    public function getById($issueId)
    {
        $url = $this->createRequestURL(array($issueId));
        $response = $this->client->get($url)->send();
        $result = $this->convertResponse($response);
        $issue = $this->objectCreator->createIssue();
        $issue->populate($result);
        return $issue;
    }

    /**
     * @param $issueId
     * @return IssueChangeGroup[]
     */
    public function getChanges($issueId)
    {
        $url = $this->createRequestURL(array($issueId, 'changes'));
        $response = $this->client->get($url)->send();
        $result = $this->convertResponse($response);
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
     * @param string $projectId
     * @param string $searchStr
     * @param int $max
     * @param int $after
     * @param null|int $updatedAfter
     * @return IssueObject[]
     */
    public function getIssuesByProjectSearch($projectId, $searchStr, $max = 10, $after = 0, $updatedAfter = null)
    {
        $queryString = new QueryString();
        $queryString->add('filter', $searchStr);
        $queryString->add('max', $max);
        $queryString->add('after', $after);
        if (!is_null($updatedAfter)) {
            $queryString->add('updatedAfter', $updatedAfter);
        }
        $url = $this->createRequestURL(array('byproject', $projectId), $queryString);
        $response = $this->client->get($url)->send();
        $result = $this->convertResponse($response);
        $issues = array();
        foreach ($result as $issueArray) {
            $issue = $this->objectCreator->createIssue();
            $issue->populate($issueArray);
            $issues[] = $issue;
        }
        return $issues;
    }
}
