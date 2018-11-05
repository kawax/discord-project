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
     * @return mixed
     */
    public function command(Message $message)
    {
        if (!str_contains($message->content, $this->prefix)) {
            return '';
        }

        $command = Str::before(Str::after($message->content, $this->prefix), ' ');

        return $this->commands[$this->prefix . $command]($message);
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
        $command = resolve($path);

        $this->commands[$this->prefix . $command->command] = $command;
    }
}
