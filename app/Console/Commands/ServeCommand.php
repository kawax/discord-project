<?php

namespace App\Console\Commands;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Illuminate\Console\Command;
use Revolution\DiscordManager\Exceptions\CommandNotFountException;
use Revolution\DiscordManager\Facades\DiscordManager;
use Revolution\DiscordManager\Facades\DiscordPHP;

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
     * @return mixed
     */
    public function handle()
    {
        DiscordPHP::on('error', function ($error) {
            $this->error($error);
        });

        DiscordPHP::on('ready', function (Discord $discord) {
            $this->info('Logged in as '.$discord->user->username);

            $discord->on('message', function (Message $message) {
                $this->info("Recieved a message from {$message->author->username}: {$message->content}");

                try {
                    if ($message->channel->is_private) {
                        // DM
                        DiscordManager::direct($message);
                    } elseif ($message->mentions->has(config('services.discord.bot'))) {
                        // Only mention
                        DiscordManager::command($message);
                    }
                } catch (CommandNotFountException $e) {
                    $message->reply($e->getMessage())
                            ->done(function (Message $message) {
                            });
                }
            });
        });

        DiscordPHP::run();
    }
}
