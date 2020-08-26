<?php

// namespace App\Console\Commands;

// use Illuminate\Console\Command;
// use Storage;
// use Symfony\Component\Yaml\Yaml;

// class DownloadServerPlayersData extends Command
// {
//     /**
//      * The name and signature of the console command.
//      *
//      * @var string
//      */
//     protected $signature = 'server:download {--only-roles : 仅下载权限组索引}';

//     /**
//      * The console command description.
//      *
//      * @var string
//      */
//     protected $description = '从服务器下载玩家数据库';

//     /**
//      * Create a new command instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         parent::__construct();
//     }

//     /**
//      * Execute the console command.
//      *
//      * @return mixed
//      */
//     public function handle()
//     {
//         if (!$this->option('only-roles')) {
//             $this->comment('正在从服务器下载玩家数据库，这可能需要3-10分钟的时间，请耐心等待。');
//             $db = Storage::disk('sftp')->get('server/plugins/LoginSecurity/LoginSecurity.db');
//             $this->comment('下载完成，正在保存至本地...');
//             if (Storage::disk('local')->put('server/players.sqlite', $db)) {
//                 $this->info('玩家数据库保存成功！');
//             }
//         }

//         $this->comment('正在从服务器下载权限组索引，这可能需要3-10分钟的时间，请耐心等待。');
//         $ind = Storage::disk('sftp')->get('server/plugins/GroupManager/worlds/world/users.yml');
//         $this->comment('下载完成，正在保存至本地...');
//         $data = Yaml::parse($ind);
//         $data = $data['users'];
//         $data = json_encode($data);
//         if (Storage::disk('local')->put('server/gm_data.json', $data)) {
//             $this->info('权限组索引保存成功！');
//         }
//     }
// }
