
@extends('layouts.app')

@section('title', $post->title . ' - Simple Blog')

@section('content')
    <a href="{{ route('home') }}" class="back-link">
        &larr; Back to Home
    </a>

    <article class="post-detail">
        <h1 class="post-detail-title">{{ $post->title }}</h1>

        <p class="post-meta">
            By {{ $post->user->name }}
            &middot;
            {{ $post->created_at->format('M d, Y') }}
        </p>

        <div class="post-body">{{ $post->content }}</div>

        @canany(['update', 'delete'], $post)
            <div class="post-actions">
                @can('update', $post)
                    <a href="{{ route('posts.edit', $post) }}"
                       class="btn btn-secondary">
                        Edit Post
                    </a>
                @endcan

                @can('delete', $post)
                    <form method="POST"
                          action="{{ route('posts.destroy', $post) }}">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">
                            Delete Post
                        </button>
                    </form>
                @endcan
            </div>
        @endcanany
    </article>

    <section class="comments-section">
        <h2 class="section-title">
            Comments ({{ $post->comments->count() }})
        </h2>

        @forelse ($post->comments as $comment)
            <div class="comment-card">
                <div class="comment-header">
                    <div>
                        <strong>
                            {{ $comment->user?->name ?? $comment->guest_name }}
                        </strong>

                        <span class="comment-date">
                            {{ $comment->created_at->format('M d, Y') }}
                        </span>
                    </div>

                    @can('delete', $comment)
                        <form method="POST"
                              action="{{ route('comments.destroy', $comment) }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="text-danger">
                                Delete
                            </button>
                        </form>
                    @endcan
                </div>

                <p class="comment-text">{{ $comment->comment }}</p>
            </div>
        @empty
            <p class="empty-message">No comments yet.</p>
        @endforelse
    </section>

    <section class="comment-form-section">
        <h2 class="section-title">Add a Comment</h2>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('comments.store', $post) }}">
            @csrf

            @guest
                <div class="form-group">
                    <label for="guest_name">Your Name</label>
                    <input
                        id="guest_name"
                        type="text"
                        name="guest_name"
                        value="{{ old('guest_name') }}"
                        required
                    >
                </div>
            @endguest

            <div class="form-group">
                <label for="comment">Comment</label>
                <textarea
                    id="comment"
                    name="comment"
                    rows="5"
                    required
                >{{ old('comment') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Add Comment
            </button>
        </form>
    </section>
@endsection