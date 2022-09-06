<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * Allow mass assignment to provided fields
     *
     * @var array<string>
     */
    protected $fillable = ["title", "author", "tags", "image"];

    /**
     * Filter images
     *
     * @param mixed $query
     * @param array<string> $filters
     * @return void
     */
    public function scopeFilter($query, array $filters)
    {

        if ($filters["tag"] ?? false) {
            $query->where("tags", "like", "%" . implode(", ", request("tag")) . "%");
        }

        if ($filters["search"] ?? false) {
            $query->where("title", "like", "%" . request("search") . "%")
                ->orWhere("author", "like", "%" . request("search") . "%")
                ->orWhere("tags", "like", "%" . request("search") . "%");
        }
    }
}
