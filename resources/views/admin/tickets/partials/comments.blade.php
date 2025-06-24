<!-- resources/views/admin/tickets/partials/comments.blade.php -->
<div>
    <h4 class="font-medium">Commentaires :</h4>
    <ul class="space-y-4">
        @foreach ($ticket->comments as $comment)
            <li class="flex items-start bg-gray-50 border border-gray-200 rounded-xl p-4">
                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center font-bold text-lg">
                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                </div>
                <div class="ml-4 w-full">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-800">{{ $comment->user->name }}</span>
                        <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="mt-2 text-gray-700 leading-relaxed">
                        {{ $comment->content }}
                    </p>
                </div>
            </li>
        @endforeach
    </ul>
</div>
