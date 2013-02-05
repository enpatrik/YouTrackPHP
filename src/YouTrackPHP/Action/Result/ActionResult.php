<?php


namespace YouTrackPHP\Action\Result;


use YouTrackPHP\Object\YouTrackObject;

interface ActionResult {
    /**
     * @return string
     */
    public function asRaw();

    /**
     * @return \SimpleXMLElement
     */
    public function asXml();

    /**
     * @return array
     */
    public function asArray();

    /**
     * @return YouTrackObject|YouTrackObject[]|null
     */
    public function asObject();

    /**
     * @return YouTrackObject[]
     */
    public function asObjectCollection();
}