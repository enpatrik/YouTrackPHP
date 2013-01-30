<?php
namespace YouTrackPHP\Action;


use Guzzle\Http\Client;
use YouTrackPHP\Object\ObjectCreator;

class ActionFactory
{
    /** @var \Guzzle\Http\Client */
    protected $client;
    /** @var ObjectCreator */
    protected $objectCreator;

    /**
     * @param Client $client
     * @param ObjectCreator $objectCreator
     */
    public function __construct(Client $client = null, ObjectCreator $objectCreator)
    {
        $this->client = $client;
        $this->objectCreator = $objectCreator;
    }

    /**
     * @param \Guzzle\Http\Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return IssueAction
     */
    public function createIssueAction()
    {
        return new IssueAction($this->client, $this->objectCreator);
    }

    /**
     * @return UserAction
     */
    public function createUserAction()
    {
        return new UserAction($this->client, $this->objectCreator);
    }
}