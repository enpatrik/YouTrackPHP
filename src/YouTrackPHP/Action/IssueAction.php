<?php
namespace YouTrackPHP\Action;

use Guzzle\Http\QueryString;
use YouTrackPHP\Action\AbstractAction;
use YouTrackPHP\Action\Result\IssueResult;
use YouTrackPHP\Action\Result\IssueChangeResult;
use YouTrackPHP\Action\Result\ActionResult;

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
     * @return ActionResult
     */
    public function getById($issueId)
    {
        $url = $this->createRequestURL(array($issueId));
        $response = $this->client->get($url)->send();
        return new IssueResult($response, $this->objectCreator);
    }

    /**
     * @param $issueId
     * @return ActionResult
     */
    public function getChanges($issueId)
    {
        $url = $this->createRequestURL(array($issueId, 'changes'));
        $response = $this->client->get($url)->send();
        $multipleObjects = true;
        return new IssueChangeResult($response, $this->objectCreator, $multipleObjects);
    }

    /**
     * @param string $projectId
     * @param string $searchStr
     * @param int $max
     * @param int $after
     * @param null|int $updatedAfter
     * @return ActionResult
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
        $multipleObjects = true;
        return new IssueResult($response, $this->objectCreator, $multipleObjects);
    }
}
