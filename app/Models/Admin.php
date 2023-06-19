<?php

namespace App\Models;

use App\Models\AdminRole;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Allow mass assignment to provided fields
     *
     * @var array<string>
     */
    protected $fillable = ['name', 'email', 'notify', 'password'];


    /**
     * How many admins per page
     * 
     * @var int
     */
    public final const PER_PAGE = 9;


    /**
     * The roles that belong to the admin.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(AdminRole::class);
    }

    /**
     * Get the user's preferred locale.
     */
    // public function preferredLocale(): string
    // {
    //     return $this->locale;
    // }
}
