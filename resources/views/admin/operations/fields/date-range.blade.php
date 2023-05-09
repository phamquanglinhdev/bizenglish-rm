<div class="{{$field['class']??"col-md-12"}}">
    <label for="bs-rangepicker-dropdown" class="form-label">{{$field["label"]}}</label>
    <input type="text" name="{{$field["name"]}}" value="{{$field["value"]}}" id="{{$field["name"]}}"
           class="form-control">
</div>
@push("page_js")
    <script>
        $(document).ready(function () {
            $("#{{$field["name"]}}").daterangepicker({
                showDropdowns: !0,
                opens: isRtl ? "left" : "right",
                cancelLabel: 'Clear',
                format: 'dd/mm/yy'
            })
            @if($field['value'])
            $("#{{$field["name"]}}").val('{{$field['value']}}')
            @else
            $("#{{$field["name"]}}").val('')
            @endif
        })
    </script>
@endpush
