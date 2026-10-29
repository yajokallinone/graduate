# 🎨 Chatbot Avatar Customization

## Current Setup

Chatbot ใช้ **UI Avatars** (auto-generated):

- **Bot Avatar**: AI Bot (สีม่วง)
- **User Avatar**: You (สีม่วงเข้ม)

---

## 🖼️ ใช้รูปภาพของตัวเอง

### วิธี 1: ใช้ Custom Image URL

Edit `public/js/chatbot.js` - ค้นหา:

```javascript
const botAvatarUrl = 'https://ui-avatars.com/api/?name=AI+Bot&background=667eea&color=fff&size=32';
const userAvatarUrl = 'https://ui-avatars.com/api/?name=You&background=764ba2&color=fff&size=32';
```

เปลี่ยนเป็นรูปของคุณ:

```javascript
const botAvatarUrl = 'https://your-domain.com/images/bot-avatar.png';
const userAvatarUrl = 'https://your-domain.com/images/user-avatar.png';
```

---

### วิธี 2: ใช้ Local Images

1. เพิ่มรูปในโฟลเดอร์ `public/images/`:

```
public/
└── images/
    ├── bot-avatar.png
    └── user-avatar.png
```

2. Update URL:

```javascript
const botAvatarUrl = '/images/bot-avatar.png';
const userAvatarUrl = '/images/user-avatar.png';
```

---

### วิธี 3: ใช้ Emoji

ถ้าต้องการ emoji แทนรูป:

```javascript
addMessage(type, text) {
  const messagesDiv = document.getElementById('chatbot-messages');
  const empty = messagesDiv.querySelector('.chatbot-empty');
  if (empty) empty.remove();

  const messageDiv = document.createElement('div');
  messageDiv.className = `chatbot-message ${type}`;

  if (type === 'bot') {
    messageDiv.innerHTML = `
      <div style="font-size: 24px; margin: 0 8px;">🤖</div>
      <div class="chatbot-bubble">${this.escapeHtml(text)}</div>
    `;
  } else {
    messageDiv.innerHTML = `
      <div class="chatbot-bubble">${this.escapeHtml(text)}</div>
      <div style="font-size: 24px; margin: 0 8px;">👤</div>
    `;
  }

  messagesDiv.appendChild(messageDiv);
  this.scrollToBottom();
}
```

---

## 🎨 Avatar Options

### Google Avatar Generator

```
https://ui-avatars.com/api/?name=NAME&background=COLOR&color=TEXT&size=32
```

**ตัวอย่าง**:
- `?name=AI+Bot&background=667eea&color=fff`
- `?name=Customer&background=FF6B6B&color=fff`

---

### Gravatar (โปรไฟล์จริง)

```
https://www.gravatar.com/avatar/HASH?s=32
```

---

### Dicebear (Auto-generated)

```
https://api.dicebear.com/7.x/avataaars/svg?seed=USERNAME
```

---

## 🖼️ Recommended Sizes

- **Avatar size**: 32x32 px
- **Message gap**: 8px

---

## 💡 Example: Custom Bot Avatar

```javascript
const botAvatarUrl = 'https://ui-avatars.com/api/?name=Customer+Support&background=4CAF50&color=fff&size=32&bold=true';
```

---

## 📝 Current Implementation

```javascript
// In addMessage() and showLoading()
if (type === 'bot') {
  messageDiv.innerHTML = `
    <div class="chatbot-avatar" style="background-image: url('${botAvatarUrl}')"></div>
    <div class="chatbot-bubble">Message</div>
  `;
} else {
  messageDiv.innerHTML = `
    <div class="chatbot-bubble">Message</div>
    <div class="chatbot-avatar" style="background-image: url('${userAvatarUrl}')"></div>
  `;
}
```

---

## 🎯 Summary

| Option | Pro | Con |
|--------|-----|-----|
| **UI Avatars** | Auto, clean | Generic |
| **Custom URL** | Your brand | External link |
| **Local Image** | Fast, secure | Upload needed |
| **Emoji** | Simple | No customization |

---

**Choose one and update `public/js/chatbot.js`** 🎨
