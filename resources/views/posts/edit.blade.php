
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post - Simple Blog</title>
</head>
<body>
    <h1>Edit Post</h1>

    <a href="{{ route('posts.show', $post) }}">Back to Post</a>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('posts.update', $post) }}">
        @csrf
        @method('PUT')

        <label for="title">Title</label>
        <input
            id="title"
            type="text"
            name="title"
            value="{{ old('title', $post->title) }}"
            required
        >

        <label for="content">Content</label>
        <textarea
            id="content"
            name="content"
            required
        >{{ old('content', $post->content) }}</textarea>

        <button type="submit">Update Post</button>
    </form>
</body>
</html>
