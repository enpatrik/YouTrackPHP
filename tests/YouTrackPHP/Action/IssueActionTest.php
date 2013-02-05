<?php
use YouTrackPHP\Action\IssueAction;
use YouTrackPHP\Object\ObjectCreator;
use YouTrackPHP\Object\Standard\Issue;

class IssueActionTest extends PHPUnit_Framework_TestCase
{
    public function testGetById()
    {
        $issueId = 'TP-1';
        $expectedProperties = array('id' => 'TP-1', 'summary' => 'Cool', 'description' => 'Stuff!');
        $statusCode = '200';
        $response = new \Guzzle\Http\Message\Response($statusCode);
        $response->setHeader('Content-type', 'application/json');
        $response->setBody(
            '{"id":"TP-1","field":[{"value":"Cool","name":"summary"},{"value":"Stuff!","name":"description"}]}'
        );
        $mockRequest = $this->getMockBuilder('\Guzzle\Http\Message\Request')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $mockRequest
            ->expects($this->once())
            ->method('send')
            ->will($this->returnValue($response))
        ;
        $mockClient = $this->getMockBuilder('\Guzzle\Http\Client')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $mockClient
            ->expects($this->once())
            ->method('get')
            ->with('issue/' . $issueId)
            ->will($this->returnValue($mockRequest))
        ;
        $objectCreator = new ObjectCreator();
        /** @var $mockClient Guzzle\Http\Client */
        $issueAction = new IssueAction($mockClient, $objectCreator);
        /** @var $issueAction IssueAction */
        $actualResult = $issueAction->getById($issueId);
        $actualIssue = $actualResult->asObject();
        $this->assertEquals($expectedProperties, $actualIssue->getProperties());
    }
}

