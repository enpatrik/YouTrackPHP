<?php
namespace YouTrackPHP\Action;

use Guzzle\Http\Message\Response;

class UserAction extends AbstractAction
{
    /**
     * @return string
     */
    protected function getObjectUrl()
    {
        return 'user';
    }
}
