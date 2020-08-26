<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserAuth
 *
 * @property int $id
 * @property string $user_id
 * @property string $type
 * @property string $identifier
 * @property string $credential
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static Builder|UserAuth newModelQuery()
 * @method static Builder|UserAuth newQuery()
 * @method static Builder|UserAuth query()
 * @method static Builder|UserAuth whereCreatedAt($value)
 * @method static Builder|UserAuth whereCredential($value)
 * @method static Builder|UserAuth whereId($value)
 * @method static Builder|UserAuth whereIdentifier($value)
 * @method static Builder|UserAuth whereType($value)
 * @method static Builder|UserAuth whereUpdatedAt($value)
 * @method static Builder|UserAuth whereUserId($value)
 * @mixin Eloquent
 */
class UserAuth extends Model
{
    protected $touches = ['user'];

    protected $fillable = [
        'type',
        'identifier',
        'credential',
    ];

    protected $hidden = ['credential'];

    /**
     * 反向一对一关联：用户
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
