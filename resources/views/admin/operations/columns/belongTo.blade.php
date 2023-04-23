@php
    /**
     * @var $entry
    * @var $object
     */
    $object = json_decode($object)
@endphp
@if($object)
    <a class="badge bg-label-primary" href="{{url($entry."/".$object->id)}}">{{$object->name}}</a>
@endif

