<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ChatbotHistory extends Model
{
    protected $table = 'chatbot_history';
    protected $primaryKey = 'id_chat';

    protected $fillable = ['nomor_polisi', 'id_chatbot_rule', 'waktu_chat'];
}
