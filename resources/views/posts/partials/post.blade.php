
<h3><a href="{{ route('posts.show', ['post' => $post->id]) }}" class="">{{ $post->title }}</a></h3>

<div class="mb-3">
    <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
    <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post">
        @csrf
        @method('DELETE')

        <input type="submit" value="Delete" class="btn btn-primary">
    </form>
</div>