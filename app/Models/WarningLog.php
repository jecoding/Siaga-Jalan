<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarningLog extends Model
{
    use HasFactory;

    public $timestamps = false; // We use triggered_at manually if needed, or keep timestamps

    protected $fillable = [
        'user_id',
        'black_spot_id',
        'triggered_at',
    ];
}
