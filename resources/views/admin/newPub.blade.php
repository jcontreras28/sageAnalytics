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
                        <form method="POST" action="{{ route('admin.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Publication Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="name" class="form-control" name="email" value="" required autofocus>
                                </div>
                            </div>
                   
                            <div class="form-group row">
                                <label for="domain" class="col-md-4 col-form-label text-md-right">Publication Domain</label>

                                <div class="col-md-6">
                                    <input id="domain" type="domain" class="form-control{{ $errors->has('domain') ? ' is-invalid' : '' }}" name="domain" required>


                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="GAProfileId" class="col-md-4 col-form-label text-md-right">Google Analytics Profile Id</label>

                                <div class="col-md-6">
                                    <input id="GAProfileId" type="number" min="0" class="form-control" name="domain">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="Save" class="btn btn-primary">
                                        Save Publication
                                    </button>
                                </div>
                            </div>
                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection