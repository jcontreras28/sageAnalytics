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

                        {!! Form::model($publication, ['method'=>'PATCH', 'action'=> ['AdminController@updatePub', $publication->id], 'files'=>true]) !!}
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
                                {!! Form::label('ignore_all_params', 'Ignore all url parameters', ['class'=>'col-md-4 col-form-label text-md-right']) !!}

                                <div class="col-md-6">
                                    @if ($publication->ignore_all_params == 1)
                                        <input checked="checked" name="ignore_all_params" type="checkbox" value=1 class='form-control'>
                                    @else
                                        <input name="ignore_all_params" type="checkbox" value=0 class='form-control'>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4 col-form-label text-md-right">
                                    <img src="{{ asset('images/pubLogos/'.$publication->logo) }}" width = "100px">
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

                        {!! Form::open(['method'=>'POST', 'action'=>'AdminController@storeAction']) !!}
                        {{ csrf_field() }}
                            <div class="extra-margin-top"></div>
                            <h3>New Action items</h3>
                            <table class="table">
                                <thead>
                                    <th>Action word</th>
                                    <th>Action type</th>
                                    <th>Save new action</th>
                                </thead>
                                <tbody>

                                    
                                    <tr class="">
                                    
                                        <td>
                                            {!! Form::text('trigger_word',  null, ['class'=>'form-control list-input-field']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('action_type_id', $types, null, ['class'=>'form-control']) !!}
                                            <input type="hidden" name="publication_id" id="publication_id" value="{{ $publication->id }}" role="button" />
                                        </td>
                                        <td>
                                            <button type="submit" class="extra-margin-left btn btn-primary glyphicon glyphicon-ok" name="newAction"></button>
                                        </td>
                                    </tr> 
                                </tbody>
                            </table>
                        {!! Form::close() !!}

                        <h3>Action items list</h3>
                        <div class="row action-list-header">
                            <div class="col-xs-4 action-list-header-text">Action word</div>
                            <div class="col-xs-4 action-list-header-text">Action type</div>
                            <div class="col-xs-2 text-center">Save Changes</div>
                            <div class="col-xs-2 text-center">Delete Action</div>
                        </div>

                        @foreach($actions as $action) 

                            {!! Form::model($action, ['method'=>'PATCH', 'action'=> ['AdminController@updateAction', $action->id]]) !!}
                            {{ csrf_field() }}

                            <div class="row action-list-row">
                                <div class="col-xs-4">
                                    <input type="text" name="trigger_word" id="trigger_word" value="{{ $action->trigger_word }}"/>
                                  
                                </div>
                                <div class="col-xs-4">
                                    {!! Form::select('action_type_id', $types, $action->actionType->id, ['class'=>'form-control']) !!}
                                   
                                </div>
                                <div class="col-xs-2 text-center">
                                    <button type="submit" class="btn btn-primary glyphicon glyphicon-ok"></button>
                                </div>
                                <div class="col-xs-2 text-center">
                                    <a href="{{ route('admin.deleteAction', $action->id) }}" class="trash btn btn-danger" title="Delete action"><span class="glyphicon glyphicon-trash"></span></a>
                                </div>
                            </div>

                            {!! Form::close() !!}
  
                                

                        @endforeach

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