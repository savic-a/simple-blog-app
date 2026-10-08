
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
</head>
<body>
    <header>
        <h1>Simple Blog</h1>

        @auth
            <p>Welcome, {{ auth()->user()->name }}!</p>

            <a href="{{ route('posts.create') }}">Create New Post</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </header>

    <hr>

    <main>
        <h2>Latest Posts</h2>

        @forelse ($posts as $post)
            <article>
                <h3> 
                    <a href="{{ route('posts.show', $post) }}">
                        {{ $post->title }}
                    </a>
                </h3>

                <p>By {{ $post->user->name }}</p>

                <p>{{ $post->content }}</p>

                <hr>
            </article>
        @empty
            <p>No posts available yet.</p>
        @endforelse

        {{ $posts->links() }}
    </main>
</body>
</html>
