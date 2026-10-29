# 🤖 Chatbot Widget - Quick Start

## ✨ No Vue, No Build Process - Just Plain JavaScript!

```
✅ Chatbot in bottom-right corner
✅ Vanilla JS (no frameworks)
✅ No npm run dev needed
✅ Works immediately
✅ Responsive design
```

---

## 🚀 Setup (1 minute)

### Step 1: Run Laravel Only

```bash
php artisan serve
```

**That's it!** ✅

---

### Step 2: Visit Website

```
http://localhost:8000
```

---

### Step 3: Click 💬 Button

You should see a floating button in the **bottom-right corner**.

---

## 🔌 Use AI (Optional)

### Google Gemini API (Recommended - Free!)

1. Go to: https://makersuite.google.com/app/apikey
2. Create API Key
3. Add to `.env`:

```env
GEMINI_API_KEY=your-key-here
```

Done! Chatbot will use AI now.

---

## 📂 File Structure

```
public/
└── js/
    └── chatbot.js ← The chatbot!

app/Http/Controllers/
└── ChatbotController.php ← API handler

routes/
└── web.php ← API route

resources/views/layouts/
└── app.blade.php ← Chatbot script included
```

---

## 🎨 Customize

### Change Color

Edit `public/js/chatbot.js` - Find:

```javascript
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

Change the colors.

### Change Messages

Edit `app/Http/Controllers/ChatbotController.php`:

```php
private function generateBasicResponse(string $message): string
{
    $patterns = [
        '/hello/' => 'Say something',
        // Add more patterns
    ];
}
```

### Change Position

Edit `public/js/chatbot.js` - Find:

```javascript
#chatbot-container {
  bottom: 20px;  /* Distance from bottom */
  right: 20px;   /* Change to 'left: 20px' for left */
}
```

### Change Size

```javascript
.chatbot-window {
  width: 380px;   /* Width */
  height: 500px;  /* Height */
}
```

---

## 🐛 Troubleshooting

### ❌ Widget not showing?

1. Check browser console (F12)
2. Make sure `public/js/chatbot.js` exists
3. Refresh page (Ctrl+F5)

### ❌ API not working?

1. Check `.env` has `GEMINI_API_KEY`
2. Check Laravel logs: `tail -f storage/logs/laravel.log`
3. Make sure CSRF token is in layout

### ❌ Messages not sending?

1. Open browser console (F12)
2. Check for errors
3. Make sure `/api/chatbot/send-message` route exists

---

## 💡 Features

✅ No build process needed
✅ Works on all pages
✅ Mobile responsive
✅ CSRF protected
✅ Error handling
✅ Typing indicator
✅ Clean UI

---

## 🚢 Deploy

Just upload files:

```bash
php artisan serve  # or your hosting
```

No build step needed!

---

## 📞 Support

**Files:**
- `public/js/chatbot.js` - Main widget
- `app/Http/Controllers/ChatbotController.php` - API
- `routes/web.php` - Route

---

**Version**: 1.0.0
**Status**: Ready ✨
**No Vue Required** 🎉
