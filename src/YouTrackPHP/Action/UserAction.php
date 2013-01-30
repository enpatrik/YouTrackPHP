<?php
namespace YouTrackPHP\Action;

use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;
use Guzzle\Http\QueryString;
use Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar;
use Guzzle\Plugin\Cookie\CookiePlugin;

class UserAction extends AbstractAction
{
    /**
     * @return string
     */
    protected function getObjectUrl()
    {
        return 'user';
    }

    /**
     * @param string$username
     * @param string $password
     */
    public function login($username, $password)
    {
        $url = $this->createRequestURL(array('login'));
        $headers = array('Content-Type', 'application/x-www-form-urlencoded');
        $request = $this->client->post($url, $headers);
        $postParams = new QueryString();
        $postParams->add('login', $username);
        $postParams->add('password', $password);
        $request->addPostFields($postParams);
        $loginResponse = $request->send();
        $this->saveLoginCookie($this->client, $loginResponse);
    }

    /**
     * @param Client $client
     * @param $loginResponse
     * @return Client
     */
    protected function saveLoginCookie(Client $client, $loginResponse)
    {
        $cookieJar = new ArrayCookieJar();
        $cookieJar->addCookiesFromResponse($loginResponse);
        $client->addSubscriber(new CookiePlugin($cookieJar));
    }
}
