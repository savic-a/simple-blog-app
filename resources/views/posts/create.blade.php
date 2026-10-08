
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
</head>
<body>
    <h1>Create New Post</h1>

    <a href="{{ route('home') }}">Back to Home</a>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('posts.store') }}">
        @csrf

        <label for="title">Title</label>
        <input
            id="title"
            type="text"
            name="title"
            value="{{ old('title') }}"
            required
        >

        <label for="content">Content</label>
        <textarea
            id="content"
            name="content"
            required
        >{{ old('content') }}</textarea>

        <button type="submit">Create Post</button>
    </form>
</body>
</html>
