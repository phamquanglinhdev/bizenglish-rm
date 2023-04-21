@push('page_css')

@endpush
@php
    /**
     * @var  array $field
     */
        if (!is_array($field['value'])){
            $field['value']=json_decode($field['value']);
        }
@endphp
    <!-- Form Repeater -->
<div class="col-12 mt-3">
    <div class="card">
        <h5 class="card-header">{{$field["label"]}}</h5>
        <div class="card-body">
            <div class="form-repeater">
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
                                    <div class="col-md-2">
                                        <label class="form-label mt-1 mb-2">Xóa hàng</label>
                                        <div>
                                            <button type="button" class="btn btn-label-danger" data-repeater-delete>
                                                <i class="bx bx-trash me-1"></i>
                                            </button>
                                        </div>
                                    </div>
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
    <script src="{{asset("js/forms-extras.js")}}"></script>
@endpush
