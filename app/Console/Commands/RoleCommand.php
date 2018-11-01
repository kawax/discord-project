<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use RestCord\DiscordClient;

class RoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discord:role';

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
        //Roleリスト。RoleのIDはここから調べるしかないかも。
        $roles = $client->guild->getGuildRoles([
            'guild.id' => config('services.discord.guild'),
        ]);

        dump($roles);

        //Role追加
        $client->guild->addGuildMemberRole([
            'guild.id' => config('services.discord.guild'),
            'user.id'  => config('services.discord.bot'),
            'role.id'  => config('services.discord.role'),
        ]);

        //プライベートチャンネルへ投稿
        $client->channel->createMessage([
            'channel.id' => (int)config('services.discord.private'),
            'content'    => 'private test',
        ]);

        //Role削除
        $client->guild->removeGuildMemberRole([
            'guild.id' => config('services.discord.guild'),
            'user.id'  => config('services.discord.bot'),
            'role.id'  => config('services.discord.role'),
        ]);

        //削除後プライベートチャンネルへの投稿は失敗
    }
}
