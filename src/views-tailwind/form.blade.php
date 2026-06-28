@foreach ($fields as $field)

    <div class="mb-5">
        @include( "crud-forms::inputs.{$field['type']}")
    </div>

@endforeach
