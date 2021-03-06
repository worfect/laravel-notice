<?php

namespace Worfect\Notice;

class SessionStorage extends BaseStorage
{
    /**
     * Create a new session store instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
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
}
