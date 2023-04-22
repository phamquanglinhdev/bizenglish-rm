<!-- Popover on top -->
@if($text!=null && $text!="null")
    <button type="button"
            class="bg-white border-0 text-secondary"
            data-bs-toggle="popover"
            data-bs-offset="0,14"
            data-bs-placement="top"
            data-bs-html="true"
            data-bs-content="{{$text}}"
            title="">
        {{\Illuminate\Support\Str::limit($text,$limit??20)}}
    </button>
@endif
