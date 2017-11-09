{{-- BelongsTo, so single item --}}
@if (!empty($entity->{$field['name']}))
    {{ $entity->{$field['relationship']}->{$field['relFieldName']} }}
@endif