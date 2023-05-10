@php
    /**
     * @var array $objects
    * @var string $entry
    * @var int $count
    */
    $count = 0
@endphp
@foreach($objects as $key =>  $object)
    @if($count<2)
        <a class="badge bg-label-primary" href="{{url($entry."/".$key)}}">{{$object}}</a>

    @endif
    @php
        $count++
    @endphp
@endforeach
@if(count($objects)>1)
    ...
@endif
