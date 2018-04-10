
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @if (! empty($results))
                    @if (! empty($results['errors']))
                        @foreach ($results['errors'] as $message)
                            <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @endforeach
                    @elseif (! empty($results['success']))
                        @foreach($results['success'] as $message)
                            <div class="alert alert-success" role="alert">{{ $message }}</div>
                        @endforeach
                    @endif
                @endif
                
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        All Users
                        <div class="pull-right action-buttons">
                            <div class="btn-group pull-right">
                                <form method="get" action="{{ route('admin.newUser') }}">
                                    <button type="submit" class="btn btn-default btn-xs" title="Create new user">
                                        <span class="glyphicon glyphicon-plus" style="margin-right: 0px;"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">

                            @foreach($users as $user) 
                                <li class="list-group-item">
                                    {{ $user->name }}

                                    <div class="pull-right action-buttons">
                                        <a href="{{ route('admin.editUser', $user->id, $user) }}" class="extra-margin-left" title="Edit user"><span class="glyphicon glyphicon-pencil sage-green-font"></span></a>
                                        <a href="{{ route('admin.deleteUser', $user->id, $user) }}" class="trash extra-margin-left" title="Delete user"><span class="glyphicon glyphicon-trash sage-green-font"></span></a>
                                    </div>
                                </li>

                            @endforeach
                        </ul>
                    </div>

                    <div class="btn-toolbar">
                        <div class="btn-group" role="group">
                            <a class="btn btn-primary pull-left" href="{{ route('admin.userTrash') }} ">View trash</a>
                        </div>
                        <div class="btn-group" role="group">
                            <a class="btn btn-primary pull-right" href="{{ route('admin.superAdmin') }} ">Manage Publications</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection