@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Add New User
                    </div>

                    <div class="panel-body">
                        {!! Form::open(['method'=>'POST', 'action'=>'UserController@storeUser']) !!}
                            @csrf

                            <div class="form-group row">
                                {!! Form::label('name', 'Name', ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                                <div class="col-md-6">
                                    {!! Form::text('name', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label('email', 'Contact email', ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                                <div class="col-md-6">
                                     {!! Form::text('email', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label('password', 'Password', ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                                <div class="col-md-6">
                                     {!! Form::password('password', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                {!! Form::label('passwordComf', 'Confirm password', ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                                <div class="col-md-6">
                                     {!! Form::password('passwordComf', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            @if (Auth::user()->role->name == 'Super Admin')

                                <div class="form-group row">
                                    {!! Form::label('role', "User's Role", ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                                        <div class="col-md-6">
                                            <select name="role_id" id="role_id">
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>

                                <div class="form-group row display-hidden-start" id="publicationDiv">
                                    {!! Form::label('publication', "User's Publication", ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                                        <div class="col-md-6">
                                            <select name="publication_id" id="publication_id">
                                                <option value="0" selected>none</option>
                                                @foreach($publications as $pub)
                                                    <option value="{{ $pub->id }}">{{ $pub->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                            @elseif (Auth::user()->role->name == 'Publication Admin')
                                <input type="hidden" name="publication_id" value="{{ Auth::user()->publication->id }}">

                                <div class="form-group row">
                                    {!! Form::label('role', "User's Role", ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                                        <div class="col-md-6">
                                            <select name="role_id" id="role_id">
                                                @foreach($roles as $role)
                                                    @if ($role->name !== 'Super Admin')
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                </div>

                            @endif

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="Save" class="btn btn-primary">
                                        Add User
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