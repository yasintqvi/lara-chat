<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasUlids;

    protected $fillable = [
        'title',
        'description',
        'avatar'
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function getAvatarAttribute(): string
    {
        return $this->avatar ?? asset('images/group.png');
    }
}
