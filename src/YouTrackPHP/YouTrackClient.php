<?php
namespace YouTrackPHP;

use Guzzle\Http\Client;
use YouTrackPHP\Action\ActionFactory;
use Zend\Config\Reader\Yaml;
use Zend\Di\Config;
use Zend\Di\Di;

class YouTrackClient
{
    /** @var null|Di */
    protected $di;

    /**
     * @param null|Di $di
     * @param null $configurationFile
     */
    public function __construct($di = null, $configurationFile = null)
    {
        $this->di = $di ? $di : new Di();
        if (!$configurationFile) {
            $configurationFile = dirname(__FILE__) . DIRECTORY_SEPARATOR
                . 'config' . DIRECTORY_SEPARATOR . 'youtrack.yml'
            ;
        }
        $this->setConfigurationFromFile($configurationFile);
    }

    /**
     * @param string $file
     */
    public function setConfigurationFromFile($file)
    {
        $yamlConfigReader = new Yaml(array('Spyc', 'YAMLLoadString'));
        $options = $yamlConfigReader->fromFile($file);
        $this->di->configure(new Config($options));
    }

    /**
     * @return ActionFactory
     */
    public function getActionFactory()
    {
        return $this->di->get('ActionFactory');
    }

    /**
     * @param string $username
     * @param string $password
     */
    public function login($username, $password)
    {
        $this->getActionFactory()->createUserAction()->login($username, $password);
    }
}
