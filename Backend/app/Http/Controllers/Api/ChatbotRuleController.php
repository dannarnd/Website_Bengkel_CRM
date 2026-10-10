<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ChatbotRule;
use Illuminate\Http\Request;

class ChatbotRuleController extends Controller {
    public function index() { return ChatbotRule::all(); }
    public function store(Request $request) {
        $request->validate(['keyword' => 'required|unique:chatbot_rule', 'action_type' => 'required']);
        \Illuminate\Support\Facades\Cache::forget('chatbot_rules');
        return response()->json(ChatbotRule::create($request->all()), 201);
    }
    public function update(Request $request, $id) {
        $rule = ChatbotRule::findOrFail($id);
        $rule->update($request->all());
        \Illuminate\Support\Facades\Cache::forget('chatbot_rules');
        return response()->json($rule, 200);
    }
    public function destroy($id) {
        ChatbotRule::destroy($id);
        \Illuminate\Support\Facades\Cache::forget('chatbot_rules');
        return response()->json(null, 204);
    }
}
