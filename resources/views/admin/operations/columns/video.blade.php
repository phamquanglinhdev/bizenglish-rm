@php
    /**
     * @var  $video
     */
    $video=json_decode($video);
@endphp
<div>
    @if($video)
        <a href="{{$video->url}}">
            <i class='bx bxl-youtube text-danger'></i> Xem
        </a>
    @endif
</div>
