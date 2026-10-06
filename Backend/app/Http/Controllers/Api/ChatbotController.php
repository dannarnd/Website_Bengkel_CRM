<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatbotRule;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    /**
     * Endpoint untuk menangani pesan masuk dari pelanggan di Portal E-CRM
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $userMessage = strtolower(trim($request->message));
        
        // Ambil semua rule, urutkan berdasarkan panjang keyword (terpanjang lebih dulu)
        // Agar frasa seperti "amper panas" dicek lebih dulu daripada kata tunggal "amper" atau "ada"
        $rules = ChatbotRule::all()->sortByDesc(function ($rule) {
            return strlen($rule->keyword);
        });
        
        $matchedRule = null;

        // Mendeteksi apakah ada keyword di tabel aturan yang cocok dengan teks pelanggan
        foreach ($rules as $rule) {
            // Gunakan preg_match (\b) untuk pencocokan KATA UTUH (Exact Word Boundary)
            // Ini mencegah kata "ada" terdeteksi di dalam kata "pada" atau "badan"
            $pattern = '/\b' . preg_quote(strtolower($rule->keyword), '/') . '\b/i';
            
            if (preg_match($pattern, $userMessage)) {
                $matchedRule = $rule;
                break;
            }
        }

        // =====================================================================
        // FALLBACK CERDAS: Jika tidak ada aturan statis yang cocok, cari barang
        // =====================================================================
        if (!$matchedRule) {
            $foundParts = $this->searchSparepart($userMessage);
            
            if (!empty($foundParts)) {
                if (count($foundParts) > 1) {
                    $response = "Ada beberapa varian barang yang cocok. Silakan pilih salah satu opsi di bawah ini:";
                    $options = [];
                    foreach (array_slice($foundParts, 0, 5) as $part) {
                        $options[] = "Stok " . $part->nama_barang;
                    }
                    
                    return response()->json([
                        'status'  => 'success',
                        'message' => $response,
                        'options' => $options
                    ]);
                } else {
                    $found = $foundParts[0];
                    return response()->json([
                        'status'  => 'success',
                        'message' => "Untuk **{$found->nama_barang}**:<br>"
                                   . "• Stok tersedia: **{$found->stok_sekarang} unit**<br>"
                                   . "• Harga: **Rp " . number_format($found->harga, 0, ',', '.') . "**<br><br>"
                                   . "Ingin informasi lain? Ketik \"stok [nama barang]\" atau \"harga [nama barang]\"."
                    ]);
                }
            }

            // Benar-benar tidak dikenali (bukan rule keluhan, bukan pula sparepart)
            return response()->json([
                'status'  => 'success',
                'message' => 'Maaf, asisten bot Doles Radiator kurang mengerti. Jika Anda mengalami kendala seperti mobil panas atau bocor, coba ceritakan gejalanya. Atau ketik "stok upper tank" untuk mencari barang.'
            ]);
        }

        // 1. Tipe Aksi: Teks Biasa
        if (in_array($matchedRule->action_type, ['text', 'text_only'])) {
            return response()->json([
                'status'  => 'success',
                'message' => $matchedRule->respons_teks
            ]);
        }

        // 2. Tipe Aksi: Cek Stok / Harga
        if (in_array($matchedRule->action_type, ['check_stock', 'check_price'])) {

            $hasProductQuery = $this->hasProductKeyword($userMessage);

            if (!$hasProductQuery) {
                return response()->json([
                    'status'  => 'success',
                    'message' => "Barang apa yang ingin Anda cek? 😊<br><br>Contoh:<br>• \"stok upper tank avanza\"<br>• \"harga radiator toyota\"<br>• \"coolant hijau\""
                ]);
            }

            $foundParts = $this->searchSparepart($userMessage);

            if (empty($foundParts)) {
                return response()->json([
                    'status'  => 'success',
                    'message' => "Maaf, kami tidak menemukan barang tersebut di database. Coba ketik nama yang lebih lengkap ya.<br>Contoh: \"upper tank avanza\" atau \"radiator kijang\""
                ]);
            }

            if (count($foundParts) > 1) {
                $response = "Ada beberapa varian barang. Yang mana yang ingin Anda lihat detailnya?";
                $options = [];
                foreach (array_slice($foundParts, 0, 5) as $part) {
                    $options[] = "Cek " . $part->nama_barang;
                }
                
                return response()->json([
                    'status'  => 'success',
                    'message' => $response,
                    'options' => $options
                ]);
            }

            $foundSparepart = $foundParts[0];
            $price = number_format($foundSparepart->harga, 0, ',', '.');
            $stokInfo = $foundSparepart->stok_sekarang > 0
                ? "tersedia **{$foundSparepart->stok_sekarang} unit**"
                : "sedang **habis** (stok 0)";

            return response()->json([
                'status'  => 'success',
                'message' => "Berikut detail untuk **{$foundSparepart->nama_barang}**:<br><br>"
                           . "• Harga: **Rp{$price}**<br>"
                           . "• Stok saat ini: {$stokInfo}<br><br>"
                           . "Ingin cek barang lain? Ketik namanya saja."
            ]);
        }
    }

    private function getStopWords(): array
    {
        return [
            'halo', 'hallo', 'hai', 'helo', 'hello', 'hey', 'hi', 'pagi', 'siang', 'sore', 'malam', 'permisi',
            'cek', 'harga', 'berapa', 'dong', 'min', 'stok', 'sisa', 'ada', 'tolong', 'bang', 'kak', 'mas', 'pak', 'bu',
            'untuk', 'buat', 'mobil', 'nya', 'ya', 'mau', 'beli', 'tanya', 'nanya', 'pesan', 'butuh', 'ready',
            'apakah', 'apa', 'masih', 'berapa', 'kira', 'yah', 'kah', 'gimana', 'bagaimana', 'kenapa', 'biasanya',
            'di', 'sini', 'sana', 'itu', 'ini', 'dan', 'atau', 'pada', 'saya', 'aku', 'kami', 'kita', 'yang', 'dari', 'ke', 'yg',
            'naik', 'amper', 'panas', 'bocor', 'tutup', 'atasnya', 'atas', 'bawah', 'rusak', 'pecah', 'habis', 'terus',
            'ganti', 'jasa', 'masalah', 'solusi', 'perbaikan', 'bengkel', 'servis', 'service', 'pasang', 'barang', 'produk'
        ];
    }

    private function hasProductKeyword(string $userMessage): bool
    {
        $stopWords = $this->getStopWords();
        $clean = $userMessage;
        foreach ($stopWords as $sw) {
            $clean = preg_replace('/\b' . preg_quote($sw, '/') . '\b/i', ' ', $clean);
        }
        
        $clean = trim(preg_replace('/\s+/', ' ', $clean));
        $words = array_filter(explode(' ', preg_replace('/[^a-z0-9 ]/', '', $clean)));
        
        foreach ($words as $w) {
            if (strlen($w) > 2) return true;
        }
        return false;
    }

    /**
     * Mencari sparepart dan mengembalikan ARRAY barang yang cocok (bisa lebih dari satu)
     */
    private function searchSparepart(string $userMessage): array
    {
        $spareparts = Sparepart::all();
        $matches = [];

        $stopWords = $this->getStopWords();
        $cleanMsg = strtolower($userMessage);
        foreach ($stopWords as $sw) {
            $cleanMsg = preg_replace('/\b' . preg_quote($sw, '/') . '\b/i', ' ', $cleanMsg);
        }
        
        $cleanMsg     = trim(preg_replace('/\s+/', ' ', $cleanMsg));
        $userWords    = array_filter(explode(' ', preg_replace('/[^a-z0-9 ]/', '', $cleanMsg)));
        $userNoSpace  = preg_replace('/[^a-z0-9]/', '', $userMessage);

        if (empty($userWords)) return [];

        foreach ($spareparts as $part) {
            $partName      = strtolower($part->nama_barang);
            $partNoSpace   = preg_replace('/[^a-z0-9]/', '', $partName);
            $partWords     = array_filter(explode(' ', $partName));

            // 1. Exact No-Space Match
            if (strlen($partNoSpace) > 3 && str_contains($userNoSpace, $partNoSpace)) {
                return [$part]; // Sangat akurat, langsung return array 1 item
            }

            // 1b. Keseluruhan Kalimat Mirip
            similar_text($userNoSpace, $partNoSpace, $fullSim);
            $score = 0;
            if ($fullSim >= 75) {
                $score += 4;
            }

            // 2. Exact per-kata dan Typo Tolerance
            foreach ($userWords as $word) {
                if (strlen($word) < 3) continue;

                if (in_array($word, $partWords)) {
                    $score += 2;
                } else {
                    $bestWordSim = 0;
                    $matchedPWordLen = 0;
                    
                    foreach ($partWords as $pWord) {
                        similar_text($word, $pWord, $pct);
                        if ($pct > $bestWordSim) {
                            $bestWordSim = $pct;
                            $matchedPWordLen = strlen($pWord);
                        }
                    }
                    
                    $lengthDiff = abs(strlen($word) - $matchedPWordLen);
                    
                    if ($bestWordSim >= 75 && $lengthDiff <= 2) {
                        $score += 1;
                    }
                }
            }

            // Memerlukan skor yang cukup meyakinkan
            if ($score >= 2) {
                $matches[] = [
                    'part' => $part,
                    'score' => $score
                ];
            }
        }

        // Urutkan berdasarkan skor tertinggi ke terendah
        usort($matches, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        if (empty($matches)) return [];

        $topScore = $matches[0]['score'];
        // Kumpulkan semua barang yang skornya beda tipis dengan barang yang paling mirip
        $bestMatches = array_filter($matches, function($m) use ($topScore) {
            return $m['score'] >= ($topScore - 1); 
        });

        return array_map(function($m) { return $m['part']; }, array_values($bestMatches));
    }
}
