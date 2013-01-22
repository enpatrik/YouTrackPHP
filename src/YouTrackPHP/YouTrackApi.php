<?php
namespace YouTrackPHP;

use Guzzle\Http\Client;

class YouTrackApi
{
    /** @var string */
    protected $baseUrl;
    /** @var string */
    protected $username;
    /** @var string */
    protected $password;

    /**
     * @param string $baseUrl
     * @param string $username
     * @param string $password
     */
    public function __construct($baseUrl, $username, $password)
    {
        $this->baseUrl = $baseUrl;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return \Guzzle\Http\Client
     */
    public function createClient()
    {
        $client = new Client($this->baseUrl);
        $loginResponse = $this->login($client);
        $client = $this->saveLoginCookie($client, $loginResponse);
        $client->setDefaultHeaders(array('Accept'=>'application/json'));
        return $client;
    }

    /**
     * @param Client $client
     * @return \Guzzle\Http\Message\Response
     */
    protected function login(Client $client)
    {
        /** @var $request \Guzzle\Http\Message\EntityEnclosingRequest */
        $request = $client->post('user/login');
        $request->addPostFields(array('login'=>$this->username, 'password'=>$this->password));
        /** @var $response \Guzzle\Http\Message\Response */
        $response = $request->send();
        return $response;
    }

    /**
     * @param Client $client
     * @param $loginResponse
     * @return \Guzzle\Http\Client
     */
    protected function saveLoginCookie(Client $client, $loginResponse)
    {
        $cookieJar = new \Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar();
        $cookieJar->addCookiesFromResponse($loginResponse);
        $client->addSubscriber(new \Guzzle\Plugin\Cookie\CookiePlugin($cookieJar));
        return $client;
    }
}
