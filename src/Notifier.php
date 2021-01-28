<?php

namespace Worfect\Notice;



use Exception;

class Notifier
{
    /**
     * The active message.
     *
     * @var Message
     */
    public $message;

    /**
     * The active message store.
     *
     * @var Storage
     */
    public $store;

    /**
     * All added storages
     *
     * @var array
     */
    public $storages = [];

    /**
     * Create a new json store instance.
     *
     */
    public function __construct()
    {
        $this->storages['session'] = new SessionStorage;
        $this->storages['json'] = new JsonStorage;
        $this->storages['html'] = new HtmlStorage;
    }

    /**
     * Add message object to the session store
     *
     */
    public function session()
    {
        $this->store = $this->selectStore('session');
        $this->add();
    }

    /**
     * Add message object to the json store
     * Return all messages added to the store as a json string
     *
     * @return string
     */
    public function json(): string
    {
        $this->store = $this->selectStore('json');
        $this->add();
        return $this->store->get();
    }

    /**
     * Add message object to the html store
     * Return all messages added to the store as a html
     *
     * @return string
     */
    public function html(): string
    {
        $this->store = $this->selectStore('html');
        $this->add();
        return $this->store->get();
    }



    /**
     * Set the message level info.
     *
     * @param $message
     * @return $this
     */
    public function info($message): Notifier
    {
        return $this->message($message, 'info');
    }

    /**
     * Set the message level success.
     *
     * @param $message
     * @return $this
     */
    public function success($message): Notifier
    {
        return $this->message($message, 'success');
    }

    /**
     * Set the message level error.
     *
     * @param $message
     * @return $this
     */
    public function danger($message): Notifier
    {
        return $this->message($message, 'danger');
    }

    /**
     * Set the message level warning.
     *
     * @param $message
     * @return $this
     */
    public function warning($message): Notifier
    {
        return $this->message($message, 'warning');
    }


    /**
     * Make a general message.
     *
     * @param string $message
     * @param string $level
     * @return $this
     * @throws Exception
     */
    protected function message(string $message, string $level): Notifier
    {
        if($message === ""){
//            throw new Exception("Sending a blank notification");

            $message = $level;
        }
        $this->message = new Message(compact('message', 'level'));

        return $this;
    }

    /**
     * Modify the most recently added message.
     *
     * @param  array $overrides
     * @return $this
     */
    protected function updateMessage($overrides = []): Notifier
    {
        $this->message->update($overrides);

        return $this;
    }

    /**
     * Message an overlay modal.
     *
     * @param string $title
     * @return $this
     */
    public function overlay($title = ''): Notifier
    {
        return $this->updateMessage(['title' => $title, 'overlay' => true, 'important' => false]);
    }

    /**
     * Add an "important" property to the message.
     *
     * @return $this
     */
    public function important(): Notifier
    {
        return $this->updateMessage(['important' => true, 'overlay' => false, 'title' => false]);
    }


    /**
     * Add message object to the store
     *
     * @return void
     */
    protected function add()
    {
        if($this->message){
            $this->store->add($this->message);
        }
        $this->clear();
    }

    /**
     * Clear active message.
     *
     * @return void
     */
    protected function clear()
    {
        $this->message = false;
    }

    /**
     * Select storage.
     *
     * @param $name
     * @return Storage
     */
    protected function selectStore(string $name) : Storage
    {
        return $this->storages[$name];
    }
}
