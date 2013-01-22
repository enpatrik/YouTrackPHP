<?php
namespace YouTrackPHP\Object;

class IssueChangeGroup extends AbstractObject
{
    const UPDATER_NAME = 'updaterName';
    const UPDATED = 'updated';
    const COMMENTS = 'comments';
    const CHANGES = 'changes';

    /** @var array */
    protected $changes;

    /**
     * @param array $arr
     */
    public function populateFromArray(array $arr)
    {
        foreach ($arr as $name => $value) {
            if ($name === 'field') {
                $this->populateFromArray($value);
            } elseif (isset($value['newValue'])) {
                $issueChange = new IssueChange();
                $issueChange->populateFromArray($value);
                $this->addChange($issueChange);
            } elseif (isset($value['name']) && isset($value['value'])) {
                $this->addProperty($value['name'], $value['value']);
            } else {
                $this->addProperty($name, $value);
            }
        }
    }

    /**
     * @param IssueChange $issueChange
     */
    public function addChange(IssueChange $issueChange)
    {
        $this->changes[] = $issueChange;
    }

    /**
     * @return array
     */
    public function getChanges()
    {
        return $this->changes;
    }
}
