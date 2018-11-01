<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use RestCord\DiscordClient;

class EmbedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discord:embed';

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
            'content'    => 'Embed test',
            'embed'      => [
                "title"       => "title ~~(did you know you can have markdown here too?)~~",
                "description" => "this supports [named links](https://discordapp.com) on top of the previously shown subset of markdown. ```\nyes, even code blocks```",
                "url"         => "https://discordapp.com",
                "color"       => 14290439,
                "timestamp"   => "2017-02-20T18:05:58.512Z",
                "footer"      => [
                    "icon_url" => "https://cdn.discordapp.com/embed/avatars/0.png",
                    "text"     => "footer text",
                ],
                "thumbnail"   => [
                    "url" => "https://cdn.discordapp.com/embed/avatars/0.png",
                ],
                "image"       => [
                    "url" => "https://cdn.discordapp.com/embed/avatars/0.png",
                ],
                "author"      => [
                    "name"     => "author name",
                    "url"      => "https://discordapp.com",
                    "icon_url" => "https://cdn.discordapp.com/embed/avatars/0.png",
                ],
                "fields"      => [
                    [
                        "name"  => "Foo",
                        "value" => "some of these properties have certain limits...",
                    ],
                    [
                        "name"  => "Bar",
                        "value" => "try exceeding some of them!",
                    ],
                    [
                        "name"  => " 😃",
                        "value" => "an informative error should show up, and this view will remain as-is until all issues are fixed",
                    ],
                ],

            ],
        ]);
    }
}
