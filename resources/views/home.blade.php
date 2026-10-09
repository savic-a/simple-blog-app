
@extends('layouts.app')

@section('title', 'Home - Simple Blog')

@section('content')
    <h1 class="page-title">Latest Posts</h1>

    @forelse ($posts as $post)
        <article class="post-card">
            <h2>
                <a href="{{ route('posts.show', $post) }}">
                    {{ $post->title }}
                </a>
            </h2>

            <p class="post-meta">
                By {{ $post->user->name }}
                &middot;
                {{ $post->created_at->format('M d, Y') }}
            </p>

            <p class="post-excerpt">
                {{ Str::limit($post->content, 200) }}
            </p>

            <a href="{{ route('posts.show', $post) }}" class="read-more">
                Read more &rarr;
            </a>
        </article>
    @empty
        <p>No posts available yet.</p>
    @endforelse

    <div class="pagination">
        {{ $posts->links() }}
    </div>
@endsection