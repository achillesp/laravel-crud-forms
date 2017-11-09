{{-- Collection, so this is a belongsToMany, so we display a list of items --}}
@if (!empty($entity->{$field['name']}))
    <ul>
    @foreach ($entity->{$field['name']} as $related)
        <li>{{ $related->{$field['relFieldName']} }}</li>
    @endforeach
    </ul>
@endif