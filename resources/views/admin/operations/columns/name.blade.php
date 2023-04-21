@php
    /**
     * @var $entry
     * @var $collection
     */
@endphp

<a href="{{route($entry.".show",$collection["id"])}}">
    {{$collection["name"]}}
</a>
