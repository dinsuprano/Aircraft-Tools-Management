@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Edit Tool</h1>
        </div>
    </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Update Tool Information (Barcode: {{ $tool->barcode }})</h3>
            </div>
            
            <form action="{{ route('tools.update', $tool) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Tool Name</label>
                        <input type="text" name="name" class="form-control" id="name" required value="{{ old('name', $tool->name) }}">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="3">{{ old('description', $tool->description) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" name="location" class="form-control" id="location" value="{{ old('location', $tool->location) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="price">Price ($)</label>
                                <input type="number" step="0.01" name="price" class="form-control" id="price" value="{{ old('price', $tool->price) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" name="quantity" class="form-control" id="quantity" value="{{ old('quantity', $tool->quantity) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="Available" {{ $tool->status == 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="Maintenance" {{ $tool->status == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Update</button>
                    <a href="{{ route('tools.index') }}" class="btn btn-default float-right">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
