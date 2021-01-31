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
     * Get generated message template
     *
     * @return string
     */
    public function get(): string
    {
        return $this->getView($this->store);
    }
}
