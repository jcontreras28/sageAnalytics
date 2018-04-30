
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
                        Super Admin Page
                        <div class="pull-right action-buttons">
                            <div class="btn-group pull-right">
                                <form method="get" action="{{ route('admin.newPub') }}">
                                    <button type="submit" class="btn btn-default btn-xs" title="Create new publication">
                                        <span class="glyphicon glyphicon-plus" style="margin-right: 0px;"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">

                            @foreach($pubs as $pub) 
                                @if ($pub->name != "none")
                                <li class="list-group-item">
                                    <img src="{{ asset('images/pubLogos/'.$pub->logo) }}" width="40px" class="padding-right">
                                    {{ $pub->name }} ( {{ $pub->domain }} )

                                    <div class="pull-right action-buttons">
                                        <a href="{{ route('pub.wrapper', $pub->id) }}" title="View stats"><span class="glyphicon glyphicon-eye-open sage-green-font"></span></a>
                                        <a href="{{ route('admin.editPub', $pub->id) }}" class="extra-margin-left" title="Edit publication"><span class="glyphicon glyphicon-pencil sage-green-font"></span></a>
                                        <a href="{{ route('admin.deletePub', $pub->id) }}" class="trash extra-margin-left" title="Delete publication"><span class="glyphicon glyphicon-trash sage-green-font"></span></a>
                                    </div>
                                </li>
                                @endif

                            @endforeach
                        </ul>
                    </div>

                    <div class="btn-toolbar">
                        <div class="btn-group" role="group">
                            <a class="btn btn-primary pull-left" href="{{ route('admin.userTrash') }} ">View trash</a>
                        </div>
                        <div class="btn-group" role="group">
                            <a class="btn btn-primary pull-right" href="{{ route('admin.users') }} ">Manage Users</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection