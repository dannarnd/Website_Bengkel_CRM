<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ChatbotRule extends Model
{
    protected $table = 'chatbot_rule';
    protected $primaryKey = 'id_chatbot_rule';

    protected $fillable = ['keyword', 'action_type', 'response_text'];
}
