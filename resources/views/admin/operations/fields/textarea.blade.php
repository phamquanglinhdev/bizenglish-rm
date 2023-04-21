<div class="{{$field['class']??"col-md-12"}}">
    <label for="{{$field['name']}}" class="form-label mb-1 mt-2">{{$field['label']}}</label>
    <textarea rows="3" name="{{$field['name']}}" type="text" class="form-control">{{$field['value']??""}}</textarea>
    @error($field['name'])
    <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
