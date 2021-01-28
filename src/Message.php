<?php


namespace Worfect\Notice;


class Message implements \ArrayAccess
{
    /**
     * The title of the message.
     *
     * @var string
     */
    public $title = '';

    /**
     * The body of the message.
     *
     * @var string
     */
    public $message = '';

    /**
     * Whether the message is an overlay.
     *
     * @var bool
     */
    public $overlay = false;

    /**
     * Whether the message should auto-hide.
     *
     * @var bool
     */
    public $important = false;

    /**
     * The message level.
     *
     * @var string
     */
    public $level = 'info';



    /**
     * Create a new message instance.
     *
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        $this->update($attributes);
    }

    /**
     * Update the attributes.
     *
     * @param  array $attributes
     */
    public function update($attributes = [])
    {
        foreach ($attributes as $key => $attribute) {
            $this->$key = $attribute;
        }
    }



    /**
     * Whether the given offset exists.
     *
     * @param  mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    /**
     * Fetch the offset.
     *
     * @param  mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    /**
     * Assign the offset.
     *
     * @param mixed $offset
     * @param $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    /**
     * Unset the offset.
     *
     * @param  mixed $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }
}
