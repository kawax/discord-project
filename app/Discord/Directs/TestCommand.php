<?php

namespace App\Discord\Directs;

use CharlotteDunois\Yasmin\Models\Message;

class TestCommand
{
    /**
     * @var string
     */
    public $command = 'test';

    /**
     * @param Message $message
     *
     * @return string
     */
    public function __invoke(Message $message)
    {
        return 'Hi! ' . $message->author->username;
    }
}
