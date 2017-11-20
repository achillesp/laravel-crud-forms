@if (count($errors) > 0)
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div id="validationErrors" class="alert alert-danger">
                <h4><i class="fa fa-ban"></i> Form submit failed. Errors found:</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <hr>
@endif
