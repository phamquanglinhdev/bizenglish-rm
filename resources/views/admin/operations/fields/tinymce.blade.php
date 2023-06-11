<div class="{{$field['class']??"col-md-12"}}">
    <label for="{{$field['name']}}" class="form-label mb-1 mt-2">{{$field['label']}}</label>
    <textarea rows="3" name="{{$field['name']}}" id="{{$field["name"]}}" type="text" class="form-control">{{$field['value']??""}}</textarea>
    @error($field['name'])
    <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<script
    src="https://cdn.tiny.cloud/1/v9a3hkc5xsw542n1csexyl6eaveglb8el5zminkjlklbn3v4/tinymce/6/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#{{$field["name"]}}',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
</script>
