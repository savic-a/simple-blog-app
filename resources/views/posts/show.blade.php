
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $post->title }} - Simple Blog</title>
</head>
<body>
    <a href="{{ route('home') }}">Back to Home</a>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <h1>{{ $post->title }}</h1>
    <p>By {{ $post->user->name }}</p>
    <p>{{ $post->content }}</p>

    @can('update', $post)
        <a href="{{ route('posts.edit', $post) }}">Edit Post</a>
    @endcan

    @can('delete', $post)
        <form method="POST" action="{{ route('posts.destroy', $post) }}">
            @csrf
            @method('DELETE')

            <button type="submit">Delete Post</button>
        </form>
    @endcan
    
    <hr>

    <h2>Comments</h2>

    @forelse ($post->comments as $comment)
        <div>
            <strong>
                {{ $comment->user?->name ?? $comment->guest_name }}
            </strong>

            <p>{{ $comment->comment }}</p>

            @can('delete', $comment)
                <form method="POST"
                    action="{{ route('comments.destroy', $comment) }}">
                    @csrf
                    @method('DELETE')

                    <button type="submit">Delete Comment</button>
                </form>
            @endcan
        </div>
        <hr>
    @empty
        <p>No comments yet.</p>
    @endforelse

    <h3>Add a Comment</h3>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('comments.store', $post) }}">
        @csrf

        @guest
            <label for="guest_name">Your Name</label>
            <input
                id="guest_name"
                type="text"
                name="guest_name"
                value="{{ old('guest_name') }}"
                required
            >
        @endguest

        <label for="comment">Comment</label>
        <textarea
            id="comment"
            name="comment"
            required
        >{{ old('comment') }}</textarea>

        <button type="submit">Add Comment</button>
    </form>

</body>
</html>
