<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatbotRule;
use App\Models\Kendaraan;
use App\Models\Service;
use App\Models\ChatbotHistory;

class ChatbotController extends Controller
{
    public function process(Request $request)
    {
        $message = strtolower($request->input('message', ''));
        $nopol = strtoupper($request->input('nomor_polisi', null));
        
        $rules = ChatbotRule::all();
        $matchedRule = null;
        
        foreach ($rules as $rule) {
            if (strpos($message, strtolower($rule->keyword)) !== false) {
                $matchedRule = $rule;
                break;
            }
        }
        
        if ($matchedRule) {
            if ($nopol) {
                ChatbotHistory::create(['nomor_polisi' => $nopol, 'id_chatbot_rule' => $matchedRule->id_chatbot_rule, 'waktu_chat' => now()]);
            }
            if ($matchedRule->action_type === 'text') {
                return response()->json(['reply' => $matchedRule->response_text]);
            }
            if ($matchedRule->action_type === 'status_check' && $nopol) {
                $kendaraan = Kendaraan::where('nomor_polisi', $nopol)->first();
                if (!$kendaraan) {
                    return response()->json(['reply' => "Kendaraan dengan plat $nopol tidak terdaftar."]);
                }
                $service = Service::where('id_kendaraan', $kendaraan->id_kendaraan)->orderBy('created_at', 'desc')->first();
                if (!$service) {
                    return response()->json(['reply' => "Tidak ada riwayat servis untuk plat $nopol."]);
                }
                return response()->json(['reply' => "Status servis kendaraan $nopol: " . $service->status]);
            }
        }
        return response()->json(['reply' => "Maaf, Asisten Doles belum paham. Coba ketik 'lokasi', 'buka', atau tanyakan status perbaikan."]);
    }
}
