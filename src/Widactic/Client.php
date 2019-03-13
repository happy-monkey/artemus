<?php

namespace Widactic;


use Psr\Http\Message\ResponseInterface;

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
    private $endpoint = "https://secure.widactic.com/api/external/";

    /**
     * @var int
     */
    private $bulk_chunk_size = 100;

    /**
     * @var int
     */
    private $bulk_sleep = 1;

    /**
     * @var string|null
     */
    private $last_error = false;

    /**
     * Init default client with key and secret provided
     *
     * @param string $key Application key
     * @param string $secret Client secret provided in your API console
     */
    public static function init( $key, $secret, $url=null )
    {
        self::$defaultClient = new Client($key, $secret, $url);
    }

    protected function __construct( $key, $secret, $url=null )
    {
        $this->m_key = $key;
        $this->m_secret = $secret;

        if( !is_null($url) )
        {
            $this->endpoint = $url;
        }

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

    private function isValidStatusCode( ResponseInterface $req )
    {
        return in_array($req->getStatusCode(), [200, 201]);
    }

    /**
     * Load an API Object in first argument
     *
     * @param Entry $entry Object to load
     * @param int $id Id of object to load
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

                self::$defaultClient->last_error = $exception->getMessage();
            }
        }

        return false;
    }

    /**
     * Save an object over API. If object does not exist, it will be created
     *
     * @param Entry $entry Object to save
     * @return bool Return true if object has been saved
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

                self::$defaultClient->last_error = $exception->getMessage();
            }
        }

        return false;
    }

    /**
     * Create or update an object over API
     *
     * @param Entry $entry Object to check
     * @param string $fieldName Name of the field to use for check if object exists
     * @return bool Return true if object has been created or updated
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

                self::$defaultClient->last_error = $exception->getMessage();
            }
        }

        return false;
    }

    /**
     * Fetch all objects in the collection in argument
     *
     * @param EntryCollection $collection Collection to fetch
     * @param array $params
     * @return bool Return true if objects are stored in collection
     */
    public static function fetch( &$collection, $params=[] )
    {
        $route = $collection->_getEndpoint();

        if( !is_null($route) )
        {
            try {

                if( count($params)>0 )
                {
                    $route .= "?".http_build_query($params);
                }

                $entryType = $collection->_getEntryType();
                $req = self::$defaultClient->m_client->get($route);
                $entries = $entryType::fromArray(json_decode($req->getBody()));
                $collection->setEntries($entries);
                return true;

            } catch ( \Exception $exception ) {

                self::$defaultClient->last_error = $exception->getMessage();
            }
        }

        return false;
    }

    /**
     * Sync a collection of object
     *
     * @param EntryCollection $collection Collection to sync
     * @param string $fieldName Name of the field to use for check if object exists
     * @return bool Return true if objects are synced
     */
    public static function bulk_sync( &$collection, $fieldName )
    {
        $route = $collection->_getEndpoint();

        if( !is_null($route) )
        {
            try {

                $entryType = $collection->_getEntryType();
                $array = $collection->getEntries();
                $chunked = array_chunk($array, self::$defaultClient->bulk_chunk_size);

                $updatedEntries = [];

                foreach( $chunked as $entries )
                {
                    $data = json_encode($entries);
                    $req = self::$defaultClient->m_client->put("bulk/".$route."/".$fieldName, [
                        "body" => $data
                    ]);

                    $updatedEntries = array_merge(
                        $updatedEntries,
                        $entryType::fromArray(json_decode($req->getBody())->success)
                    );

                    sleep(self::$defaultClient->bulk_sleep);
                }

                $collection->setEntries($updatedEntries);

                return true;

            } catch ( \Exception $exception ) {

                self::$defaultClient->last_error = $exception->getMessage();
            }
        }

        return false;
    }

    public static function getLastError()
    {
        return self::$defaultClient->last_error;
    }
}