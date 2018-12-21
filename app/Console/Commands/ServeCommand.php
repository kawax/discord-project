<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use CharlotteDunois\Yasmin\Client as Yasmin;
use CharlotteDunois\Yasmin\Models\Message;

use Revolution\DiscordManager\Facades\DiscordManager;

class ServeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discord:serve';

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
     * @param Yasmin $client
     *
     * @return mixed
     */
    public function handle(Yasmin $client)
    {
        $client->on('error', function ($error) {
            echo $error . PHP_EOL;
        });

        $client->on('ready', function () use ($client) {
            echo 'Logged in as ' . $client->user->tag . ' created on ' . $client->user->createdAt->format('d.m.Y H:i:s') . PHP_EOL;
        });

        $client->on('message', function (Message $message) {
            echo 'Received Message from ' . $message->author->tag . ' in ' . ($message->channel->type === 'text' ? 'channel #' . $message->channel->name : 'DM') . ' with ' . $message->attachments->count() . ' attachment(s) and ' . \count($message->embeds) . ' embed(s)' . PHP_EOL;

            if ($message->author->bot) {
                return;
            }

            try {
                if ($message->channel->type === 'text') {
                    //チャンネルでのメンション
                    if ($message->mentions->members->has(config('services.discord.bot'))) {
                        //メンション時のみコマンドは有効
                        $reply = DiscordManager::command($message);
                        if (empty($reply)) {
                            $reply = 'Hi! ' . $message->author->username;
                        }
                        $message->reply($reply)->done(null, function ($error) {
                            echo $error . PHP_EOL;
                        });
                    }
                }

                //DMの場合
                if ($message->channel->type === 'dm') {
                    $reply = DiscordManager::direct($message);

                    if (filled($reply)) {
                        $message->reply($reply)->done(null, function ($error) {
                            echo $error . PHP_EOL;
                        });
                    }
                }
            } catch (\Exception $error) {
                $this->error($error->getMessage());
                // Handle exception
            }
        });

        $client->login(config('services.discord.token'));
        $client->getLoop()->run();
    }
}
