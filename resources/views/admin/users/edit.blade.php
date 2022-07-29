@extends('layouts.admin.app')
@section('content')

<div class="mt-3">
    <div class="row">
        <div class="col-md-12 text-center">
            <h4>Users</h4>
            @if(session()->has('message'))
                <div class="alert alert-success text-center">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger text-center">
                    {{ session()->get('error') }}
                </div>
            @endif
        </div>
    </div> 
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Stripe ID</h6>
                </div>
                <div class="card-body">
                    <div class = "row">
                        <div class = "col-md-3 col-3"></div>
                        <div class = "col-md-6 col-6">
                            <form action = "{{ route('admin.update_user') }}" method = "POST">
                                {{ csrf_field() }}
                                <input type = "hidden" name = "user_id" value = "{{ $user->id }}">
                                <div class = "form-group">
                                    <label>Stripe ID</label>
                                    <input type = "text" name = "stripe_id" class = "form-control" value = "{{ $user->stripe_id }}" required>
                                </div>
                                <div class = "form-group">
                                    <!--<label>Stripe ID</label>-->
                                    <input type = "submit" name = "submit" class = "btn btn-sm btn-primary form-control" value = "Update">
                                </div>
                            </form>
                        </div>
                        <div class = "col-md-3 col-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div> 
    
@endsection