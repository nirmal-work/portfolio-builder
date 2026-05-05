<div x-data="chatbot()" class="fixed bottom-4 right-4 z-50">
    <!-- Chat Widget -->
    <div x-show="open" x-transition class="w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg flex flex-col max-h-96">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 rounded-t-lg flex justify-between items-center">
            <h3 class="font-semibold">Ask me anything about this portfolio</h3>
            <button @click="open = false" class="text-white hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50 dark:bg-gray-700">
            <template x-for="msg in messages" :key="msg.id">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="msg.role === 'user' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-white'" class="rounded-lg px-4 py-2 max-w-xs">
                        <p class="text-sm" x-text="msg.content"></p>
                    </div>
                </div>
            </template>
            <div x-show="loading" class="flex justify-start">
                <div class="bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-white rounded-lg px-4 py-2">
                    <div class="flex space-x-2">
                        <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input -->
        <div class="border-t dark:border-gray-700 p-4">
            <form @submit="sendMessage" class="flex gap-2">
                <input x-model="input" type="text" placeholder="Type a message..." class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:outline-none focus:border-blue-500 dark:bg-gray-600 dark:text-white" />
                <button type="submit" :disabled="loading || !input.trim()" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg disabled:opacity-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Toggle Button -->
    <button x-show="!open" @click="open = true" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-full p-4 shadow-lg flex items-center justify-center">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
    </button>
</div>

<script>
function chatbot() {
    return {
        open: false,
        input: '',
        loading: false,
        messages: [
            {
                id: 1,
                role: 'assistant',
                content: 'Hi! I\'m an AI assistant. Ask me anything about this portfolio!',
            },
        ],
        slug: "{{ request()->route('slug') ?? '' }}",

        async sendMessage(e) {
            e.preventDefault();
            if (!this.input.trim() || this.loading) return;

            const userMessage = this.input.trim();
            this.messages.push({
                id: Date.now(),
                role: 'user',
                content: userMessage,
            });

            this.input = '';
            this.loading = true;

            try {
                const response = await fetch('{{ route('chatbot.chat') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        message: userMessage,
                        profile_slug: this.slug,
                    }),
                });

                const data = await response.json();

                if (response.ok) {
                    this.messages.push({
                        id: Date.now(),
                        role: 'assistant',
                        content: data.reply,
                    });
                } else {
                    this.messages.push({
                        id: Date.now(),
                        role: 'assistant',
                        content: 'Sorry, I encountered an error. Please try again later.',
                    });
                }
            } catch (error) {
                this.messages.push({
                    id: Date.now(),
                    role: 'assistant',
                    content: 'Network error. Please try again.',
                });
            } finally {
                this.loading = false;
                // Auto-scroll to bottom
                setTimeout(() => {
                    document.querySelector('[x-data="chatbot()"]').querySelector('.overflow-y-auto').scrollTop = 
                    document.querySelector('[x-data="chatbot()"]').querySelector('.overflow-y-auto').scrollHeight;
                }, 0);
            }
        },
    };
}
</script>
