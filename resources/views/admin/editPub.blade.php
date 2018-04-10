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

                        {!! Form::model($publication, ['method'=>'POST', 'action'=> ['AdminController@updatePub', $publication->id], 'files'=>true]) !!}
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
                                <div class="col-md-4 col-form-label text-md-right">
                                    <img src="{{ $publication->logo }}" width = "100px">
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

                        <div class="extra-margin-top"></div>
                        <h3>Action items list</h3>
                        <table class="table">
                            <thead>
                                <th>Action word</th>
                                <th>Action type</th>
                                <th>Save Changes</th>
                                <th>Delete Action</th>
                            </thead>
                            <tbody>
                            @foreach($actions as $action) 
                                {!! Form::model($action, ['method'=>'PATCH', 'action'=> ['AdminController@updateAction', $action->id]]) !!}
                                @csrf
                                <tr class="">
                                    <td>
                                        {!! Form::text('action',  $action->trigger_word , ['class'=>'form-control list-input-field']) !!}
                                    </td>
                                    <td>
                                        <select name="type_id" id="type_id">
                                            @foreach($types as $type)
                                                @if ($action->actionType->id == $type->id)
                                                    <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                                                @else
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.updateUser', $action->id, $action) }}" class="extra-margin-left btn btn-primary" title="Edit user"><span class="glyphicon glyphicon-ok"></span></a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.deleteUser', $action->id, $action) }}" class="trash extra-margin-left btn btn-danger" title="Delete user"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                </tr>
                                {!! Form::close() !!}

                                
                            @endforeach
                            </tbody>
                        </table>
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