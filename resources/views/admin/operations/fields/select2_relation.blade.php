@php
    /**
     * @var $field
     */
@endphp
@push("page_css")
    <link rel="stylesheet" href="{{asset("vendor/libs/select2/select2.css")}}"/>
@endpush
<div class="{{$field['class']??"col-md-12"}} mb-4 mt-2 mb-md-0">
    <label for="{{$field["name"]}}" class="form-label">{{$field['label']}}</label>
    <div class="select2-{{$field["color"]??"success"}}">
        <select id="{{$field["name"]}}" name="{{$field['name']}}[]" class="select2 form-select" multiple>
            @foreach($field['options'] as $key => $option)
                @if(in_array($key,$field['value']??[]))
                    <option value="{{$key}}" selected>{{$option}} </option>
                @else
                    <option value="{{$key}}">{{$option}} </option>
                @endif
            @endforeach
        </select>
    </div>
    @error($field['name'])
    <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
@push("page_js")
    <script src="{{asset("vendor/libs/select2/select2.js")}}"></script>
    <script src="{{asset("js/forms-selects.js")}}"></script>
@endpush
