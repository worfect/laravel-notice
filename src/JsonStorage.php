<?php


namespace Worfect\Notice;

class JsonStorage extends BaseStorage
{
    /**
     * Get messages as json string
     *
     * @return string
     */
    public function get() :string
    {
        return json_encode($this->store);
    }
}
