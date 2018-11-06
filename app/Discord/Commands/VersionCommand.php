<?php

namespace App\Discord\Commands;

use CharlotteDunois\Yasmin\Models\Message;
use GrahamCampbell\GitHub\Facades\GitHub;

class VersionCommand
{
    /**
     * @var string
     */
    public $command = 'version';

    /**
     * @param Message $message
     *
     * @return string
     */
    public function __invoke(Message $message)
    {
        $tags = GitHub::repo()->tags('laravel', 'framework');

        $version = $tags[0]['name'];

        return $version;
    }
}
