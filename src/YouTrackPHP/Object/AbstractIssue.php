<?php
namespace YouTrackPHP\Object;

abstract class AbstractIssue extends AbstractObject implements IssueObject
{
    const ID = 'id';                                  //Issue id in database
    const JIRA_ID = 'jiraId';	                        //If issue was imported from Jira, represents id, that it have in Jira
    const PROJECT_SHORT_NAME = 'projectShortName';	//Short name of the issue's project
    const NUMBER_IN_PROJECT = 'numberInProject';	    //Number of issue in project
    const SUMMARY = 'summary';	                    //Summary of the issue
    const DESCRIPTION = 'description';	            //Description of the issue
    const CREATED = 'created';	                    //Time when issue was created (the number of milliseconds since January 1, 1970, 00:00:00 GMT represented by this date).
    const UPDATED = 'updated';	                    //Time when issue was last updated (the number of milliseconds since January 1, 1970, 00:00:00 GMT represented by this date).
    const UPDATER_NAME = 'updaterName';	            //Login of the user, that was the last, who updated the issue
    const RESOLVED = 'resolved';	                    //If the issue is resolved, shows time, when resolved state was last set to the issue (the number of milliseconds since January 1, 1970, 00:00:00 GMT represented by this date).
    const REPORTER_NAME = 'reporterName';	            //Login of user, who created the issue
    const VOTER_NAME = 'voterName';	                //Login of user, that voted for issue
    const COMMENTS_COUNT = 'commentsCount';	        //Number of comments in issue
    const VOTES = 'votes';	                        //Number of votes for issue
    const PERMITTED_GROUP = 'permittedGroup';	        //User group, that has permission to read this issue; if group is not set, it means that any user has access to this issue
    const COMMENTS = 'comments';	                    //Represents issue comment (see Get comments of an issue)
    const TAG = 'tag';	                            //Tags, accessible to logged in user
    const STATE = 'State';
    const ASSIGNEE = 'Assignee';
    const FIX_VERSIONS = 'Fix Versions';
    const PRIORITY = 'Priority';
    const SUBSYSTEM = 'Subsystem';
    const UPDATER_FULL_NAME = 'updaterFullName';
    const REPORTER_FULL_NAME = 'reporterFullName';
    const TYPE = 'Type';
    const ATTACHMENTS = 'attachments';
    const LINKS = 'links';

    /**
     * @param array $arr
     */
    public function populateFromArray(array $arr)
    {
        foreach ($arr as $name => $value) {
            if ($name === 'field') {
                foreach ((array)$value as $fieldArray) {
                    if (isset($fieldArray['name'])) {
                        $fieldName = $fieldArray['name'];
                        $fieldValue = isset($fieldArray['value']) ? $fieldArray['value'] : null;
                        $this->addProperty($fieldName, $fieldValue);
                    }
                }
            } else {
                $this->addProperty($name, $value);
            }
        }
    }

    public function getId()
    {
        return $this->getProperty(self::ID);
    }

    public function getCreated()
    {
        return $this->getProperty(self::CREATED);
    }

    public function getUpdated()
    {
        return $this->getProperty(self::UPDATED);
    }
}
