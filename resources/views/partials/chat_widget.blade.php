<div id="chat-widget-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
    <!-- Chat Button -->
    <button id="chat-toggle-btn" class="btn btn-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; transition: all 0.3s ease;">
        <i class="fas fa-robot fa-lg"></i>
    </button>

    <!-- Chat Window -->
    <div id="chat-window" class="card shadow-lg d-none" style="position: absolute; bottom: 80px; right: 0; width: 350px; border-radius: 15px; overflow: hidden; height: 450px; border: none;">
        <!-- Header -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-brain me-2"></i>
                <h6 class="mb-0 fw-bold">Hub Guide AI</h6>
            </div>
            <button type="button" class="btn-close btn-close-white" id="chat-close-btn"></button>
        </div>

            <!-- Chat Body -->
        <div class="card-body p-0 d-flex flex-column bg-light" style="overflow-y: auto; height: 100%;">
            <div id="chat-messages" class="p-3" style="flex: 1; overflow-y: auto;">
                <!-- Initial Bot Message -->
                <div class="message bot-message mb-3">
                    <div class="d-flex flex-column align-items-start">
                        <div class="p-2 rounded bg-white shadow-sm" style="max-width: 85%; font-size: 0.9rem;">
                            Hello! 👋 I'm your Bright Future Hub Guide. I can help you find opportunities and navigate the portal. Try clicking a suggestion below!
                        </div>
                        <small class="text-muted mt-1" style="font-size: 0.7rem;">Now</small>
                    </div>
                </div>
            </div>

            <!-- Suggestions -->
            <div id="chat-suggestions" class="px-3 pb-2 d-flex flex-wrap gap-1">
                <button class="btn btn-outline-primary btn-sm chat-suggestion" style="font-size: 0.75rem; border-radius: 15px;">How to apply?</button>
                <button class="btn btn-outline-primary btn-sm chat-suggestion" style="font-size: 0.75rem; border-radius: 15px;">Find Internships</button>
                <button class="btn btn-outline-primary btn-sm chat-suggestion" style="font-size: 0.75rem; border-radius: 15px;">Edit Profile</button>
                <button class="btn btn-outline-primary btn-sm chat-suggestion" style="font-size: 0.75rem; border-radius: 15px;">Track Application</button>
            </div>

            <!-- Chat Footer -->
            <div class="card-footer bg-white p-3 border-0">
                <form id="chat-form" class="input-group">
                    <input type="text" id="chat-input" class="form-control border-0 bg-light" placeholder="Type your message..." style="border-radius: 20px 0 0 20px; font-size: 0.9rem;">
                    <button class="btn btn-primary d-flex align-items-center justify-content-center" type="submit" style="border-radius: 0 20px 20px 0; width: 45px;">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    #chat-toggle-btn:hover {
        transform: scale(1.1) rotate(5deg);
    }
    .message.user-message {
        display: flex;
        justify-content: flex-end;
    }
    .message.user-message .p-2 {
        background: #0d6efd !important;
        color: white;
    }
    #chat-messages::-webkit-scrollbar {
        width: 5px;
    }
    #chat-messages::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    #chat-messages::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }
    @keyframes typing {
        0% { opacity: 0.3; }
        50% { opacity: 1; }
        100% { opacity: 0.3; }
    }
    .typing-dot {
        animation: typing 1s infinite;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('chat-toggle-btn');
    const closeBtn = document.getElementById('chat-close-btn');
    const chatWindow = document.getElementById('chat-window');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');

    // Toggle Chat
    toggleBtn.onclick = () => chatWindow.classList.toggle('d-none');
    closeBtn.onclick = () => chatWindow.classList.add('d-none');

    // Handle Suggestions
    document.querySelectorAll('.chat-suggestion').forEach(btn => {
        btn.onclick = function() {
            const text = this.innerText;
            appendMessage(text, true);
            sendMessage(text);
        };
    });

    // Auto Scroll
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Append Message
    function appendMessage(text, isUser = false) {
        const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const alignment = isUser ? 'align-items-end' : 'align-items-start';
        const bgColor = isUser ? 'bg-primary text-white' : 'bg-white';
        const msgClass = isUser ? 'user-message' : 'bot-message';

        const msgHtml = `
            <div class="message ${msgClass} mb-3 animate__animated animate__fadeInUp animate__faster">
                <div class="d-flex flex-column ${alignment}">
                    <div class="p-2 rounded shadow-sm ${bgColor}" style="max-width: 85%; font-size: 0.9rem;">
                        ${text}
                    </div>
                    <small class="text-muted mt-1" style="font-size: 0.7rem;">${time}</small>
                </div>
            </div>
        `;
        chatMessages.insertAdjacentHTML('beforeend', msgHtml);
        scrollToBottom();
    }

    // Send Message Logic
    function sendMessage(text) {
        // Typing indicator
        const typingId = 'typing-' + Date.now();
        const typingHtml = `<div id="${typingId}" class="message bot-message mb-3">
            <div class="d-flex flex-column align-items-start">
                <div class="p-2 rounded bg-white shadow-sm" style="font-size: 0.9rem;">
                    Typing<span class="typing-dot">.</span><span class="typing-dot" style="animation-delay: 0.2s">.</span><span class="typing-dot" style="animation-delay: 0.4s">.</span>
                </div>
            </div>
        </div>`;
        chatMessages.insertAdjacentHTML('beforeend', typingHtml);
        scrollToBottom();

        // AJAX Request
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
            const typingEl = document.getElementById(typingId);
            if(typingEl) typingEl.remove();
            appendMessage(data.reply);
        })
        .catch(err => {
            const typingEl = document.getElementById(typingId);
            if(typingEl) typingEl.remove();
            appendMessage("Sorry, I encountered an error. Please try again later.");
        });
    }

    // Handle Form Submit
    chatForm.onsubmit = function(e) {
        e.preventDefault();
        const message = chatInput.value.trim();
        if(!message) return;

        appendMessage(message, true);
        chatInput.value = '';
        sendMessage(message);
    }
});
</script>
