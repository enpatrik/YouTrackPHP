YouTrackPHP
===========
Not fully working.
Very much work in progress!!!

Usage example:
$youTrackClient = new YouTrackClient();
$youTrackClient->login('username', 'password');
$issue = $youTrackClient->getActionFactory()->createIssueAction()->getById('TP-1')->asObject();
