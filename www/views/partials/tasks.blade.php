@foreach ($tasks as $c)
    <option value="{{ $c['id'] }}"
        @isset ($task['id'])
            @if ($task['id'] == $c['id'])
                hidden
            @endif
            @if ($task['parent_id'] == $c['id'])
                selected
            @endif
        @endisset
    >
        {!! $delimiter !!}#{{$c['id']}} ({{ $c['title'] }})
    </option>
@endforeach