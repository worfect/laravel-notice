<?php

use Worfect\Notice\Notifier;

if (! function_exists('notice')) {

    /**
     * Arrange for a notice.
     *
     * @param string|null $message
     * @param string $level
     * @return Notifier
     */
    function notice(string $message = null, $level = 'info')
    {
        $notifier = app('notice');

        if (is_null($message)) {
            return $notifier;
        }
        return $notifier->$level($message)->session();
    }
}
