<?php

namespace App\Discord\Commands;

use Discord\Parts\Channel\Message;

class TestCommand
{
    /**
     * @var string
     */
    public $command = 'test';

    /**
     * @param  Message  $message
     *
     * @return void
     * @throws \Exception
     */
    public function __invoke(Message $message)
    {
        $message->reply('test command')
                ->done(function (Message $message) {
                });
    }
}
