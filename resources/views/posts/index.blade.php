@extends('layouts.app')

@section('title', 'Blog posts')

@section('content')

    @if( !$posts->isEmpty() )
        @foreach($posts as $post)

            @include('posts.partials.post')

        @endforeach
    @else
        <h2 class="alert alert-info">No blog posts yet</h2>
    @endif

@endsection('content')