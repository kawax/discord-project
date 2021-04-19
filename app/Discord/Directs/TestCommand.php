<?php

namespace App\Discord\Directs;

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
        $message->reply('Hi! '.$message->author->username)
                ->done(function (Message $message) {
                });
    }
}
