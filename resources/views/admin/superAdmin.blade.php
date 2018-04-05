
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
                                <li class="list-group-item">
                                    {{ $pub->name }}

                                    <div class="pull-right action-buttons">
                                        <a href="{{ route('pub.index', $pub->id) }}" title="View stats"><span class="glyphicon glyphicon-eye-open sage-green-font"></span></a>
                                        <a href="{{ route('admin.editPub', $pub->id) }}" class="extra-margin-left" title="Edit publication"><span class="glyphicon glyphicon-pencil sage-green-font"></span></a>
                                        <a href="{{ route('admin.deletePub', $pub->id) }}" class="trash extra-margin-left" title="Delete publication"><span class="glyphicon glyphicon-trash sage-green-font"></span></a>
                                    </div>
                                </li>

                            @endforeach
                        </ul>
                    </div>

                    <div class="btn">
                        <a href="{{ route('admin.trash') }} ">View trash</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection