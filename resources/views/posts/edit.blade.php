
@extends('layouts.app')

@section('title', 'Edit Post - Simple Blog')

@section('content')
    <div class="form-container form-container-wide">
        <a href="{{ route('posts.show', $post) }}" class="back-link">
            &larr; Back to Post
        </a>

        <h1 class="page-title">Edit Post</h1>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('posts.update', $post) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title</label>
                <input
                    id="title"
                    type="text"
                    name="title"
                    value="{{ old('title', $post->title) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea
                    id="content"
                    name="content"
                    rows="10"
                    required
                >{{ old('content', $post->content) }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Update Post
                </button>

                <a href="{{ route('posts.show', $post) }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection