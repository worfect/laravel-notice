<?php


namespace Worfect\Notice;

class HtmlStorage extends BaseStorage
{

    /**
     * Create messages view.
     *
     * @param array $store
     * @return string
     */
    protected function getView(array $store): string
    {
        return view('notice::html', ['messages' => $store])->render();
    }

    /**
     * Create response as a HTML string
     *
     */
    public function createResponse()
    {
        $this->result = $this->getView($this->store);
    }
}
