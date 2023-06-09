<div class="{{$field['class']??"col-md-12"}}">
    <label for="{{$field['name']}}" class="form-label mb-1 mt-2">{{$field['label']}}</label>
    @if(isset($field['value']))
        <input value="{{$field['value']}}" name="{{$field['name']}}-old" hidden="">
        <div class="mb-2">
            @foreach(json_decode($field['value']) as $file)
                <a href="{{url($file)}}" class="badge bg-label-primary" target="_blank">
                    <i class='bx bxs-file-blank'></i>
                    {{str_ireplace("/uploads/","",$file)}}
                </a>
            @endforeach
        </div>
    @endif
    <input value="{{$field['value']??null}}" class="form-control" type="file" id="{{$field['name']}}"
           name="{{$field['name']}}[]" multiple="">


</div>
