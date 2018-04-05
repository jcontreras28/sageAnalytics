
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Trashed publications
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">

                            @foreach($pubs as $pub) 
                                <li class="list-group-item">
                                    {{ $pub->name }}

                                    <div class="pull-right action-buttons">
                                        <a href="{{ route('admin.restorePub', $pub->id) }}">Restore</a>
                                        <a href="{{ route('admin.permanentDeletePub', $pub->id) }}" class="extra-margin-left">Delete permanent</a>
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