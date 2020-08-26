<?php

namespace App\Providers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('api', function (Request $request) {
            if ($request->hasHeader('Authorization')) {
                $token = str_replace('Bearer ', '', $request->header('Authorization'));
                $data = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
                $user_id = $data->sub;

                return User::query()->findOrFail($user_id);
            }

            return null;
        });
    }
}
