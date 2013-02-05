<?php
use YouTrackPHP\Object\Standard\Issue;

class IssueTest extends PHPUnit_Framework_TestCase
{
    protected function getDataFromFixture($fixtureFilename)
    {
        $json = file_get_contents(
            dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . $fixtureFilename
        );
        $data = json_decode((string) $json, true);
        return $data;
    }

    protected function getExpectedDataFromFile($expectedFilename)
    {
        $expectedFilePath = dirname(__FILE__)
            . DIRECTORY_SEPARATOR . 'expected'
            . DIRECTORY_SEPARATOR . $expectedFilename
        ;
        /** @noinspection PhpIncludeInspection */
        $data = include $expectedFilePath;
        return $data;
    }

    public function testPopulateFromArrayLarge()
    {
        $mockData = $this->getDataFromFixture('Issue1.json');
        $issue = new Issue();
        $issue->populate($mockData);
        $actualProperties = $issue->getProperties();
        $expectedProperties = $this->getExpectedDataFromFile('Issue1.php');
        $this->assertEquals($expectedProperties, $actualProperties);
    }

    public function testPopulateFromArraySmall()
    {
        $mockData = array(
            'id' => 5,
            'field' => array(
                array('name' => 'summary', 'value' => 'sum summer summary')
            )
        );
        $expectedProperties = array('id' => 5, 'summary' => 'sum summer summary');
        $issue = new Issue();
        $issue->populate($mockData);
        $actualProperties = $issue->getProperties();
        $this->assertEquals($expectedProperties, $actualProperties);
    }
}
