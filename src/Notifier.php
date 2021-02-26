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
    protected $message;


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
     * Get all messages from storage.
     *
     * @param Storage $storage
     * @return mixed
     */
    protected function getAllMessages(Storage $storage)
    {
        $this->addMessageInStore($storage);
        return $this->getAllMessagesFromStore($storage);
    }

    /**
     * Add message to storage.
     *
     * @param Storage $storage
     */
    protected function addMessageInStore(Storage $storage)
    {
        if($this->message){
            $storage->add($this->message);
        }
        $this->delActiveMessage();
    }

    /**
     * Get message from storage.
     *
     * @param Storage $storage
     */
    protected function getAllMessagesFromStore(Storage $storage)
    {
        return $storage->get();
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
     * Clear active message.
     *
     * @return void
     */
    protected function delActiveMessage()
    {
        $this->message = false;
    }

    /**
     * UI methods for interacting with storage
     *
     */

    public function session()
    {
        $this->getAllMessages(SessionStorage::getInstance());
    }

    public function json()
    {
        return $this->getAllMessages(JsonStorage::getInstance());
    }

    public function html()
    {
        return $this->getAllMessages(HtmlStorage::getInstance());
    }

}
