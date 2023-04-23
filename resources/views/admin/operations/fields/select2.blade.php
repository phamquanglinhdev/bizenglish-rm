@php
    /**
     * @var $field
     */
    $field['value'] = $field['value']??-1
@endphp
@push("page_css")
    <link rel="stylesheet" href="{{asset("vendor/libs/select2/select2.css")}}"/>
@endpush
<div class="{{$field['class']??"col-md-12"}}  mb-md-0">
    <label for="{{$field["name"]}}" class="form-label mb-1 mt-2">{{$field['label']}}</label>
    <div class="select2-{{$field["color"]??"success"}} mb-3">
        <select id="{{$field["name"]}}" name="{{$field['name']}}" class="select2 form-select">
            @foreach($field['options'] as $key => $option)
                @if($key==$field['value'])
                    )
                    <option value="{{$key}}" selected>{{$option}} </option>
                @else
                    <option value="{{$key}}">{{$option}} </option>
                @endif
            @endforeach
        </select>
    </div>
</div>
@push("page_js")
    <script src="{{asset("vendor/libs/select2/select2.js")}}"></script>
    <script src="{{asset("js/forms-selects.js")}}"></script>
@endpush
