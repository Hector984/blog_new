@extends('layouts.app')

@section('title', 'Blog posts')

@section('content')

    @foreach($posts as $post)

        @include('posts.partials.post')

    @endforeach

@endsection('content')