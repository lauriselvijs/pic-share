<?php

namespace App\Models;

use App\Models\AdminRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Admin extends Model
{
    use HasFactory, Notifiable;

    /**
     * Allow mass assignment to provided fields
     *
     * @var array<string>
     */
    protected $fillable = ['name', 'email', 'notify'];


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
