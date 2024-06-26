<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Collection $transactions
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class User extends Model
{
    use HasFactory;

    protected $fillable = ['id'];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class)->orderBy('id');
    }
}
