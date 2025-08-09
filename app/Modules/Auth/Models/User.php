<?php

namespace App\Modules\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'username',
        'type',
        'password',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function information(): HasOne
    {
        return $this->hasOne(Information::class);
    }

    public function isNormalUser(): bool
    {
        return $this->type == 1;
    }

    public function messages(): HasMany
    {
        return $this->hasMany(MessageInbox::class);
    }

    public function isAdmin(): bool
    {
        return $this->type == 2;
    }

    public function fullName(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    public function owns(Customer $customer)
    {
        return $this->id == $customer->user_id;
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function checkLists(): HasMany
    {
        return $this->hasMany(CheckList::class);
    }
}
