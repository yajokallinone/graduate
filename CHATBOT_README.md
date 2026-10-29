# 🤖 Chatbot Widget - Setup & Usage

## ✨ What You Have

```
✅ Floating Chatbot Widget (bottom-right corner)
✅ Chat UI with typing indicator
✅ API Integration ready
✅ Gemini API support (or basic responses)
✅ No database required
✅ Responsive design (mobile friendly)
```

---

## 🚀 Quick Start (1 minute)

### Step 1: Run Development Server

**Terminal 1 - Laravel:**
```bash
php artisan serve
```

**Terminal 2 - Vite (NEW TERMINAL):**
```bash
npm run dev
```

### Step 2: Visit Website

```
http://localhost:8000
```

### Step 3: Click 💬 Button

You should see a floating button in the **bottom-right corner**.

---

## 🔌 Option 1: Use Gemini API (Recommended)

### Get Free API Key

1. Go to: https://makersuite.google.com/app/apikey
2. Click "Create API Key"
3. Copy the key

### Configure

Add to `.env`:
```env
GEMINI_API_KEY=your-api-key-here
```

### Done! ✅

Chatbot will now use AI to answer questions.

---

## 🔌 Option 2: Use OpenAI API

### Install Package

```bash
composer require openai-php/client
```

### Get API Key

Go to: https://platform.openai.com/api-keys

### Configure

Add to `.env`:
```env
OPENAI_API_KEY=sk-...
```

### Update Controller

Edit `app/Http/Controllers/ChatbotController.php`:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Client;

class ChatbotController extends Controller
{
    private $openai;

    public function __construct()
    {
        $this->openai = \OpenAI::client(env('OPENAI_API_KEY'));
    }

    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $validated['message'];

        try {
            $response = $this->openai->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'คุณคือผู้ช่วยสนับสนุนลูกค้า โปรดตอบเป็นภาษาไทย'
                    ],
                    ['role' => 'user', 'content' => $userMessage]
                ],
                'max_tokens' => 500,
            ]);

            $botResponse = $response->choices[0]->message->content;
        } catch (\Exception $e) {
            $botResponse = 'ขอโทษค่ะ เกิดข้อผิดพลาด';
        }

        return response()->json([
            'success' => true,
            'message' => $botResponse,
        ]);
    }
}
```

---

## 🔌 Option 3: No API (Default)

Chatbot will use **basic pattern matching** without API.

Edit responses in:
```
app/Http/Controllers/ChatbotController.php → generateBasicResponse()
```

---

## 📁 File Structure

```
📦 project/
├── resources/
│   ├── js/
│   │   ├── components/
│   │   │   └── Chatbot.vue ← Widget component
│   │   └── app.js
│   └── views/
│       ├── components/
│       │   └── chatbot.blade.php ← Blade wrapper
│       └── layouts/
│           └── app.blade.php ← Updated with chatbot
├── app/
│   └── Http/
│       └── Controllers/
│           └── ChatbotController.php ← Updated
└── routes/
    └── web.php ← API route added
```

---

## 🎨 Customize

### Change Colors

Edit `resources/js/components/Chatbot.vue`:

```css
.chatbot-toggle-btn {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  /* Change colors here */
}
```

### Change Messages

Edit `app/Http/Controllers/ChatbotController.php`:

```php
private function generateBasicResponse(string $message): string
{
    $patterns = [
        '/hello/' => 'สวัสดี!',
        '/price/' => 'ราคา...',
        // Add your patterns
    ];
}
```

### Change Position

Edit `resources/js/components/Chatbot.vue`:

```css
.chatbot-container {
  bottom: 20px;  /* Distance from bottom */
  right: 20px;   /* Change to 'left: 20px' for left side */
}
```

### Change Size

```css
.chatbot-window {
  width: 380px;   /* Width */
  height: 500px;  /* Height */
}

.chatbot-toggle-btn {
  width: 60px;    /* Button size */
  height: 60px;
}
```

---

## 🐛 Troubleshooting

### ❌ Widget not showing?

1. Check if `npm run dev` is running in another terminal
2. Open Browser DevTools (F12) → Console → Check for errors
3. Make sure you're not using production mode

### ❌ API not responding?

1. Check `.env` has `GEMINI_API_KEY` or `OPENAI_API_KEY`
2. Check Laravel logs: `tail -f storage/logs/laravel.log`
3. Check CSRF token is in layout: `grep csrf-token resources/views/layouts/app.blade.php`

### ❌ Vite error?

```bash
# Kill all node processes
pkill -f "node|npm"

# Start fresh
npm run dev
```

---

## 📱 Features

✅ Float on all pages
✅ Minimize/expand
✅ Type indicator (bot thinking)
✅ Message history (in-memory)
✅ Mobile responsive
✅ CSRF protected
✅ Clean UI

---

## 🚢 Production

### Build Assets

```bash
npm run build
```

### Environment

Add to `.env.production`:
```env
GEMINI_API_KEY=your-key
```

### Deploy

```bash
git push heroku main
# or your hosting provider
```

---

## 💡 Tips

- 💬 Chatbot widget appears on **all pages** automatically
- 📱 Responsive design works on mobile/tablet
- ⚡ No database needed (stateless)
- 🔒 CSRF protected by default
- 🎨 Easy to customize colors/sizes

---

## 📞 Support

**Files to check:**
- `resources/js/components/Chatbot.vue` - Widget component
- `app/Http/Controllers/ChatbotController.php` - API logic
- `resources/views/layouts/app.blade.php` - Layout setup

---

**Version**: 1.0.0
**Status**: Ready to use ✨
**Created**: 2024
