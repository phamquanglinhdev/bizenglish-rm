@php
    /**
     * @var array $objects
    * @var string $entry
    */
@endphp
@foreach($objects as $key =>  $object)
    <a class="badge bg-label-primary" href="{{url($entry."/".$key)}}">{{$object}}</a>
@endforeach
