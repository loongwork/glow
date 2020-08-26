<?php

// namespace App\Console\Commands;

// use App\Models\Social;
// use App\Repositories\Eloquent\UserRepository;
// use Carbon\Carbon;
// use Illuminate\Console\Command;
// use Illuminate\Support\Facades\DB;
// use Storage;
// use Sunxyw\LaravelQuickRole\Models\Role;

// class SyncServerPlayersToUsers extends Command
// {
//     /**
//      * The name and signature of the console command.
//      *
//      * @var string
//      */
//     protected $signature = 'server:sync';

//     /**
//      * The console command description.
//      *
//      * @var string
//      */
//     protected $description = '同步服务器玩家数据库至用户数据库';

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
//         $players = DB::connection('serverMirror')->table('ls_players');
//         $roles = Role::all();
//         $gm_data = Storage::disk('local')->get('server/gm_data.json');
//         $gm_data = json_decode($gm_data, true);
//         $user_repo = new UserRepository;

//         $playersCount = $players->count();
//         $handledPlayersCount = 0;
//         $inactivePlayersCount = 0;
//         $unrelatedPlayersCount = 0;
//         $notExistsPlayersCount = 0;

//         $progress = $this->output->createProgressBar($playersCount);
//         $progress->setFormat("<comment>%message%：</comment><question>%current%</question><comment>/%max%</comment>");
//         $progress->setMessage('正在处理第1批玩家数据');
//         $progress->start();

//         $chunkIndex = 0;

//         $players->orderByDesc('last_login')->chunk(
//             100,
//             function ($playersChunk) use (
//                 &$handledPlayersCount,
//                 &$inactivePlayersCount,
//                 &$unrelatedPlayersCount,
//                 &$notExistsPlayersCount,
//                 &$progress,
//                 &$chunkIndex,
//                 $gm_data,
//                 $roles,
//                 $user_repo
//             ) {
//                 $progress->setMessage('正在处理第' . ++$chunkIndex . '批玩家数据');
//                 foreach ($playersChunk as $player) {
//                     $progress->advance();
//                     $last_login = new Carbon(intval($player->last_login / 1000));
//                     if ($last_login->diffInMonths() > 3) {
//                         // 仅导入三个月内活跃过的玩家
//                         $inactivePlayersCount++;
//                         continue;
//                     }

//                     $social = Social::query()->whereType('minecraft')->whereValue($player->last_name)->first();

//                     if (is_null($social)) {
//                         if ($player->hashing_algorithm != 1) {
//                             // 无关的玩家
//                             $unrelatedPlayersCount++;
//                             continue;
//                         }

//                         // 根据游戏信息创建一个账号
//                         $user = $user_repo->create($player->last_name, 'minecraft', $player->last_name, $player->password, 1);
//                     }

//                     if (array_key_exists($player->unique_user_id, $gm_data)) {
//                         $role = $gm_data[$player->unique_user_id]['group'];
//                         $role = $roles->where('name', $role)->first();
//                     } else {
//                         $notExistsPlayersCount++;
//                         $this->warn("无法找到 {$player->last_name} 的权限组信息，已略过");
//                         continue;
//                     }

//                     $user = $user ?? $social->user;
//                     $user->assignRole($role);

//                     $handledPlayersCount++;
//                 }
//             }
//         );

//         $progress->setFormat('<info>%message%：</info><question>%current%</question><comment>/%max%</comment>');
//         $progress->setMessage('处理完成');
//         $progress->finish();

//         $this->line('');
//         $msg = '';
//         $msg .= "  -> 同步了 {$handledPlayersCount} 条玩家信息\n";
//         $msg .= "  -> 略过了 {$inactivePlayersCount} 条不活跃玩家信息\n";
//         $msg .= "  -> 略过了 {$unrelatedPlayersCount} 条无关的玩家信息\n";
//         $msg .= "  -> 略过了 {$notExistsPlayersCount} 条未知的玩家信息";
//         $this->info($msg);
//     }
// }
