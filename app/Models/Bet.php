<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    use HasFactory;

    protected $table = "bets";

    protected $hidden = [
        'created_at',
        'updated_at',
    ];   
    
    protected $casts = [
        'first_player_id' => 'string',
        'first_player_avatar_id' => 'string',
        'second_player_id' => 'string',
        'second_player_avatar_id' => 'string',
    ];
}
