<?php

namespace App\Console\Commands;

use CharlotteDunois\Yasmin\Interfaces\DMChannelInterface;
use CharlotteDunois\Yasmin\Interfaces\TextChannelInterface;
use CharlotteDunois\Yasmin\Models\Message;
use Illuminate\Console\Command;
use Revolution\DiscordManager\Facades\DiscordManager;
use Revolution\DiscordManager\Facades\Yasmin;

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
        Yasmin::on(
            'error',
            function ($error) {
                echo $error.PHP_EOL;
            }
        );

        Yasmin::on(
            'ready',
            function () {
                info(
                    'Logged in as '.Yasmin::user()->tag.' created on '.Yasmin::user()->createdAt->format(
                        'd.m.Y H:i:s'
                    ).PHP_EOL
                );
            }
        );

        Yasmin::on(
            'message',
            function (Message $message) {
                //dd($message->channel);
                info('Received Message from '.$message->author->tag.PHP_EOL);

                if ($message->author->bot) {
                    return;
                }

                try {
                    if ($message->channel instanceof TextChannelInterface) {
                        //チャンネルでのメンション
                        if ($message->mentions->members->has(config('services.discord.bot'))) {
                            //メンション時のみコマンドは有効
                            $reply = DiscordManager::command($message);
                            if (empty($reply)) {
                                $reply = 'Hi! '.$message->author->username;
                            }
                            $message->reply($reply)->done(
                                null,
                                function ($error) {
                                    echo $error.PHP_EOL;
                                }
                            );
                        }
                    }

                    //DMの場合
                    if ($message->channel instanceof DMChannelInterface) {
                        $reply = DiscordManager::direct($message);

                        if (filled($reply)) {
                            $message->reply($reply)->done(
                                null,
                                function ($error) {
                                    echo $error.PHP_EOL;
                                }
                            );
                        }
                    }
                } catch (\Exception $error) {
                    $this->error($error->getMessage());
                    // Handle exception
                }
            }
        );

        Yasmin::login(config('services.discord.token'));
        Yasmin::getLoop()->run();
    }
}
