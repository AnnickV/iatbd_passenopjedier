<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SittingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'user_id',
        'pet_owner_id',
        'status',
    ];

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function petOwner()
    {
        return $this->belongsTo(User::class, 'pet_owner_id');
    }
}
