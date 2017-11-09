@extends($bladeLayout)

@section('main-content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="btn-group pull-right">
                    <a href="{{ route("$route.create" ) }}" class="btn btn-default btn-xs pull-right">
                        <i class='fa fa-plus'></i> Add New {{ $title }}
                    </a>
                </div>
                <h3 class="panel-title">{{ str_plural($title) }} Index</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-condensed data-table">
                    <thead>
                        <tr>
                            @foreach ($fields as $field)
                                <th>{{$field['label']}}</th>
                            @endforeach
                            @if ($withTrashed)
                                <th>Deleted On</th>
                            @endif
                            <th class="text-center" style="white-space: nowrap;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entities as $entity)
                            <tr>
                                @foreach ($fields as $field)
                                    {{-- <td>{{ $entity->{$field['name']} }}</td> --}}
                                    <td>@include( "crudforms.displays.{$field['type']}")</td>
                                @endforeach

                                @if ($withTrashed)
                                    <td>{{ !empty($entity->deleted_at) ? $entity->deleted_at : '' }}</td>
                                @endif

                                <td class="text-center" style="white-space: nowrap">
                                    @if (empty($entity->deleted_at))
                                        {{-- Show --}}
                                        <a href="{{ route("$route.show", $entity->id ) }}" class="btn btn-info">
                                            <i class="fa fa-info-circle"></i>
                                        </a>

                                        {{-- Update --}}
                                        <a href="{{ route("$route.edit", $entity->id ) }}" class="btn btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        {{-- Delete --}}
                                        {!! Form::model($entity, [
                                            'route' => ["$route.destroy", $entity->id],
                                            'method' => 'DELETE',
                                            'class' => 'inline',
                                            'style' => 'display: inline-block;'
                                        ]) !!}
                                            <button class="btn btn-danger delete-btn" type="submit">
                                                <i class="fa fa-remove"></i>
                                            </button>
                                        {!! Form::close() !!}
                                    @elseif ($withTrashed)
                                        {{-- Restore SoftDeleted --}}
                                        {!! Form::model($entity, [
                                            'route' => ["$route.restore", $entity->id],
                                            'method' => 'PUT',
                                            'class' => 'inline'
                                        ]) !!}
                                            <button class="btn btn-success restore-btn" type="submit">
                                                <i class="fa fa-level-up"></i> Restore
                                            </button>
                                        {!! Form::close() !!}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
