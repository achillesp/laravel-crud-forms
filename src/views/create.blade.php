@extends($bladeLayout)

@section('main-content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Add New {{ $title }}</h3>
            </div>
            <div class="panel-body">
                @if (count($errors) > 0)
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div id="validationErrors" class="callout callout-danger">
                                <h4><i class="fa fa-ban"></i> Form submit failed. Errors found:</h4>
                                <ul>
                                    @foreach ($errors->keys() as $key)
                                        <li data-validation-error={{$key}}>{{ $errors->first($key)}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endif
                {!! Form::model($entity, ['route' => ["$route.store"], 'method' => 'POST']) !!}
                    <div class="row">
                        <div class="col-sm-12">
                            @include('crudforms.form')
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
                                <i class='fa fa-check-circle'></i> Submit
                            </button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>
</div>
@endsection
