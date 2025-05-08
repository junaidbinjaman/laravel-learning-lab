<x-profile :sharedData="$sharedData" doctitle="{{$sharedData['username']}}' profile ">
    <div class="list-group">
        @foreach($posts as $post)
            <x-post :post="$post" hide-author />
        @endforeach
    </div>
</x-profile>
