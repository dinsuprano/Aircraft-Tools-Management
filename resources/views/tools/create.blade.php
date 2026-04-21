@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Add New Tool</h1>
        </div>
    </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tool Information</h3>
            </div>
            
            <form action="{{ route('tools.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="barcode">Barcode</label>
                        <input type="text" name="barcode" class="form-control" id="barcode" placeholder="Enter barcode" required value="{{ old('barcode') }}">
                        @error('barcode') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Tool Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter tool name" required value="{{ old('name') }}">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="3">{{ old('description') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" name="location" class="form-control" id="location" value="{{ old('location') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="price">Price ($)</label>
                                <input type="number" step="0.01" name="price" class="form-control" id="price" value="{{ old('price') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" name="quantity" class="form-control" id="quantity" value="{{ old('quantity') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="Available">Available</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('tools.index') }}" class="btn btn-default float-right">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
