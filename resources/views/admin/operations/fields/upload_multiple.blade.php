<div class="{{$field['class']??"col-md-12"}}">
    <label for="{{$field['name']}}" class="form-label mb-1 mt-2">{{$field['label']}}</label>
    <input value="{{$field['value']}}" class="form-control" type="file" id="{{$field['name']}}"
           name="{{$field['name']}}" multiple="">
</div>
