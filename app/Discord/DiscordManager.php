<?php

namespace App\Discord;

use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use CharlotteDunois\Yasmin\Models\Message;

class DiscordManager
{
    /**
     * @var string
     */
    protected $prefix = '/';

    /**
     * @var array
     */
    protected $commands = [];

    /**
     * DiscordManager constructor.
     */
    public function __construct()
    {
        $this->load(__DIR__ . '/Commands');
    }

    /**
     * @param Message $message
     *
     * @return string
     */
    public function command(Message $message)
    {
        if (!Str::contains($message->content, $this->prefix)) {
            return '';
        }

        $command = Str::before(Str::after($message->content, $this->prefix), ' ');

        if (Arr::has($this->commands, $command)) {
            return $this->commands[$command]($message);
        } else {
            return 'Command Not Found!';
        }
    }

    /**
     * @param $paths
     *
     * @throws \ReflectionException
     */
    protected function load($paths)
    {
        $paths = array_unique(Arr::wrap($paths));

        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });

        if (empty($paths)) {
            return;
        }

        $namespace = app()->getNamespace();

        foreach ((new Finder)->in($paths)->files() as $command) {
            $command = $namespace . str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($command->getPathname(), app_path() . DIRECTORY_SEPARATOR)
                );

            if (!(new ReflectionClass($command))->isAbstract()) {
                $this->resolve($command);
            }
        }
    }

    /**
     * @param $path
     */
    protected function resolve($path)
    {
        $command = app($path);

        $this->commands[$command->command] = $command;
    }
}
