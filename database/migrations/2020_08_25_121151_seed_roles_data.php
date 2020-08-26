<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedRolesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('roles')->insert([
            [
                'name' => 'Tourist',
                'title' => '游客',
                'color' => '55FF55'
            ],
            [
                'name' => 'Primary',
                'title' => '初建',
                'color' => '00AA00'
            ],
            [
                'name' => 'Team',
                'title' => '团建',
                'color' => 'AAAAAA'
            ],
            [
                'name' => 'Introduction',
                'title' => '高建',
                'color' => '55FFFF'
            ],
            [
                'name' => 'Permanently',
                'title' => '御建',
                'color' => 'AA00AA'
            ],
            [
                'name' => 'Extreme',
                'title' => '皇建',
                'color' => 'FFAA00'
            ],
            [
                'name' => 'Secretary',
                'title' => '项目负责人',
                'color' => 'AAAAAA'
            ],
            [
                'name' => 'Admin',
                'title' => '管理员',
                'color' => 'AA0000'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('roles')->truncate();
    }
}
