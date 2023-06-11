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
            @if(isset($field['nullable']))
                <option></option>
            @endif
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
    <script>
        "use strict";
        $(function () {
            var e = $(".selectpicker"), t = $("#{{$field["name"]}}"), i = $(".select2-icons");

            function l(e) {
                return e.id ? "<i class='bx bxl-" + $(e.element).data("icon") + " me-2'></i>" + e.text : e.text
            }

            e.length && e.selectpicker(), t.length && t.each(function () {
                var e = $(this);
                e.wrap('<div class="position-relative"></div>').select2({
                    placeholder: "Select value",
                    dropdownParent: e.parent(),
                    disabled: {{isset($field["disable"])?"true":"false"}},
                })
            }), i.length && i.wrap('<div class="position-relative"></div>').select2({
                templateResult: l,
                templateSelection: l,
                escapeMarkup: function (e) {
                    return e
                }
            })
        });

    </script>
@endpush
