@extends( $bladeLayout ?: config('crud-forms.blade_layout'))

@section(config('crud-forms.blade_section'))

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="btn-group pull-right">
                    <a href="{{ route("$route.create" ) }}" class="btn btn-default btn-xs pull-right">
                        <i class='fa fa-plus'></i> Add New {{ $title }}
                    </a>
                </div>
                <h3 class="panel-title">{{ Illuminate\Support\Str::plural($title) }} Index</h3>
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
                                    <td>@include( "crud-forms::displays.{$field['type']}")</td>
                                @endforeach

                                @if ($withTrashed)
                                    <td>{{ !empty($entity->deleted_at) ? $entity->deleted_at : '' }}</td>
                                @endif

                                <td class="text-center" style="white-space: nowrap">
                                    @if (empty($entity->deleted_at))
                                        {{-- Show --}}
                                        <a href="{{ route("$route.show", $entity->id ) }}" class="btn btn-info">
                                            @if (config('crud-forms.button_icons'))
                                                <i class="fa fa-info-circle"></i>
                                            @else
                                                show
                                            @endif
                                        </a>

                                        {{-- Update --}}
                                        <a href="{{ route("$route.edit", $entity->id ) }}" class="btn btn-warning">
                                            @if (config('crud-forms.button_icons'))
                                                <i class="fa fa-edit"></i>
                                            @else
                                                edit
                                            @endif
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route("$route.destroy", $entity->id) }}" method="POST" style="display: inline-block;">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button class="btn btn-danger delete-btn" type="submit">
                                                @if (config('crud-forms.button_icons'))
                                                    <i class="fa fa-remove"></i>
                                                @else
                                                    delete
                                                @endif
                                            </button>
                                        </form>
                                    @elseif ($withTrashed)
                                        {{-- Restore SoftDeleted --}}
                                        <form action="{{ '/' . request()->path()  . '/' . $entity->id . '/restore' }}" method="POST" style="display: inline-block;">
                                            {{ method_field('PUT') }}
                                            {{ csrf_field() }}
                                            <button class="btn btn-success restore-btn" type="submit">
                                                @if (config('crud-forms.button_icons'))
                                                    <i class="fa fa-level-up"></i>
                                                @endif
                                                Restore
                                            </button>
                                        </form>
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
