{{-- Collection, so this is a belongsToMany, so we display a list of items --}}
@if (!empty($entity->{$field['name']}))
    <ul class="list-inside list-disc space-y-0.5">
    @foreach ($entity->{$field['name']} as $related)
        <li>{{ $related->{$field['relFieldName']} }}</li>
    @endforeach
    </ul>
@endif
