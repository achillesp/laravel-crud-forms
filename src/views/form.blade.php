@foreach ($fields as $field)

    <div class="form-group">
        @include( "crudforms.inputs.{$field['type']}")
    </div>

@endforeach