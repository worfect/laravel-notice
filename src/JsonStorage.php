<?php


namespace Worfect\Notice;

class JsonStorage implements Storage
{

    /**
     * Staging message object store.
     *
     * @var \Illuminate\Support\Collection
     */
    public $store;

    /**
     * Create a new json store instance.
     *
     */
    public function __construct()
    {
        $this->store = collect();
    }

    /**
     * Add message object to the store
     *
     * @param $data
     */
    public function add($data)
    {
        $this->store->push($data);
    }

    /**
     * Get messages as json string, if there are any in the store
     *
     */
    public function get(): string
    {
        return ($this->store)->toJson();
    }
}
