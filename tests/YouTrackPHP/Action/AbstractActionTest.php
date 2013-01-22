<?php
use YouTrackPHP\Action\AbstractAction;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\QueryString;
use Guzzle\Http\Client;

class AbstractActionTest extends PHPUnit_Framework_TestCase
{
    public function testCreateRequestURL()
    {
        $expectedUrl = 'some-test/hello/world';
        /** @var $abstractAction PHPUnit_Framework_MockObject_MockObject */
        $abstractAction = $this->getMockBuilder('YouTrackPHP\Action\AbstractAction')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass()
        ;
        $abstractAction
            ->expects($this->once())
            ->method('getObjectUrl')
            ->will($this->returnValue('some-test'))
        ;
        /** @var $abstractAction AbstractAction */
        $actualURL = $abstractAction->createRequestURL(array('hello', 'world'));
        $this->assertEquals($expectedUrl, $actualURL);
    }

    public function testCreateRequestURLWithQueryString()
    {
        $expectedUrl = 'please/give?me=something&pretty=plz';
        /** @var $abstractAction PHPUnit_Framework_MockObject_MockObject */
        $abstractAction = $this->getMockBuilder('YouTrackPHP\Action\AbstractAction')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass()
        ;
        $abstractAction
            ->expects($this->once())
            ->method('getObjectUrl')
            ->will($this->returnValue('please'))
        ;
        $queryString = new QueryString();
        $queryString->add('me', 'something');
        $queryString->add('pretty', 'plz');
        /** @var $abstractAction AbstractAction */
        $actualURL = $abstractAction->createRequestURL(array('give'), $queryString);
        $this->assertEquals($expectedUrl, $actualURL);
    }

    public function testCreateRequestGet()
    {
        $baseUrl = 'http://test';
        $subUrl = 'some/url';
        $client = new Client();
        $client->setBaseUrl($baseUrl);
        /** @var $abstractAction PHPUnit_Framework_MockObject_MockObject */
        $abstractAction = $this->getMockBuilder('YouTrackPHP\Action\AbstractAction')
            ->setConstructorArgs(array($client))
            ->setMethods(array('createRequestURL'))
            ->getMockForAbstractClass()
        ;
        $abstractAction
            ->expects($this->once())
            ->method('createRequestURL')
            ->will($this->returnValue($subUrl))
        ;
        /** @var $abstractAction AbstractAction */
        /** @var $request RequestInterface */
        $request = $abstractAction->createRequest(AbstractAction::TYPE_GET);
        $this->assertEquals(RequestInterface::GET, $request->getMethod());
        $this->assertEquals($baseUrl . '/' . $subUrl, $request->getUrl());
    }
}

