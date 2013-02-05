<?php
namespace YouTrackPHP\Action;

use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;
use Guzzle\Http\QueryString;
use YouTrackPHP\Object\ObjectCreator;

abstract class AbstractAction
{
    /** @var Client */
    protected $client;
    /** @var ObjectCreator */
    protected $objectCreator;

    /**
     * @param Client $client
     * @param ObjectCreator $objectCreator
     */
    public function __construct(Client $client, ObjectCreator $objectCreator)
    {
        $this->setClient($client);
        $this->setObjectCreator($objectCreator);
    }

    /**
     * @abstract
     * @return string
     */
    protected abstract function getObjectUrl();

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param ObjectCreator $objectCreator
     */
    public function setObjectCreator(ObjectCreator $objectCreator)
    {
        $this->objectCreator = $objectCreator;
    }

    /**
     * @param array $subUrlDirectories
     * @param QueryString|null $getParams
     * @return string
     */
    public function createRequestURL($subUrlDirectories = array(), QueryString $getParams = null)
    {
        $subUrlDirectories = (array)$subUrlDirectories;
        $url = $this->getObjectUrl();
        if (!empty($subUrlDirectories)) {
            $url .= '/' . implode('/', $subUrlDirectories);
        }
        if ($getParams instanceof QueryString && $getParams->count() > 0) {
            $url .= $getParams->__toString();
        }
        return $url;
    }
}
