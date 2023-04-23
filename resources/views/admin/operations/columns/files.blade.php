@php
    /**
     * @var $attachments
     */
@endphp
@foreach($attachments as $attachment)
    @php
        $extend = explode(".",$attachment)[1]??null;
    @endphp
    <button
        type="button"
        class="bg-white border-0 text-secondary"
        data-bs-toggle="popover"
        data-bs-offset="0,14"
        data-bs-placement="top"
        data-bs-html="true"
        data-bs-content="<p>{{$attachment}}</p> <div class='d-flex justify-content-between'><a href='{{$attachment}}' type='button' class='btn btn-sm btn-primary'>Download</button></div>"
        href="">
        <i class='bx bxs-file-{{$extend??null}}'></i>
    </button>
@endforeach
