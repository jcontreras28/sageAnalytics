
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Trashed Users
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">

                            @foreach($users as $user) 
                                <li class="list-group-item">
                                    {{ $user->name }}

                                    <div class="pull-right action-buttons">
                                        <a href="{{ route('admin.restoreUser', $user->id) }}">Restore</a>
                                        <a href="{{ route('admin.permanentDeleteUser', $user->id) }}" class="extra-margin-left">Delete permanent</a>
                                    </div>
                                </li>

                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection