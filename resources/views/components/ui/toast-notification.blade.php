<!-- resources/views/components/ui/toast-notification.blade.php -->
<div
    x-data="{
        show: false,
        notification: null,
        init() {
            this.pollForNotifications();
        },
        pollForNotifications() {
            setInterval(() => {
                fetch('{{ route('notifications.get-latest') }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data && (!this.notification || this.notification.id !== data.id)) {
                            this.notification = data;
                            this.show = true;
                        }
                    });
            }, 15000); // Poll every 15 seconds
        },
        markAsRead() {
            fetch(`/notifications/${this.notification.id}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                this.show = false;
                setTimeout(() => this.notification = null, 500);
            });
        }
    }"
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed bottom-5 right-5 w-full max-w-sm bg-white dark:bg-gray-800 shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden"
    style="display: none;"
>
    <div class="p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0" x-text="notification ? notification.data.icon : ''">
                <!-- Icon will be inserted here -->
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="notification ? notification.data.title : ''"></p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400" x-text="notification ? notification.data.message : ''"></p>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
                <button @click="markAsRead()" class="bg-white dark:bg-gray-800 rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
