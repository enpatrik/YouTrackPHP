<?php
namespace YouTrackPHP\Action;

use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;
use Guzzle\Http\QueryString;
use YouTrackPHP\Object\ObjectCreator;

abstract class AbstractAction
{
    const RESPONSE_TYPE_JSON = 'json';
    /** @var array */
    protected static $responseTypes = array(self::RESPONSE_TYPE_JSON);
    /** @var string */
    protected $responseType;
    /** @var Client */
    protected $client;
    /** @var ObjectCreator */
    protected $objectCreator;

    /**
     * @param Client $client
     * @param ObjectCreator $objectCreator
     * @param string $responseType
     */
    public function __construct(Client $client, ObjectCreator $objectCreator, $responseType = self::RESPONSE_TYPE_JSON)
    {
        $this->setClient($client);
        $this->setObjectCreator($objectCreator);
        $this->setResponseType(self::RESPONSE_TYPE_JSON);
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
     * @param string $responseType
     */
    public function setResponseType($responseType)
    {
        $this->responseType = $responseType;
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

    /**
     * @param Response $response
     * @return mixed
     * @throws \Exception
     */
    public function convertResponse(Response $response)
    {
        switch ($this->responseType) {
            case self::RESPONSE_TYPE_JSON:
                return $response->json();
            default:
                throw new \Exception('Unknown response type: ' . $this->responseType);
        }
    }

//    /**
//     * @param array $subUrlDirectories
//     * @param QueryString $getParams
//     * @return mixed
//     */
//    public function sendGet($subUrlDirectories = array(), QueryString $getParams = null)
//    {
//        $url = $this->createRequestURL($subUrlDirectories, $getParams);
//        $request = $this->client->get($url);
//        $response = $request->send();
//        $result = $this->convertResponse($response);
//        return $result;
//    }
//
//    /**
//     * @param array $subUrlDirectories
//     * @param QueryString $getParams
//     * @param QueryString $postParams
//     * @internal param array $postArray
//     * @return mixed
//     */
//    public function sendPost($subUrlDirectories = array(), QueryString $getParams = null, QueryString $postParams = null)
//    {
//        $url = $this->createRequestURL($subUrlDirectories, $getParams);
//        $request = $this->client->post($url);
//        $request->addPostFields($postParams);
//        $response = $request->send();
//        $result = $this->convertResponse($response);
//        return $result;
//    }
}
