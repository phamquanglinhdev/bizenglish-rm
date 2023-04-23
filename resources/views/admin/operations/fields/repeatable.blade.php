@push('page_css')

@endpush
@php
    /**
     * @var  array $field
     */
        if (!is_array($field['value'])){
            $field['value']=json_decode($field['value']);
        }
        $field['single'] = $field['single'] ?? false;
@endphp
    <!-- Form Repeater -->
<div class="col-12 mt-3 mb-2">
    <label for="{{$field['name']}}" class="form-label">{{$field['label']}}</label>
    <div class="card">
        <div class="card-body">
            <div class="repeat-{{$field['name']}}">
                <div data-repeater-list="{{$field['name']}}">
                    @if($field['value'])
                        @foreach($field['value'] as $key => $row)
                            <div data-repeater-item class="mb-2">
                                <div class="row align-items-center">
                                    @foreach($field['sub_fields'] as $sub_field)
                                        @php
                                            $values = (array)$field['value'][$key];
                                            $sub_field['value'] = $values[$sub_field['name']]
                                        @endphp
                                        @include("admin.operations.fields.".$sub_field['type'],['field'=>$sub_field])
                                    @endforeach
                                    @if(!$field['single'])
                                        <div class="col-md-2">
                                            <label class="form-label mt-1 mb-2">Xóa hàng</label>
                                            <div>
                                                <button type="button" class="btn btn-label-danger" data-repeater-delete>
                                                    <i class="bx bx-trash me-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div data-repeater-item class="mb-2">
                            <div class="row align-items-center">
                                @foreach($field['sub_fields'] as $sub_field)
                                    @include("admin.operations.fields.".$sub_field['type'],['field'=>$sub_field])
                                @endforeach
                                @if(!$field['single'])
                                    <div class="col-md-2">
                                        <label class="form-label mt-1 mb-2">Xóa hàng</label>
                                        <div>
                                            <button type="button" class="btn btn-label-danger" data-repeater-delete>
                                                <i class="bx bx-trash me-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                @if(!$field['single'])
                    <div class="mb-0 mt-3">
                        <button class="btn btn-primary" type="button" data-repeater-create>
                            <i class="bx bx-plus me-1"></i>
                            <span class="align-middle">{{$field['new_label']??"Thêm một hàng"}}</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- /Form Repeater -->
@push("page_js")
    <script src="{{asset("vendor/libs/jquery-repeater/jquery-repeater.js")}}"></script>
    <script>
        "use strict";
        $(function () {
            var n, o, t = $(".repeat-{{$field['name']}}");
            t.length && (n = 2, o = 0, t.on("submit", function (e) {
                e.preventDefault()
            }), t.repeater({
                show: function () {
                    var r = $(this).find(".form-control, .form-select"), a = $(this).find(".form-label");
                    r.each(function (e) {
                        var t = "form-repeater-" + n + "-" + o;
                        $(r[e]).attr("id", t), $(a[e]).attr("for", t), o++
                    }), n++, $(this).slideDown()
                }, hide: function (e) {
                    $(this).slideUp(e)
                }
            }))
        });

    </script>
@endpush
