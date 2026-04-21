@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Tool Inventory</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('tools.create') }}" class="btn btn-primary">Add New Tool</a>
        </div>
    </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Barcode</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Available</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tools as $tool)
                        <tr>
                            <td>{{ $tool->barcode }}</td>
                            <td>{{ $tool->name }}</td>
                            <td>{{ $tool->location }}</td>
                            <td>${{ $tool->price }}</td>
                            <td>{{ $tool->quantity }}</td>
                            <td>{{ $tool->available_quantity }}</td>
                            <td>{{ $tool->status }}</td>
                            <td>
                                <a href="{{ route('tools.edit', $tool) }}" class="btn btn-sm btn-info">Edit</a>
                                <form action="{{ route('tools.destroy', $tool) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
