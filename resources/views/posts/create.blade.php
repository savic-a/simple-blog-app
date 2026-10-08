
@extends('layouts.app')

@section('title', 'Create Post - Simple Blog')

@section('content')
    <div class="form-container form-container-wide">
        <a href="{{ route('home') }}" class="back-link">
            &larr; Back to Home
        </a>

        <h1 class="page-title">Create New Post</h1>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('posts.store') }}">
            @csrf

            <div class="form-group">
                <label for="title">Title</label>
                <input
                    id="title"
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
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
                >{{ old('content') }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Create Post
                </button>

                <a href="{{ route('home') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection