<div>
    <input type="text" wire:model.live="searchTerm">
    @if(count($results) > 0)
        @foreach($results as $post)
            <li>{{$post->title}}</li>
        @endforeach
    @endif
</div>
