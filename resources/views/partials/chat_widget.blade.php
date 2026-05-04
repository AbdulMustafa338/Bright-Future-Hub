<div id="chat-widget-container" style="position: fixed; bottom: 24px; right: 24px; z-index: 9999;">

    {{-- Floating Toggle Button --}}
    <button id="chat-toggle-btn" title="Chat with Hub Guide AI"
        style="width:62px;height:62px;border-radius:50%;border:none;cursor:pointer;
               background: linear-gradient(135deg,#6c63ff,#4f46e5);
               color:#fff;font-size:1.5rem;box-shadow:0 6px 24px rgba(99,91,255,.5);
               transition:transform .2s,box-shadow .2s;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-robot"></i>
    </button>

    {{-- Chat Window --}}
    <div id="chat-window"
        style="display:none;position:absolute;bottom:76px;right:0;width:360px;height:500px;
               border-radius:20px;overflow:hidden;
               background:#fff;border:1px solid rgba(99,91,255,.15);
               box-shadow:0 20px 60px rgba(0,0,0,.18);
               flex-direction:column;">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#6c63ff,#4f46e5);padding:14px 18px;display:flex;align-items:center;justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:38px;height:38px;border-radius:50%;background:rgba(255,255,255,.2);
                            display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:#fff;">
                    <i class="fas fa-brain"></i>
                </div>
                <div>
                    <div style="color:#fff;font-weight:700;font-size:.95rem;">Hub Guide AI</div>
                    <div style="color:rgba(255,255,255,.8);font-size:.72rem;">● Online · Powered by Gemini</div>
                </div>
            </div>
            <div style="display:flex;gap:8px;align-items:center;">
                <button id="chat-clear-btn" title="New Chat"
                    style="background:rgba(255,255,255,.2);border:none;color:#fff;border-radius:8px;
                           padding:5px 10px;font-size:.72rem;cursor:pointer;transition:background .2s;">
                    <i class="fas fa-plus me-1"></i>New Chat
                </button>
                <button id="chat-close-btn"
                    style="background:rgba(255,255,255,.2);border:none;color:#fff;border-radius:8px;
                           width:30px;height:30px;cursor:pointer;font-size:.85rem;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        {{-- Messages Area --}}
        <div id="chat-messages"
            style="flex:1;overflow-y:auto;padding:16px;background:#f8f8ff;display:flex;flex-direction:column;gap:12px;scroll-behavior:smooth;">

            {{-- Initial Bot Message --}}
            <div class="chat-msg-bot">
                <div class="chat-bubble-bot">
                    👋 Hi there! I'm <strong>Hub Guide AI</strong> &mdash; your personal assistant for <strong>Bright Future Hub</strong>.<br><br>
                    I can help you find <b>internships, jobs &amp; scholarships</b>, guide you through the portal, or answer career questions!<br><br>
                    How can I help you today?
                </div>
            </div>

            {{-- Quick suggestion chips --}}
            <div id="chat-suggestions" style="display:flex;flex-wrap:wrap;gap:6px;">
                <button class="chat-chip">🔍 Find Internships</button>
                <button class="chat-chip">📋 How to Apply?</button>
                <button class="chat-chip">✏️ Edit My Profile</button>
                <button class="chat-chip">📊 Track Application</button>
            </div>
        </div>

        {{-- Input Area --}}
        <div style="padding:12px 14px;background:#fff;border-top:1px solid #ececff;">
            <form id="chat-form" style="display:flex;gap:8px;align-items:center;">
                <input type="text" id="chat-input" placeholder="Ask me anything..."
                    style="flex:1;border:1.5px solid #e0deff;border-radius:12px;padding:9px 14px;
                           font-size:.88rem;outline:none;transition:border-color .2s;background:#fafaff;">
                <button type="submit" id="chat-send-btn"
                    style="width:42px;height:42px;border-radius:12px;border:none;cursor:pointer;
                           background:linear-gradient(135deg,#6c63ff,#4f46e5);color:#fff;
                           font-size:1rem;display:flex;align-items:center;justify-content:center;
                           transition:opacity .2s;flex-shrink:0;">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
#chat-toggle-btn:hover { transform: scale(1.1); box-shadow: 0 10px 30px rgba(99,91,255,.6); }
#chat-clear-btn:hover  { background: rgba(255,255,255,.35) !important; }

.chat-msg-bot  { display:flex; justify-content:flex-start; }
.chat-msg-user { display:flex; justify-content:flex-end; }

.chat-bubble-bot {
    background:#fff;
    border:1px solid #e8e8ff;
    color:#333;
    border-radius:4px 16px 16px 16px;
    padding:10px 14px;
    font-size:.875rem;
    line-height:1.55;
    max-width:85%;
    box-shadow:0 2px 8px rgba(0,0,0,.06);
}
.chat-bubble-user {
    background:linear-gradient(135deg,#6c63ff,#4f46e5);
    color:#fff;
    border-radius:16px 4px 16px 16px;
    padding:10px 14px;
    font-size:.875rem;
    line-height:1.55;
    max-width:85%;
    box-shadow:0 2px 8px rgba(99,91,255,.3);
}

.chat-time {
    font-size:.68rem;
    color:#aaa;
    margin-top:3px;
    padding:0 4px;
}

.chat-chip {
    background:#fff;
    border:1.5px solid #d4cfff;
    color:#5b54e8;
    border-radius:20px;
    padding:5px 12px;
    font-size:.75rem;
    cursor:pointer;
    transition:all .2s;
    font-weight:500;
}
.chat-chip:hover { background:#6c63ff; color:#fff; border-color:#6c63ff; }

/* Typing animation */
.typing-indicator { display:flex;align-items:center;gap:4px;padding:10px 14px; }
.typing-indicator span {
    width:7px;height:7px;border-radius:50%;background:#9990ff;display:inline-block;
    animation:typingBounce .9s infinite ease-in-out;
}
.typing-indicator span:nth-child(2) { animation-delay:.2s; }
.typing-indicator span:nth-child(3) { animation-delay:.4s; }
@keyframes typingBounce { 0%,80%,100%{transform:scale(.6);opacity:.6} 40%{transform:scale(1);opacity:1} }

/* Scroll bar for messages */
#chat-messages::-webkit-scrollbar { width:5px; }
#chat-messages::-webkit-scrollbar-track { background:transparent; }
#chat-messages::-webkit-scrollbar-thumb { background:#d0ccff;border-radius:10px; }

/* Fade-in for messages */
@keyframes chatFadeIn { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:translateY(0)} }
.chat-msg-bot, .chat-msg-user { animation:chatFadeIn .25s ease; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn   = document.getElementById('chat-toggle-btn');
    const closeBtn    = document.getElementById('chat-close-btn');
    const clearBtn    = document.getElementById('chat-clear-btn');
    const chatWindow  = document.getElementById('chat-window');
    const chatForm    = document.getElementById('chat-form');
    const chatInput   = document.getElementById('chat-input');
    const chatMessages= document.getElementById('chat-messages');

    // Open / close
    toggleBtn.onclick = () => {
        const isHidden = chatWindow.style.display === 'none' || chatWindow.style.display === '';
        chatWindow.style.display = isHidden ? 'flex' : 'none';
        chatWindow.style.flexDirection = 'column';
        if (isHidden) chatInput.focus();
    };
    closeBtn.onclick = () => { chatWindow.style.display = 'none'; };

    // New Chat — clear session history
    clearBtn.onclick = () => {
        fetch('{{ route("chat.clear") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        // Reset UI (keep initial message)
        chatMessages.innerHTML = `
            <div class="chat-msg-bot">
                <div class="chat-bubble-bot">
                    👋 Chat has been reset! I'm <strong>Hub Guide AI</strong>. How can I help you?
                </div>
            </div>
            <div id="chat-suggestions" style="display:flex;flex-wrap:wrap;gap:6px;">
                <button class="chat-chip">🔍 Find Internships</button>
                <button class="chat-chip">📋 How to Apply?</button>
                <button class="chat-chip">✏️ Edit My Profile</button>
                <button class="chat-chip">📊 Track Application</button>
            </div>`;
        bindChips();
    };

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function getTime() {
        return new Date().toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});
    }

    function appendMessage(text, isUser = false) {
        // Remove suggestion chips once user sends first message
        const chips = document.getElementById('chat-suggestions');
        if (chips) chips.remove();

        const wrapClass   = isUser ? 'chat-msg-user' : 'chat-msg-bot';
        const bubbleClass = isUser ? 'chat-bubble-user' : 'chat-bubble-bot';

        const div = document.createElement('div');
        div.className = wrapClass;
        div.innerHTML = `
            <div style="display:flex;flex-direction:column;align-items:${isUser?'flex-end':'flex-start'}">
                <div class="${bubbleClass}">${text}</div>
                <span class="chat-time">${getTime()}</span>
            </div>`;
        chatMessages.appendChild(div);
        scrollToBottom();
    }

    function showTyping() {
        const div = document.createElement('div');
        div.className = 'chat-msg-bot';
        div.id = 'typing-indicator';
        div.innerHTML = `<div class="chat-bubble-bot typing-indicator"><span></span><span></span><span></span></div>`;
        chatMessages.appendChild(div);
        scrollToBottom();
        return div;
    }

    function sendMessage(text) {
        const typingEl = showTyping();

        fetch('{{ route("chat.message") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: text })
        })
        .then(res => res.json())
        .then(data => {
            typingEl.remove();
            appendMessage(data.reply || 'Sorry, I could not get a response.');
        })
        .catch(() => {
            typingEl.remove();
            appendMessage('⚠️ Connection error. Please check your internet and try again.');
        });
    }

    // Handle form
    chatForm.onsubmit = function(e) {
        e.preventDefault();
        const msg = chatInput.value.trim();
        if (!msg) return;
        appendMessage(msg, true);
        chatInput.value = '';
        sendMessage(msg);
    };

    // Focus input on Enter
    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            chatForm.dispatchEvent(new Event('submit'));
        }
    });

    function bindChips() {
        document.querySelectorAll('.chat-chip').forEach(btn => {
            btn.onclick = function () {
                const text = this.innerText.replace(/^[^\w]+/, '').trim();
                appendMessage(text, true);
                sendMessage(text);
            };
        });
    }
    bindChips();
});
</script>
