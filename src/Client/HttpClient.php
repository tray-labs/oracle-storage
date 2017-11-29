<?php

namespace TrayLabs\OracleStorage\Client;

use Guzzle\Http\Message\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Log;
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
    const CONNECT_TIMEOUT = 8;

    public static $failedOnce = false;
    
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
            'verify'  => false,
            'connect_timeout' => self::CONNECT_TIMEOUT,
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

            if (!$accessData || self::$failedOnce) {
                $c = new Client([
                    'headers' => [
                        self::HEADER_KEY_USER => $config['account']['identifier'] . ':' . $config['user']['username'],
                        self::HEADER_KEY_PASSWORD => $config['user']['password']
                    ]
                ]);

                $response = $c->get($config['account']['auth_uri']);

                $accessData = HttpClient::$storage->write(
                    $response->getHeader('X-Storage-Url')[0],
                    $response->getHeader('X-Storage-Token')[0]
                );
            }

            return self::setupClientUri($r, $accessData['uri'])
                ->withHeader(self::HEADER_KEY_TOKEN, $accessData['token']);
        };

        $stack->push(Middleware::retry(self::retryRequest()));
        $stack->push(Middleware::mapRequest($authCallbackFunction), 'authenticate');

        return $stack;
    }

    protected static function retryRequest()
    {
        return function($retries, $request, $response = null, RequestException $requestException = null) {
            if ($retries === 1) {
                return false;
            }

            if ($response && $response->getStatusCode() === 401) {
                HttpClient::$failedOnce= true;
                return true;
            }

            return false;
        };
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
