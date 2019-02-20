<?php

namespace Artemus;


class Client
{
    /**
     * @var Client
     */
    private static $defaultClient = null;

    /**
     * @var string
     */
    private $m_key;

    /**
     * @var string
     */
    private $m_secret;

    /**
     * @var \GuzzleHttp\Client
     */
    private $m_client;

    /**
     * @var string
     */
    private $endpoint = "https://artemus.mkey.pw/api/external/";


    public static function init( $key, $secret )
    {
        self::$defaultClient = new Client($key, $secret);
    }

    protected function __construct( $key, $secret )
    {
        $this->m_key = $key;
        $this->m_secret = $secret;

        $this->m_client = new \GuzzleHttp\Client([
            'base_uri' => $this->endpoint,
            'headers' => [
                'Authorization' => $this->getAuthorization(),
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    private function getAuthorization()
    {
        return "Basic ".base64_encode($this->m_key.":".$this->m_secret);
    }

    /**
     * @param Entry $entry
     * @param int $id
     * @return bool
     */
    public static function get( &$entry, $id )
    {
        $route = $entry::$API_ENDPOINT;

        if( !is_null($route) )
        {
            try {

                $req = self::$defaultClient->m_client->get($route."/".$id);
                $entry->loadJSON(json_decode($req->getBody()));

                return true;

            } catch ( \Exception $exception ) {

            }
        }

        return false;
    }

    /**
     * @param Entry $entry
     * @return bool
     */
    public static function save( &$entry )
    {
        $route = $entry::$API_ENDPOINT;
        $data = json_encode($entry);

        if( !is_null($route) )
        {
            if( $id = $entry->getId() )
            {
                $method = "PATCH";
                $route .= "/".$id;
            }
            else
            {
                $method = "POST";
            }

            try {

                $req = self::$defaultClient->m_client->request($method, $route, [
                    'body' => $data
                ]);
                $entry->loadJSON(json_decode($req->getBody()));

                return true;

            } catch ( \Exception $exception ){

            }
        }

        return false;
    }

    /**
     * @param Entry $entry
     * @param string $fieldName
     * @return bool
     */
    public static function sync( &$entry, $fieldName )
    {
        $route = $entry::$API_ENDPOINT;
        $data = json_encode($entry);

        if( !is_null($route) )
        {
            try {

                $req = self::$defaultClient->m_client->put($route."/".$fieldName, [
                    "body" => $data
                ]);
                $entry->loadJSON(json_decode($req->getBody()));

                return true;

            } catch ( \Exception $exception ) {

            }
        }

        return false;
    }

    public static function fetch( $className, $query="" )
    {
        $className = __NAMESPACE__."\\".$className;

        if( class_exists($className) )
        {
            $route = $className::$API_ENDPOINT;

            if( !is_null($route) )
            {
                try {

                    $req = self::$defaultClient->m_client->get($route."/".$query);
                    return $className::fromArray(json_decode($req->getBody()));

                } catch ( \Exception $exception ) {

                }
            }
        }

        return [];
    }

    /**
     * @param string $endpoint
     * @param Entry[] $entries
     * @param string $fieldName
     * @return Entry[]
     */
    public static function bulk_sync( $className, $entries, $fieldName )
    {
        $className = __NAMESPACE__."\\".$className;

        if( class_exists($className) )
        {
            $route = $className::$API_ENDPOINT;
            $data = json_encode($entries);

            if( !is_null($route) )
            {
                try {

                    $req = self::$defaultClient->m_client->put("bulk/".$route."/".$fieldName, [
                        "body" => $data
                    ]);
                    return $className::fromArray(json_decode($req->getBody())->success);

                } catch ( \Exception $exception ) {

                }
            }
        }

        return [];
    }
}