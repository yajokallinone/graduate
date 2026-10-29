// Chatbot Widget - Vanilla JS (Modern Youthful Theme, exact original content)
(function () {
  'use strict';

  class Chatbot {
    constructor() {
      this.isOpen = false;
      this.messages = [];
      this.isLoading = false;
      this.init();
    }

    init() {
      this.createHTML();
      this.attachEventListeners();
    }

    createHTML() {
      // Create container
      const container = document.createElement('div');
      container.id = 'chatbot-container';
      container.innerHTML = `
        <!-- Toggle Button -->
        <button id="chatbot-toggle" class="chatbot-btn" title="เปิด Chatbot">
          💬
        </button>

        <!-- Chat Window -->
        <div id="chatbot-window" class="chatbot-window" style="display: none;">
          <!-- Header -->
          <div class="chatbot-header">
            <h3>AI Chatbot</h3>
            <button id="chatbot-close" class="chatbot-close-btn">✕</button>
          </div>

          <!-- Messages -->
          <div id="chatbot-messages" class="chatbot-messages">
            <div class="chatbot-empty">
              <p>สวัสดี! 👋<br/>ฉันพร้อมช่วยตอบคำถาม</p>
            </div>
          </div>

          <!-- Input -->
          <div class="chatbot-input-area">
            <input
              id="chatbot-input"
              type="text"
              placeholder="พิมพ์คำถาม..."
              class="chatbot-input"
            />
            <button id="chatbot-send" class="chatbot-send-btn">ส่ง</button>
          </div>
        </div>
      `;

      document.body.appendChild(container);

      // Add styles
      this.addStyles();
    }

    addStyles() {
      const style = document.createElement('style');
      style.textContent = `
        #chatbot-container {
          position: fixed;
          bottom: 24px;
          right: 24px;
          font-family: 'Plus Jakarta Sans', 'Noto Sans Thai', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Sarabun', sans-serif;
          z-index: 9999;
        }

        .chatbot-btn {
          width: 62px;
          height: 62px;
          border-radius: 50%;
          background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 55%, #ec4899 100%);
          border: none;
          color: white;
          font-size: 28px;
          cursor: pointer;
          box-shadow: 0 10px 28px rgba(99, 102, 241, 0.45);
          transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.28s ease;
          display: flex;
          align-items: center;
          justify-content: center;
        }

        .chatbot-btn:hover {
          transform: scale(1.1) translateY(-2px);
          box-shadow: 0 14px 36px rgba(236, 72, 153, 0.55);
        }

        .chatbot-window {
          position: absolute;
          bottom: 80px;
          right: 0;
          width: 380px;
          height: 500px;
          background: white;
          border-radius: 22px;
          border: 1px solid rgba(99, 102, 241, 0.18);
          box-shadow: 0 20px 50px rgba(15, 23, 42, 0.2);
          display: flex;
          flex-direction: column;
          animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
          overflow: hidden;
        }

        @keyframes slideUp {
          from {
            opacity: 0;
            transform: translateY(12px) scale(0.98);
          }
          to {
            opacity: 1;
            transform: translateY(0) scale(1);
          }
        }

        .chatbot-header {
          background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 55%, #ec4899 100%);
          color: white;
          padding: 16px 20px;
          display: flex;
          justify-content: space-between;
          align-items: center;
        }

        .chatbot-header h3 {
          margin: 0;
          font-size: 17px;
          font-weight: 800;
        }

        .chatbot-close-btn {
          background: rgba(255, 255, 255, 0.18);
          border: none;
          color: white;
          font-size: 16px;
          cursor: pointer;
          padding: 0;
          width: 30px;
          height: 30px;
          border-radius: 50%;
          transition: background 0.2s;
        }

        .chatbot-close-btn:hover {
          background: rgba(255, 255, 255, 0.3);
        }

        .chatbot-messages {
          flex: 1;
          overflow-y: auto;
          padding: 16px;
          background: #f8fafc;
          display: flex;
          flex-direction: column;
          gap: 12px;
        }

        .chatbot-empty {
          display: flex;
          align-items: center;
          justify-content: center;
          height: 100%;
          color: #64748b;
          text-align: center;
          font-weight: 500;
        }

        .chatbot-message {
          display: flex;
          animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
          from {
            opacity: 0;
            transform: translateY(10px);
          }
          to {
            opacity: 1;
            transform: translateY(0);
          }
        }

        .chatbot-message.user {
          justify-content: flex-end;
          gap: 8px;
        }

        .chatbot-message.bot {
          justify-content: flex-start;
          gap: 8px;
        }

        .chatbot-avatar {
          width: 32px;
          height: 32px;
          border-radius: 50%;
          margin: 0 6px;
          background-size: cover;
          background-position: center;
          flex-shrink: 0;
        }

        .chatbot-bubble {
          max-width: 75%;
          padding: 10px 15px;
          border-radius: 16px;
          word-wrap: break-word;
          line-height: 1.45;
          font-size: 14px;
        }

        .chatbot-message.user .chatbot-bubble {
          background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
          color: white;
          border-radius: 18px 18px 4px 18px;
          box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }

        .chatbot-message.bot .chatbot-bubble {
          background: white;
          color: #0f172a;
          border: 1px solid rgba(99, 102, 241, 0.16);
          border-radius: 18px 18px 18px 4px;
        }

        .chatbot-typing {
          display: flex;
          gap: 4px;
          align-items: center;
          padding: 10px 16px;
        }

        .chatbot-typing span {
          width: 8px;
          height: 8px;
          border-radius: 50%;
          background: #6366f1;
          animation: typing 1.4s infinite;
        }

        .chatbot-typing span:nth-child(2) {
          animation-delay: 0.2s;
        }

        .chatbot-typing span:nth-child(3) {
          animation-delay: 0.4s;
        }

        @keyframes typing {
          0%, 60%, 100% {
            opacity: 0.5;
            transform: translateY(0);
          }
          30% {
            opacity: 1;
            transform: translateY(-8px);
          }
        }

        .chatbot-input-area {
          display: flex;
          gap: 8px;
          padding: 12px 14px;
          border-top: 1px solid #f1f5f9;
          background: white;
        }

        .chatbot-input {
          flex: 1;
          border: 1.5px solid rgba(99, 102, 241, 0.22);
          border-radius: 999px;
          padding: 10px 16px;
          font-size: 14px;
          outline: none;
          font-family: inherit;
        }

        .chatbot-input:focus {
          border-color: #6366f1;
        }

        .chatbot-input:disabled {
          background: #f8fafc;
        }

        .chatbot-send-btn {
          background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
          color: white;
          border: none;
          border-radius: 999px;
          padding: 10px 20px;
          font-size: 14px;
          font-weight: 700;
          cursor: pointer;
          transition: transform 0.2s, box-shadow 0.2s;
          font-family: inherit;
        }

        .chatbot-send-btn:hover:not(:disabled) {
          transform: scale(1.04);
          box-shadow: 0 4px 12px rgba(236, 72, 153, 0.35);
        }

        .chatbot-send-btn:disabled {
          opacity: 0.6;
          cursor: not-allowed;
        }

        /* Scrollbar */
        .chatbot-messages::-webkit-scrollbar {
          width: 6px;
        }

        .chatbot-messages::-webkit-scrollbar-track {
          background: #f1f5f9;
        }

        .chatbot-messages::-webkit-scrollbar-thumb {
          background: #cbd5e1;
          border-radius: 3px;
        }

        /* Responsive */
        @media (max-width: 480px) {
          .chatbot-window {
            width: calc(100vw - 32px);
            height: 70vh;
            right: 16px;
            bottom: 76px;
          }

          .chatbot-bubble {
            max-width: 90%;
          }
        }
      `;
      document.head.appendChild(style);
    }

    attachEventListeners() {
      const toggleBtn = document.getElementById('chatbot-toggle');
      const closeBtn = document.getElementById('chatbot-close');
      const sendBtn = document.getElementById('chatbot-send');
      const input = document.getElementById('chatbot-input');

      toggleBtn.addEventListener('click', () => this.toggle());
      closeBtn.addEventListener('click', () => this.toggle());
      sendBtn.addEventListener('click', () => this.sendMessage());
      input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') this.sendMessage();
      });
    }

    toggle() {
      const window = document.getElementById('chatbot-window');
      const btn = document.getElementById('chatbot-toggle');
      this.isOpen = !this.isOpen;

      if (this.isOpen) {
        window.style.display = 'flex';
        btn.style.display = 'none';
        document.getElementById('chatbot-input').focus();
      } else {
        window.style.display = 'none';
        btn.style.display = 'flex';
      }
    }

    async sendMessage() {
      const input = document.getElementById('chatbot-input');
      const message = input.value.trim();

      if (!message || this.isLoading) return;

      // Add user message
      this.addMessage('user', message);
      input.value = '';
      this.isLoading = true;

      // Show loading
      this.showLoading();

      try {
        const response = await fetch('/api/chatbot/send-message', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
          },
          body: JSON.stringify({ message }),
        });

        const data = await response.json();
        this.removeLoading();

        if (data.success) {
          this.addMessage('bot', data.message);
        } else {
          this.addMessage('bot', '❌ เกิดข้อผิดพลาด');
        }
      } catch (error) {
        console.error('Error:', error);
        this.removeLoading();
        this.addMessage('bot', '⚠️ ไม่สามารถเชื่อมต่อได้');
      } finally {
        this.isLoading = false;
      }
    }

    addMessage(type, text) {
      const messagesDiv = document.getElementById('chatbot-messages');

      // Remove empty state
      const empty = messagesDiv.querySelector('.chatbot-empty');
      if (empty) empty.remove();

      // Create message
      const messageDiv = document.createElement('div');
      messageDiv.className = `chatbot-message ${type}`;

      // Avatar URLs
      const botAvatarUrl = 'https://ui-avatars.com/api/?name=AI+Bot&background=4f46e5&color=fff&size=32';
      const userAvatarUrl = 'https://ui-avatars.com/api/?name=You&background=ec4899&color=fff&size=32';

      if (type === 'bot') {
        messageDiv.innerHTML = `
          <div class="chatbot-avatar" style="background-image: url('${botAvatarUrl}')"></div>
          <div class="chatbot-bubble">${this.escapeHtml(text)}</div>
        `;
      } else {
        messageDiv.innerHTML = `
          <div class="chatbot-bubble">${this.escapeHtml(text)}</div>
          <div class="chatbot-avatar" style="background-image: url('${userAvatarUrl}')"></div>
        `;
      }

      messagesDiv.appendChild(messageDiv);
      this.scrollToBottom();
    }

    showLoading() {
      const messagesDiv = document.getElementById('chatbot-messages');
      const loadingDiv = document.createElement('div');
      loadingDiv.className = 'chatbot-message bot';
      loadingDiv.id = 'chatbot-loading';

      const botAvatarUrl = 'https://ui-avatars.com/api/?name=AI+Bot&background=4f46e5&color=fff&size=32';

      loadingDiv.innerHTML = `
        <div class="chatbot-avatar" style="background-image: url('${botAvatarUrl}')"></div>
        <div class="chatbot-bubble chatbot-typing">
          <span></span><span></span><span></span>
        </div>
      `;
      messagesDiv.appendChild(loadingDiv);
      this.scrollToBottom();
    }

    removeLoading() {
      const loading = document.getElementById('chatbot-loading');
      if (loading) loading.remove();
    }

    scrollToBottom() {
      const messagesDiv = document.getElementById('chatbot-messages');
      messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    escapeHtml(text) {
      const div = document.createElement('div');
      div.textContent = text;
      return div.innerHTML;
    }
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => new Chatbot());
  } else {
    new Chatbot();
  }
})();
