<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use RestCord\DiscordClient;

class GuildCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discord:guild';

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
        $guild = $client->guild->getGuild([
            'guild.id' => config('services.discord.guild'),
        ]);

        dump($guild);

        $channels = $client->guild->getGuildChannels([
            'guild.id' => config('services.discord.guild'),
        ]);

        dump($channels);

        $members = $client->guild->listGuildMembers([
            'guild.id' => config('services.discord.guild'),
            'limit'    => 5,
        ]);

        dump($members);
    }
}
