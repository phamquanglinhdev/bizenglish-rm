<div class="{{$field['class']??"col-md-12"}}">

    <label for="{{$field['name']}}" class="form-label mb-1 mt-2">{{$field['label']}}</label>
    @if(isset($field['value']))
        {{--        @dd($field['value'])--}}
        <input value="{{$field['value']}}" name="{{$field['name']}}-old" hidden="">
        <div class="mb-2">
            <a href="{{url($field['value'])}}" class="badge bg-label-primary" target="_blank">
                <i class='bx bxs-file-blank'></i>
                {{str_ireplace("/uploads/","",$field['value'])}}
            </a>
        </div>
    @endif
    <input value="{{$field['value']??null}}" class="form-control" type="file" id="{{$field['name']}}"
           name="{{$field['name']}}">


</div>
