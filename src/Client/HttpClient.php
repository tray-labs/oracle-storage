<?php

namespace TrayLabs\OracleStorage\Client;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use TrayLabs\OracleStorage\Auth\Storage\SessionStorage;

/**
 * Class HttpClient
 *
 * @package TrayLabs\OracleStorage\Client
 */
class HttpClient
{
    /**
     * @var \GuzzleHttp\Client
     */
    static $client;
    
    /**
     * @var \TrayLabs\OracleStorage\Auth\Storage\SessionStorage
     */
    static $storage;
    
    /**
     * @var array
     */
    static $config;
    
    const HEADER_KEY_TOKEN = 'X-Auth-Token';
    const HEADER_KEY_USER = 'X-Storage-User';
    const HEADER_KEY_PASSWORD = 'X-Storage-Pass';
    
    /**
     * Method create a new instance of HttpClient
     *
     * @param array $config
     * @return \GuzzleHttp\Client
     */
    public static function make(array $config): Client
    {
        self::$storage = new SessionStorage();

        if (self::$client != null) {
            return self::$client;
        }

        self::$client = new Client([
            'verify' => false,
            'handler' => self::makeAuthHandler($config),
        ]);

        return self::$client;
    }
    
    /**
     * Method make a stack to setup request login
     *
     * @param array $config
     * @return HandlerStack
     */
    protected static function makeAuthHandler(array $config)
    {
        $stack = new HandlerStack();
        $stack->setHandler(\GuzzleHttp\choose_handler());

        $authCallbackFunction = function (RequestInterface $r) use ($config) {

            $accessData = null;

            if (!$r->getHeader(self::HEADER_KEY_TOKEN)) {
                $accessData = HttpClient::$storage->read();
            }

            if (!$accessData) {
                $c = new Client([
                    'headers' => [
                        self::HEADER_KEY_USER => $config['account']['identifier'] . ':' . $config['user']['username'],
                        self::HEADER_KEY_PASSWORD => $config['user']['password']
                    ]
                ]);

                $response = $c->get($config['account']['auth_uri']);

                HttpClient::$storage->write(
                    $response->getHeader('X-Storage-Url')[0],
                    $response->getHeader('X-Storage-Token')[0]
                );
            }

            $accessData = HttpClient::$storage->read();

            return self::setupClientUri($r, $accessData['uri'])
                ->withHeader(self::HEADER_KEY_TOKEN, $accessData['token']);
        };

        $stack->push(Middleware::mapRequest($authCallbackFunction), 'authenticate');

        return $stack;
    }
    
    /**
     * Method make a dynamic request URL
     *
     * @param RequestInterface $request
     * @param $uri
     * @return RequestInterface
     */
    protected static function setupClientUri(RequestInterface $request, $uri):RequestInterface
    {
        $url = str_replace('https://', '', $uri);
        $urlExploded = explode('/', $url);
        
        $host = $urlExploded[0];
        unset($urlExploded[0]);
        $path = implode('/', $urlExploded) . $request->getUri()->getPath();

        return $request->withUri($request->getUri()->withScheme('https')->withHost($host)->withPath($path));
    }
}