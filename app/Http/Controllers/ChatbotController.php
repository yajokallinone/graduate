<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * ส่งข้อความถึง Chatbot
     */
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $validated['message'];

        // ใช้ Chatgen API ของมหาวิทยาลัยเชียงใหม่ (SCMC)
        $response = $this->callChatgenAPI($userMessage);

        if (!$response) {
            $response = $this->generateBasicResponse($userMessage);
        }

        return response()->json([
            'success' => true,
            'message' => $response,
        ]);
    }

    /**
     * เรียก Chatgen API (https://chatgen.scmc.cmu.ac.th)
     * ใช้ model "polar" พร้อมอ้างอิงข้อมูลจาก collection (knowledge base) ที่กำหนดไว้
     */
    private function callChatgenAPI(string $message): ?string
    {
        try {
            $apiKey = env('CHATGEN_API_KEY');

            if (!$apiKey) {
                // ยังไม่ได้ตั้งค่า CHATGEN_API_KEY ใน .env - ใช้คำตอบพื้นฐานแทน
                return null;
            }

            $response = Http::withToken($apiKey)
                ->timeout(30)
                ->post('https://chatgen.scmc.cmu.ac.th/api/chat/completions', [
                    'model' => 'polar',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $message,
                        ],
                    ],
                    'files' => [
                        [
                            'type' => 'collection',
                            'id' => 'edfe8788-728d-4da8-a865-2dd758638660',
                        ],
                        [
                            'type' => 'collection',
                            'id' => 'd37b4f2d-6614-4110-9cff-9b7b8afe9d78',
                        ],
                    ],
                ]);

            if ($response->successful()) {
                $data = $response->json();

                // รูปแบบผลลัพธ์เข้ากันได้กับ OpenAI-style chat completions API
                return $data['choices'][0]['message']['content'] ?? null;
            }

            Log::warning('Chatgen API: request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        } catch (\Exception $e) {
            Log::error('Chatgen API Error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * คำตอบพื้นฐาน (เมื่อไม่มี API Key หรือเรียก Chatgen API ไม่สำเร็จ)
     */
    private function generateBasicResponse(string $message): string
    {
        // Pattern matching สำหรับคำถามทั่วไป
        $patterns = [
            '/สวัสดี|hello|hi/' => 'สวัสดี! 👋 ยินดีที่ได้พบคุณ มีอะไรให้ช่วยไหม?',
            '/ขอบคุณ|thanks/' => 'ยินดีค่ะที่ได้ช่วยเหลือ! 😊',
            '/ราคา|cost|price/' => 'สำหรับข้อมูลราคา กรุณาไปที่หน้าราคาของเรา หรือติดต่อเราโดยตรง',
            '/โปรแกรม|program|course/' => 'เราเสนอโปรแกรมการศึกษาหลายประเภท กรุณาไปที่หน้าโปรแกรมของเรา',
            '/ติดต่อ|contact|help/' => 'คุณสามารถติดต่อเราผ่านอีเมลหรือโทรศัพท์ได้',
        ];

        foreach ($patterns as $pattern => $response) {
            if (preg_match($pattern, $message)) {
                return $response;
            }
        }

        return "ขอโทษค่ะ เข้าใจไม่ได้นะ 🤔 คุณสามารถถามคำถามอื่น ๆ ได้ หรือติดต่อทีมสนับสนุนโดยตรง";
    }
}
