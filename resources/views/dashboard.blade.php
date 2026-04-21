@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
        </div>
    </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ \App\Models\Tool::count() }}</h3>
                    <p>Total Tools</p>
                </div>
                <div class="icon">
                    <i class="fas fa-wrench"></i>
                </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ \App\Models\Employee::count() }}</h3>
                    <p>Employees</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
