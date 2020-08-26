<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $nickname
 * @property int $role_id
 * @property string|null $avatar
 * @property string $status
 * @property string|null $remember_token
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|UserAuth[] $auths
 * @property-read int|null $auths_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereNickname($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereRoleId($value)
 * @method static Builder|User whereStatus($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $fillable = [
        'nickname', 'role_id', 'avatar',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * 一对多关联：认证信息
     *
     * @return HasMany
     */
    public function auths(): HasMany
    {
        return $this->hasMany(UserAuth::class);
    }
}
