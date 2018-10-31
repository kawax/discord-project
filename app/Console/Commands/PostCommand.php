<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use RestCord\DiscordClient;

class PostCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discord:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle(DiscordClient $client)
    {
        $client->channel->createMessage([
            'channel.id' => (int)config('services.discord.channel'),
            'content'    => 'RestCord test',
        ]);
    }
}
