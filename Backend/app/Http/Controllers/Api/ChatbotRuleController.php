<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ChatbotRule;
use Illuminate\Http\Request;

class ChatbotRuleController extends Controller {
    public function index() { return ChatbotRule::all(); }
    public function store(Request $request) {
        $request->validate(['keyword' => 'required|unique:chatbot_rule', 'action_type' => 'required']);
        return response()->json(ChatbotRule::create($request->all()), 201);
    }
    public function destroy($id) {
        ChatbotRule::destroy($id);
        return response()->json(null, 204);
    }
}
