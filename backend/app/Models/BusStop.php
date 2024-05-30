<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusStop extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'next',
        'lat',
        'lng',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
