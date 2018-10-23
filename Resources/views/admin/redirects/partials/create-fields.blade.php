<div class="box-body">
    <div class="row">
        <div class="col-md-5">
            {!! Form::normalInput('from', trans('redirect::redirects.form.from'), $errors, null, ['max-length' => 255]) !!}
        </div>
        <div class="col-md-5">
            {!! Form::normalInput('to', trans('redirect::redirects.form.to'), $errors, null, ['max-length' => 255]) !!}
        </div>
        <div class="col-md-2">
            {!! Form::normalSelect('type', trans('redirect::redirects.form.type'), $errors, $redirectTypes) !!}
        </div>
    </div>
</div>
