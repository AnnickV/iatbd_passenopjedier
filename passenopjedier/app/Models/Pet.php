<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Pet extends Model
{
    use HasFactory;

    protected $table = 'pets';
    
    protected $fillable = [
        'name',
        'type',
        'age',
        'breed',
        'description',
        'hourly_rate',
        'start_date',
        'end_date',
        'image',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sittingRequests(): HasMany
    {
        return $this->hasMany(sittingRequests::class);
    }

    public function getImageUrl(){
        return Storage::url($this->image);
    }
}
