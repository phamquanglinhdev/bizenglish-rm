<div class="{{$field['class']??"col-md-12"}}">
    <label for="{{$field['name']}}" class="form-label mt-1 mb-2">{{$field['label']??$field['name']}}</label>
    <select id="{{$field['name']}}" name="{{$field['name']}}" class="form-select">
        @foreach($field['options'] as $key => $option)
            @if(isset($field['value']))
                @if($key==$field['value'])
                    <option value="{{$key}}" selected>{{$option}}</option>
                @else
                    <option value="{{$key}}">{{$option}}</option>
                @endif
            @else
                <option value="{{$key}}">{{$option}}</option>
            @endif
        @endforeach
    </select>
</div>
