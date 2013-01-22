<?php
namespace YouTrackPHP\Action;

use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\QueryString;

abstract class AbstractAction
{
    const TYPE_GET = 'get';
    const TYPE_POST = 'post';
    const TYPE_DELETE = 'delete';
    const TYPE_PUT = 'put';
    protected static $types = array(self::TYPE_GET, self::TYPE_POST, self::TYPE_DELETE, self::TYPE_PUT);

    const RESPONSE_TYPE_JSON = 'json';
    protected static $responseTypes = array(self::RESPONSE_TYPE_JSON);
    protected $responseType;

    /** @var \Guzzle\Http\Client */
    protected $client;

    /**
     * @param Client $client
     * @param string $responseType
     */
    public function __construct(Client $client, $responseType = self::RESPONSE_TYPE_JSON)
    {
        $this->setClient($client);
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
     * @param string $responseType
     */
    public function setResponseType($responseType)
    {
        $this->responseType = $responseType;
    }

    /**
     * @param array $subUrlDirectories
     * @param QueryString|null $queryString
     * @return string
     */
    public function createRequestURL($subUrlDirectories = array(), QueryString $queryString = null)
    {
        $subUrlDirectories = (array)$subUrlDirectories;
        $url = $this->getObjectUrl();
        if (!empty($subUrlDirectories)) {
            $url .= '/' . implode('/', $subUrlDirectories);
        }
        if ($queryString instanceof QueryString && $queryString->count() > 0) {
            $url .= $queryString->__toString();
        }
        return $url;
    }

    /**
     * @param $type
     * @param array $subUrlDirectories
     * @param QueryString $queryString
     * @return \Guzzle\Http\Message\RequestInterface
     * @throws \Exception
     */
    public function createRequest($type, $subUrlDirectories = array(), QueryString $queryString = null)
    {
        $url = $this->createRequestURL($subUrlDirectories, $queryString);
        switch ($type) {
            case self::TYPE_GET:
                return $this->client->get($url);
            default:
                throw new \Exception('Unknown type: ' . $type);
        }
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

    /**
     * @param string $type
     * @param array $subUrlDirectories
     * @param QueryString $queryString
     * @return mixed
     */
    public function performAction($type, $subUrlDirectories = array(), QueryString $queryString = null)
    {
        $request = $this->createRequest($type, $subUrlDirectories, $queryString);
        $response = $request->send();
        $result = $this->convertResponse($response);
        return $result;
    }
}
