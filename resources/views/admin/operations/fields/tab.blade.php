<div class="col-md-12 mt-3">
    <div class="nav-align-top mb-4">
        <ul class="nav nav-tabs nav-fill" role="tablist">
            @foreach($field['fields'] as $key => $subField)
                <li class="nav-item">
                    <button type="button" class="nav-link @if($key==0) active @endif"
                            role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-{{$subField['name']}}"
                            aria-controls="navs-justified-home" aria-selected="true">
                        <img src="{{$subField['icon']}}" style="width: 2em;height: 2em;margin-right: 1em">
                         {{$subField['label']}}
                    </button>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($field['fields'] as $key => $subField)
                <div class="tab-pane fade show @if($key==0) active @endif" id="navs-{{$subField['name']}}" role="tabpanel">
                    @include("admin.operations.fields.".$subField['type'],['field'=>$subField])
                </div>
            @endforeach
        </div>
    </div>
</div>
