@extends('layouts.app')

@section('content')
  <div class="bg-white p-3 post-card">
    @if ($post->hasThumbnail())
      {{ Html::image($post->thumbnail()->url, $post->thumbnail()->original_filename, ['class' => 'img-fluid rounded']) }}
    @endif

    <h1>{{ $post->title }}</h1>

    <div class="mb-3">
      <small class="text-muted">{{ link_to_route('users.show', $post->author->fullname, $post->author) }}</small>,
      <small class="text-muted">{{ humanize_date($post->posted_at) }}</small>
    </div>

    <div class="excerpt">
      {{ $post->excerpt }}
    </div>

    <div class="post-content">
      {!! $post->content !!}
    </div>

    <p class="mt-3">
      <like
        likes_count="{{ $post->likes_count }}"
        liked="{{ $post->isLiked() }}"
        item_id="{{ $post->id }}"
        item_type="posts"
        logged_in="{{ Auth::check() }}"
      ></like>
    </p>
  </div>

  @include ('comments/_list')
@endsection
