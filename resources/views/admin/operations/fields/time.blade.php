<div class="{{$field['class']??"col-md-12"}}">
    <label for="{{$field['name']}}" class="form-label mb-1 mt-2">{{$field['label']}}</label>
    <input name="{{$field['name']}}" type="time" class="form-control"
           value="{{$field['value']??old($field['name'])??null}}"/>
    @error($field['name'])
    <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
