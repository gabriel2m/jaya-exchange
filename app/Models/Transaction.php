<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property string $from
 * @property float $amount
 * @property string $to
 * @property float $rate
 * @property float $result
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'from',
        'amount',
        'to',
        'rate',
    ];

    protected $casts = [
        'amount' => 'float',
        'rate' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function result(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->amount * $this->rate,
        );
    }
}
