@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Check In / Check Out (Borrow Tools)</h1>
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
                            <th>Check ID</th>
                            <th>Barcode</th>
                            <th>Employee ID</th>
                            <th>Status</th>
                            <th>Check Out Date</th>
                            <th>Check In Date</th>
                            <th>Actual Date Returned</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrows as $borrow)
                        <tr>
                            <td>{{ $borrow->id }}</td>
                            <td>{{ $borrow->barcode }}</td>
                            <td>{{ $borrow->employee_id }}</td>
                            <td>{{ $borrow->status }}</td>
                            <td>{{ $borrow->check_out_date }}</td>
                            <td>{{ $borrow->check_in_date }}</td>
                            <td>{{ $borrow->actual_date_returned }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
