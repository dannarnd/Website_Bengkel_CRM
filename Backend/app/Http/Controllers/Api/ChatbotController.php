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

        // 0. Intercept EXACT MATCH for button clicks (e.g. "cek upper tank avanza lama")
        if (str_starts_with($message, 'cek ')) {
            $exactName = trim(substr($message, 4));
            $part = \App\Models\Sparepart::where('nama_barang', $exactName)->first();
            if ($part) {
                $statusStok = $part->stok > 0 ? "✅ Ready ({$part->stok} pcs)" : "❌ Habis";
                $hargaPart = "Rp" . number_format($part->harga, 0, ',', '.');
                $reply = "**{$part->nama_barang}**\n💰 Harga: {$hargaPart}\n📦 Stok: {$statusStok}\n\n*Jika ingin booking pemasangan, silakan hubungi admin kami ya.*";

                return response()->json([
                    'reply' => $reply,
                    'options' => []
                ]);
            }
        }

        // Retrieve rules directly from the database to avoid cache serialization issues
        $rules = ChatbotRule::all();

        $matchedRules = [];
        foreach ($rules as $rule) {
            if (strpos($message, strtolower($rule->keyword)) !== false) {
                $matchedRules[] = $rule;
            }
        }

        // 2. Jika ada yang cocok
        if (count($matchedRules) > 0) {
            if ($nopol) {
                ChatbotHistory::create(['nomor_polisi' => $nopol, 'id_chatbot_rule' => $matchedRules[0]->id_chatbot_rule, 'waktu_chat' => now()]);
            }

            $replies = [];
            $options = [];

            // 1. Process text rules first so that we collect all textual advice
            foreach ($matchedRules as $matchedRule) {
                if ($matchedRule->action_type === 'text' || $matchedRule->action_type === 'text_only') {
                    $text = $matchedRule->respons_teks ?? $matchedRule->response_text;
                    if (!in_array($text, $replies)) {
                        $replies[] = $text;
                    }
                }
            }

            // 2. Process action rules (check_price, check_stock, status_check)
            foreach ($matchedRules as $matchedRule) {
                if ($matchedRule->action_type === 'status_check' && $nopol) {
                    $kendaraan = Kendaraan::where('nomor_polisi', $nopol)->first();
                    if (!$kendaraan) {
                        $replies[] = "Kendaraan dengan plat $nopol tidak terdaftar.";
                    } else {
                        $service = Service::where('id_kendaraan', $kendaraan->id_kendaraan)->orderBy('created_at', 'desc')->first();
                        if (!$service) {
                            $replies[] = "Tidak ada riwayat servis untuk plat $nopol.";
                        } else {
                            $replies[] = "Status servis kendaraan $nopol saat ini adalah: " . $service->status;
                        }
                    }
                }

                if ($matchedRule->action_type === 'check_price' || $matchedRule->action_type === 'check_stock') {
                    $stopwords = ['apakah', 'mau', 'tanya', 'dong', 'tolong', 'bang', 'kak', 'min', 'mas', 'pak', 'bos', 'kalo', 'kalau', 'berapa', 'harga', 'biaya', 'stok', 'sisa', 'cek', 'ada', 'punya', 'info', 'dan', 'atau', 'untuk', 'dengan', 'buat', 'yang', 'di', 'ke', 'dari', 'pada'];
                    $pattern = '/\b(' . implode('|', $stopwords) . ')\b/i';
                    $searchTerm = trim(preg_replace($pattern, '', $message));
                    $searchTerm = trim(preg_replace('/\s+/', ' ', $searchTerm));

                    if (empty($searchTerm)) {
                        $replies[] = "Silakan sebutkan nama suku cadangnya ya. Contoh ketik: 'harga radiator avanza' atau 'stok coolant'.";
                    } else {
                        // 1.  Letak Mencari Stok atau data yang dicari dalam sparepart 
                        $spareparts = \App\Models\Sparepart::where('nama_barang', 'like', "%{$searchTerm}%")->take(30)->get();

                        // 2. Smart Search (split words) for typos like "uppertank avanxa"
                        if ($spareparts->isEmpty()) {
                            $words = array_filter(explode(' ', $searchTerm), function ($w) {
                                return strlen($w) >= 3;
                            });
                            if (count($words) > 0) {
                                $query = \App\Models\Sparepart::query();
                                foreach ($words as $word) {
                                    $query->orWhere('nama_barang', 'like', "%{$word}%");
                                }
                                $spareparts = $query->take(30)->get();
                            }
                        }

                        if ($spareparts->isEmpty()) {
                            $wordCount = str_word_count($searchTerm);
                            // Jangan tampilkan error "suku cadang tidak ditemukan" jika user sedang cerita panjang lebar dan bot sudah membalas solusinya
                            if (!($wordCount > 3 && count($replies) > 0)) {
                                $replies[] = "Waduh, sepertinya saya tidak menemukan suku cadang '$searchTerm' di bengkel kami. Coba pastikan ejaannya benar ya!";
                            }
                        } else {
                            // Prioritaskan EXACT match jika ada beberapa hasil (menghindari dropdown jika namanya sudah pas 100%)
                            if ($spareparts->count() > 1) {
                                $exactMatch = $spareparts->first(function ($p) use ($searchTerm) {
                                    return strtolower(trim($p->nama_barang)) === strtolower(trim($searchTerm));
                                });
                                if ($exactMatch) {
                                    $spareparts = collect([$exactMatch]);
                                }
                            }

                            if ($spareparts->count() > 1) {
                                $replies[] = "Wah, ada beberapa pilihan untuk '$searchTerm'. Silakan klik salah satu tombol di bawah ini supaya infonya lebih pas:";
                                foreach ($spareparts->take(10) as $part) { // Batasi max 10 tombol agar tidak memenuhi layar
                                    // Provide a generic "Cek" button for both price and stock
                                    $options[] = "Cek {$part->nama_barang}";
                                }
                            } else {
                                $part = $spareparts->first();
                                $statusStok = $part->stok > 0 ? "✅ Ready ({$part->stok} pcs)" : "❌ Habis";
                                $hargaPart = "Rp" . number_format($part->harga, 0, ',', '.');

                                $replies[] = "**{$part->nama_barang}**\n💰 Harga: {$hargaPart}\n📦 Stok: {$statusStok}\n\n*Jika ingin booking pemasangan, silakan hubungi admin kami ya.*";
                            }
                        }
                    }
                }
            }

            return response()->json([
                'reply' => implode("\n\n", $replies),
                'options' => $options
            ]);
        }
        // Fallback default: Coba tebak apakah user mengetik nama sparepart langsung (misal: "upeprtank avanza")
        if (strlen($message) < 50) {
            $words = array_filter(explode(' ', $message), function ($w) {
                return strlen($w) >= 3;
            });
            if (count($words) > 0) {
                $query = \App\Models\Sparepart::query();
                $query->where(function ($q) use ($words) {
                    foreach ($words as $word) {
                        $q->orWhere('nama_barang', 'like', "%{$word}%");
                    }
                });
                $spareparts = $query->take(15)->get();

                if ($spareparts->isNotEmpty()) {
                    $options = [];
                    foreach ($spareparts as $part) {
                        $options[] = "Cek {$part->nama_barang}";
                    }
                    return response()->json([
                        'reply' => "Apakah maksud Anda ingin mengecek stok atau harga salah satu suku cadang di bawah ini?",
                        'options' => $options
                    ]);
                }
            }
        }

        return response()->json(['reply' => "Maaf, Asisten Doles belum paham maksud Anda. Anda bisa ketik 'bantuan' atau langsung hubungi admin via WA."]);
    }
}
