@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Tools Maintenance</h1>
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
                            <th>ID</th>
                            <th>Barcode</th>
                            <th>Problem</th>
                            <th>Solution</th>
                            <th>Date Reported</th>
                            <th>Date Released</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($maintenances as $maintenance)
                        <tr>
                            <td>{{ $maintenance->id }}</td>
                            <td>{{ $maintenance->barcode }}</td>
                            <td>{{ $maintenance->problem }}</td>
                            <td>{{ $maintenance->solution }}</td>
                            <td>{{ $maintenance->date_report }}</td>
                            <td>{{ $maintenance->date_released }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
