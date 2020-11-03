<?php

namespace App\Discord\Commands;

use Discord\Parts\Channel\Message;
use GrahamCampbell\GitHub\Facades\GitHub;

class VersionCommand
{
    /**
     * @var string
     */
    public $command = 'version';

    /**
     * @param  Message  $message
     *
     * @return void
     */
    public function __invoke(Message $message)
    {
        $tags = GitHub::repo()->tags('laravel', 'framework');

        $message->reply($tags[0]['name']);
    }
}
