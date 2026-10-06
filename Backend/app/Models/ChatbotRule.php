<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotRule extends Model
{
    protected $table = 'chatbot_rule';

    protected $fillable = ['keyword', 'respons_teks', 'action_type'];
}
