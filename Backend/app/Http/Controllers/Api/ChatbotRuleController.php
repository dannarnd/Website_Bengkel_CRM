<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatbotRule;
use Illuminate\Http\Request;

class ChatbotRuleController extends Controller
{
    public function index()
    {
        return response()->json(ChatbotRule::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string|unique:chatbot_rule,keyword',
            'respons_teks' => 'nullable|string',
            'action_type' => 'required|string|in:text_only,check_stock,check_price',
        ]);
        $rule = ChatbotRule::create($request->all());
        return response()->json(['status' => 'success', 'data' => $rule]);
    }

    public function show($id)
    {
        return response()->json(ChatbotRule::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $rule = ChatbotRule::findOrFail($id);
        $request->validate([
            'keyword' => 'string|unique:chatbot_rule,keyword,'.$id,
            'respons_teks' => 'nullable|string',
            'action_type' => 'string|in:text_only,check_stock,check_price',
        ]);
        $rule->update($request->all());
        return response()->json(['status' => 'success', 'data' => $rule]);
    }

    public function destroy($id)
    {
        $rule = ChatbotRule::findOrFail($id);
        $rule->delete();
        return response()->json(['status' => 'success']);
    }
}
