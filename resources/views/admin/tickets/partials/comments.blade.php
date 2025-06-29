<!-- resources/views/admin/tickets/partials/comments.blade.php -->
<div class="mt-5">
    <h4 class="fw-medium mb-4">Commentaires :</h4>
    <ul class="list-unstyled">
        @foreach ($ticket->comments as $comment)
            <li class="d-flex align-items-start bg-light border border-secondary-subtle rounded p-3 mb-3">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold me-3" 
                     style="width: 40px; height: 40px; font-size: 1rem;">
                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                </div>
                <div class="w-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold text-dark">{{ $comment->user->name }}</span>
                        <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="mt-2 mb-0 text-body">
                        {{ $comment->content }}
                    </p>
                </div>
            </li>
        @endforeach
    </ul>
</div>
