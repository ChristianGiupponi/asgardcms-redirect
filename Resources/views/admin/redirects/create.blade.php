@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('redirect::redirects.title.create redirect') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.redirect.redirect.index') }}">{{ trans('redirect::redirects.title.redirects') }}</a></li>
        <li class="active">{{ trans('redirect::redirects.title.create redirect') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.redirect.redirect.store'], 'method' => 'post']) !!}
    {{csrf_field()}}
    @include('redirect::admin.redirects.partials.alert')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    @include('redirect::admin.redirects.partials.create-fields')
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.redirect.redirect.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}
@stop
