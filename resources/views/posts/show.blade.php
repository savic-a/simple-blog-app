
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
</body>
</html>
