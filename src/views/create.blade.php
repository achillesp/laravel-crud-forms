@extends( $bladeLayout ?: config('crud-forms.blade_layout'))

@section(config('crud-forms.blade_section'))
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Add New {{ $title }}</h3>
            </div>
            <div class="panel-body">
                @include('crud-forms::_errors')
                <form action="{{ route("$route.store", $entity->id) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-12">
                            @include('crud-forms::form')
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        {{-- Back to resource index --}}
                        <div class="col-sm-3">
                            <a href="{{ route("$route.index") }}" class="btn btn-default btn-block">
                                <i class='fa fa-arrow-circle-left'></i> Back
                            </a>
                        </div>
                        {{-- Submit --}}
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class='fa fa-check-circle'></i> Submit Form
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
