<?php


namespace YouTrackPHP\Action\Result;


use Guzzle\Http\Message\Response;
use YouTrackPHP\Object\ObjectCreator;
use YouTrackPHP\Object\YouTrackObject;

abstract class AbstractActionResult implements ActionResult {
    /** @var Response */
    protected $response;
    /** @var \YouTrackPHP\Object\ObjectCreator */
    protected $objectCreator;
    /** @var bool */
    protected $multipleObjects = false;

    /**
     * @param Response $response
     * @param ObjectCreator $objectCreator
     * @param bool $multipleObjects
     */
    public function __construct(Response $response, ObjectCreator $objectCreator, $multipleObjects = false)
    {
        $this->response = $response;
        $this->objectCreator = $objectCreator;
        $this->multipleObjects = $multipleObjects;
    }

    /**
     * @return string
     */
    public function asRaw()
    {
        return (string) $this->response->getBody();
    }

    /**
     * @return \SimpleXMLElement
     */
    public function asXml()
    {
        return $this->response->xml();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function asArray()
    {
        if ($this->response->isContentType('application/json')) {
            return $this->response->json();
        } else {
            throw new \Exception('To be implemented');
        }
    }

    /**
     * @return bool
     */
    public function isMultipleObjects()
    {
        return $this->multipleObjects;
    }

    /**
     * @return YouTrackObject|YouTrackObject[]|null
     */
    public function asObject()
    {
        if ($this->isMultipleObjects()) {
            return $this->asObjectCollection();
        }
        return $this->createObjectFromArray($this->asArray());
    }

    /**
     * @param array $arr
     * @return YouTrackObject|null
     */
    protected abstract function createObjectFromArray(array $arr);

    /**
     * @return YouTrackObject[]
     */
    public function asObjectCollection()
    {
        $objects = array();
        foreach ($this->asArray() as $arr) {
            $objects[] = $this->createObjectFromArray($arr);
        }
        return $objects;
    }
}