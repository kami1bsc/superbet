@extends('layouts.admin.app')
@section('content')

<div class="mt-3">
    <div class="row">
        <div class="col-md-12 text-center">
            <h4>Merchants</h4>
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
                    <h6 class="m-0 font-weight-bold text-primary">Merchants Data</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Device Type</th>
                                    <th>Gender</th>
                                    <th>Birthday</th>
                                    <th>Country</th>                                            
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Device Type</th>
                                    <th>Gender</th>
                                    <th>Birthday</th>
                                    <th>Country</th>                                            
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($users as $user)                            
                                    <tr>
                                        <td>{{ $user->id }}</td>                                
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>  
                                        <td>{{ $user->device_type }}</td>                            
                                        <td>{{ ucfirst($user->gender) }}</td>
                                        <td>{{ $user->birth_date }}</td>                                
                                        <td>{{ $user->country }}</td>                                 
                                        <td>
                                            <div class = "row">
                                                <div class = "col-md-4 col-4">
                                                    @if($user->is_verified == "false")
                                                        <a href = "{{ route('admin.verify_merchant', $user->id) }}" class = "btn btn-sm btn-circle btn-outline-primary"><i class = "fa fa-check"></i></a>
                                                    @else
                                                        <button type = "button" onclick = "alert('Merchant Already Verified')" class = "btn btn-sm btn-circle btn-outline-primary"><i class = "fa fa-check"></i></button>
                                                    @endif
                                                </div>
                                                <div class = "col-md-4 col-4">
                                                    <a href = "{{ route('admin.merchant-categories', $user->id) }}" class = "btn btn-sm btn-circle btn-outline-primary"><i class = "fa fa-list"></i></a>
                                                    
                                                </div>
                                                <div class = "col-md-4 col-4">
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method = "POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type = "submit" name = "submit" value = "submit" style = "margin-left: 3px;" onclick = "return confirm('Do You Really Want to Delete?')" class = "btn btn-sm btn-circle btn-outline-primary" style = "margin-left: -10px;"><i class = "fa fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div> 
    
@endsection