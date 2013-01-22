<?php
use YouTrackPHP\Action\IssueAction;
use YouTrackPHP\Object\Issue;
use YouTrackPHP\Action\AbstractAction;

class IssueActionTest extends PHPUnit_Framework_TestCase
{
    public function testGetById()
    {
        $issueId = 1337;
        $summary = 'a small test';
        $mockResult = array('id' => $issueId, 'summary' => $summary);
        $expectedIssue = new Issue();
        $expectedIssue->addProperty('id', $issueId);
        $expectedIssue->addProperty('summary', $summary);
        /** @var $issueAction PHPUnit_Framework_MockObject_MockObject */
        $issueAction = $this->getMockBuilder('YouTrackPHP\Action\IssueAction')
            ->disableOriginalConstructor()
            ->setMethods(array('performAction'))
            ->getMock()
        ;
        $issueAction
            ->expects($this->once())
            ->method('performAction')
            ->with(AbstractAction::TYPE_GET, array($issueId))
            ->will($this->returnValue($mockResult))
        ;
        /** @var $issueAction IssueAction */
        $actualIssue = $issueAction->getById($issueId);
        $this->assertEquals($expectedIssue, $actualIssue);
    }
}

