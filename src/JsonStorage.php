<?php


namespace Worfect\Notice;

class JsonStorage extends BaseStorage
{
    /**
     * Create response as a JSON string
     *
     */
    public function createResponse()
    {
        $this->result = json_encode($this->store);
    }
}
