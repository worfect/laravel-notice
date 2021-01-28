<?php

namespace Worfect\Notice;



class SessionStorage implements Storage
{
    /**
     * Staging message object store.
     *
     * @var \Illuminate\Support\Collection
     */
    public $store;

    /**
     * Create a new session store instance.
     *
     */
    public function __construct()
    {
        $this->store = collect();
    }

    /**
     * Add message object to the session
     *
     * @param $data
     */
    public function add($data)
    {
        $this->store->push($data);

        $this->update();
    }

    /**
     * Updating the content of the session
     *
     */
    protected function update()
    {
        \session()->flash('notice', $this->store);
    }


    public function get()
    {
        // TODO: Implement get() method.
    }
}
