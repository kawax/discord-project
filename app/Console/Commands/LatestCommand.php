<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use GrahamCampbell\GitHub\Facades\GitHub;
use RestCord\DiscordClient;

class LatestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discord:latest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Latest';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param DiscordClient $client
     *
     * @throws \Exception
     */
    public function handle(DiscordClient $client)
    {
        $release = Github::repo()->releases()->latest('laravel', 'framework');

        $ver = $release['tag_name'];

        if ($ver === cache('latest_ver')) {
            return;
        }

        cache()->forever('latest_ver', $ver);

        try {
            $client->channel->createMessage([
                'channel.id' => config('services.discord.laravel_channel'),
                'content'    => $release['html_url'],
                'embed'      => [
                    //                    "title"       => $release['tag_name'],
                    //                    "url"         => $release['html_url'],
                    "description" => str_limit($release['body'], 2000),
                ],
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
        }
    }
}
