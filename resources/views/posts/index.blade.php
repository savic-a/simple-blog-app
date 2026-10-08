
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Posts - Simple Blog</title>
</head>
<body>
    <h1>All Posts</h1>

    <a href="{{ route('home') }}">Home</a>

    @auth
        <a href="{{ route('posts.create') }}">Create New Post</a>
    @endauth

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @forelse ($posts as $post)
        <article>
            <h2>
                <a href="{{ route('posts.show', $post) }}">
                    {{ $post->title }}
                </a>
            </h2>

            <p>By {{ $post->user->name }}</p>
            <p>{{ Str::limit($post->content, 200) }}</p>
        </article>
        <hr>
    @empty
        <p>No posts available.</p>
    @endforelse

    {{ $posts->links() }}
</body>
</html>
