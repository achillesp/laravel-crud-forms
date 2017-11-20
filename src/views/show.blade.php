@extends( $bladeLayout ?: config('crud-forms.blade_layout'))

@section(config('crud-forms.blade_section'))
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $title }} Details</h3>
                </div>

                <div class="panel-body">
                    <ul>
                        @foreach ($fields as $field)
                            <li>
                                <strong>{{ $field['label'] }}</strong>:
                                @include( "crud-forms::displays.{$field['type']}")
                            </li>

                        @endforeach
                    </ul>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        {{-- Back to resource index --}}
                        <div class="col-sm-3">
                            <a href="{{ route("$route.index") }}" class="btn btn-default btn-block">
                                <i class='fa fa-arrow-circle-left'></i> Back to Index
                            </a>
                        </div>
                        {{-- Edit resource --}}
                        <div class="col-sm-3 col-sm-offset-3">
                            <a href="{{ route("$route.edit", $entity->id ) }}" class="btn btn-warning btn-block">
                                <i class='fa fa-edit'></i> Edit {{ $title }}
                            </a>
                        </div>
                        {{-- Delete resource --}}
                        <div class="col-sm-3">

                            <form action="{{ route("$route.destroy", $entity->id) }}" method="POST" style="display: inline-block;">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="btn btn-danger delete-btn btn-block" type="submit">
                                    <i class="fa fa-remove"></i> Delete {{ $title }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
