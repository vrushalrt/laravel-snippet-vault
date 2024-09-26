<div class="card" style="width: 100%;">
    <div class="card-body">
        <h5 class="card-title">{{$title}}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $subtitle}}</h6>            
    </div> 
    <ul class="list-group list-group-flush"> 
        @foreach ($items as $itemKey => $item)
            <li class="list-group-item">
                
                @if(isset($isUsers) && $isUsers)
                    {{ $item->name}}    
                @endif
                
                @if(isset($isPosts) && $isPosts)
                    <a href="{{ route('posts.show', $item->id) }}">
                        {{ $item->title}}
                    </a>    
                @endif
                
            </li>
        @endforeach  
    </ul>
</div> {{-- card --}}