<form class="delete-post-form d-inline" action="/post/{{$post->id}}" method="POST">
    @method('DELETE')
    @csrf
    <button class="delete-post-button text-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i
            class="fas fa-trash"></i></button>
</form>

