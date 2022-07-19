@extends('layouts.admin.app')
@section('content')

<div class="mt-3">
    <div class="row">
        <div class="col-md-12 text-center">
            <h4>Business Categories & Subcategories</h4>
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
            <div class="table-responsive">
                <table class="table table-sm table-hover" id="merchants_table">
                    <thead>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                    </thead>
                    <tbody>                        
                        @foreach($interests as $interest)                            
                            <tr>
                                <td>{{ $interest->id }}</td>                                
                                <td>{{ $interest->selected_category->category_name }}</td>
                                <td>{{ $interest->selected_subcategory->subcategory_name }}</td>
                            </tr>
                        @endforeach                        
                    </tbody>
                </table>
                {{ $interests->links() }}
            </div>
        </div>
    </div> 
</div> 
    
{{-- <script type="text/javascript">
    $(document).ready(function() {
      $('#example332').DataTable({
          "responsive": true,
      });
  } );
</script> --}}
@endsection