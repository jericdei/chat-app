<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['receiver'];

    public static function existsForUsers(User $user1, User $user2): bool
    {
        return
            static::query()->where('user_1', $user1->id)->where('user_2', $user2->id)->exists()
            or static::query()->where('user_1', $user2->id)->where('user_2', $user1->id)->exists();
    }

    public function scopeFromUsers(Builder $query, User $user1, User $user2)
    {
        return $query->where(
            fn (Builder $query) => $query->where(
                fn (Builder $q1) => $q1->where('user_1', $user1->id)->where('user_2', $user2->id)
            )->orWhere(
                fn (Builder $q2) => $q2->where('user_1', $user2->id)->where('user_2', $user1->id)
            )
        );
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function getReceiverAttribute(): User
    {
        return $this->getUsers()
            ->where('id', '!=', Auth::id())
            ->first();
    }

    public function getUsers(): Collection
    {
        return User::query()
            ->whereIn('id', [$this->user_1, $this->user_2])
            ->get();
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latest();
    }
}
