<?php

namespace Worfect\Notice;

abstract class BaseStorage implements Storage
{
    /**
     * The message object store.
     *
     * @var array
     */
    public $store = [];

    /**
     * Generated response.
     *
     * @var array
     */
    public $result;

    /**
     * Contains instances of all created stores.
     *
     * @var array
     */
    private static $instances = [];


    /**
     * Further, just a classic Singleton.
     *
     */
    protected function __construct() { }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): BaseStorage
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }
        return self::$instances[$cls];
    }


    /**
     * Add message object to the store
     *
     * @param $data
     */
    public function add($data)
    {
        $this->store[] = $data;
    }

    /**
     * Get data from storage
     *
     */
    public function get()
    {
        $this->createResponse();
        return $this->result;
    }

    /**
     * Create response
     */
    public function createResponse()
    {

    }
}
