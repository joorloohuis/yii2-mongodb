<?php

namespace joorloohuis\mongodb\components;

use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use MongoDB\Client;
use MongoDB\Driver\Exception\ConnectionTimeoutException;

/**
 * MongoClient
 *
 * Exposes official MongoDB support as provided by mongodb.org.
 * This component provides a MongoDB\Client object, and as such
 * may be used exactly as documented in
 * https://docs.mongodb.com/php-library/v1.3/reference/
 *
 * The reason behind the existence of this class is that the standard
 * Yii2 component caters to the AR approach, and this shields a lot
 * of the powerful core functionality provided by the MongoDB PHP Library
 * provided by mongodb.org.
 *
 * This component requires the newer mongodb PHP extension, the old mongo
 * PHP extension is untested and unsupported.
 *
 * TODO:
 * * add more configuration parameters
 * * add support for alternative authentication database support
 */
class MongoClient extends BaseObject
{
    /**
     * DSN for connecting with MongoDB
     *
     * @var string
     */
    public $dsn;

    /**
     * host
     *
     * @var string
     */
    public $host = 'localhost';

    /**
     * port
     *
     * @var integer
     */
    public $port = 27017;

    /**
     * database name
     *
     * @var string
     */
    public $db;

    /**
     * database user
     *
     * @var string
     */
    public $user;

    /**
     * database password
     *
     * @var string
     */
    public $password;

    /**
     * connection arguments
     *
     * @var string
     */
    public $args = '';

    /**
     * Connected database
     *
     * @var MongoDB\Database
     */
    public $database;

    /**
     * MongoDB client
     *
     * @var MongoDB\Client
     */
    protected $client;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
        $this->connect();
    }

    protected function connect()
    {
        if ($this->dsn) {
            $this->db = preg_replace('/(.*\/|\?.*)/', '', $this->dsn);
        } else {
            $this->dsn = sprintf("mongodb://%s:%s@%s:%s/%s",
                $this->user,
                $this->password,
                $this->host,
                $this->port,
                $this->db
            );
            if ($this->args) {
                $this->dsn .= '?' . $args;
            }
        }
        $this->client = new Client($this->dsn);
        $this->database = $this->client->selectDatabase($this->db);
    }

    // funnel any call to an unknown method to the MongoDB client if that provides it
    public function __call($method, $args)
    {
        if (method_exists($this->client, $method)) {
            return call_user_func_array([$this->client, $method], $args);
        }
        throw new BadMethodCallException(\MongoDB\Client::class . ' does not implement ' . $method);
    }

}
