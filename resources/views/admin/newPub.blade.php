@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Create New Publication
                    </div>

                    <div class="panel-body">
                        <!--<form method="POST" action="{{ route('admin.store') }}" enctype="multipart/form-data">-->
                        {!! Form::open(['method'=>'POST', 'action'=>'AdminController@store', 'files'=>true]) !!}
                            @csrf

                            <div class="form-group row">
                                {!! Form::label('name', 'Publication Name', ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                                <div class="col-md-6">
                                    {!! Form::text('name', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                   
                            <div class="form-group row">
                                {!! Form::label('domain', 'Publication Domain', ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                                <div class="col-md-6">
                                     {!! Form::text('domain', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label('email', 'Contact email', ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                                <div class="col-md-6">
                                     {!! Form::text('email', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label('phone', 'Contact phone number', ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                                <div class="col-md-6">
                                     {!! Form::tel('phone', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label('GAProfileId', 'Google Analytics Profile Id', ['class'=>'col-md-4 col-form-label text-md-right']) !!}

                                <div class="col-md-6">
                                    {!! Form::number('GAProfileId', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label('filelogo', 'Upload logo file', ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                                <div class="col-md-6">
                                    {!! Form::file('filelogo') !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label('file', 'Google Analytics Credential JSON file', ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                                <div class="col-md-6">
                                    {!! Form::file('file') !!}
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="Save" class="btn btn-primary">
                                        Save Publication
                                    </button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                        <!--</form>-->
                    </div>

                    @if(count($errors) > 0)

                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error}}</li>
                                @endforeach
                            </ul>
                        </div>
                        
                    @endif
                </div>
            </div>
        </div>
    </div>



@endsection