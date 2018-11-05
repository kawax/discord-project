<?php

namespace App\Discord\Commands;

use CharlotteDunois\Yasmin\Models\Message;

class TestCommand
{
    public $command = 'test';

    /**
     * @param Message $message
     *
     * @return string
     */
    public function __invoke(Message $message)
    {
        return 'test command';
    }
}
