<?php


namespace Worfect\Notice;

class HtmlStorage implements Storage
{

    /**
     * The message object store.
     *
     * @var array
     */
    public $store = [];

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
     * Add message object to the store
     *
     * @param  $data
     */
    public function add($data)
    {
       $this->store[] = $data;
    }

    /**
     * Get generated message template
     *
     */
    public function get(): string
    {
        return $this->getView($this->store);
    }
}
