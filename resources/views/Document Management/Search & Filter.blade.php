@extends('new')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Search & Filter</h1>
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Search and Filter Records</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="#">
                <div class="row g-3">
                    <!-- Search Field -->
                    <div class="col-md-4">
                        <label for="search" class="form-label fw-bold">Search</label>
                        <input type="text" name="search" id="search" class="form-control" placeholder="Enter keyword" value="{{ request('search') }}">
                    </div>

                    <!-- Filter by Date -->
                    <div class="col-md-4">
                        <label for="start_date" class="form-label fw-bold">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label fw-bold">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>

                    <!-- Filter by Category -->
                    <div class="col-md-4">
                        <label for="category" class="form-label fw-bold">Category</label>
                        <select name="category" id="category" class="form-select">
                            <option value="">Select Category</option>
                            <option value="category1" {{ request('category') == 'category1' ? 'selected' : '' }}>Category 1</option>
                            <option value="category2" {{ request('category') == 'category2' ? 'selected' : '' }}>Category 2</option>
                            <option value="category3" {{ request('category') == 'category3' ? 'selected' : '' }}>Category 3</option>
                        </select>
                    </div>

                    <!-- Filter by Status -->
                    <div class="col-md-4">
                        <label for="status" class="form-label fw-bold">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Select Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search"></i> Search
                    </button>
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-5">
        <h5 class="mb-3">Search Results</h5>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Column 1</th>
                        <th>Column 2</th>
                        <th>Column 3</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through results -->
                    @forelse ($results ?? [] as $result)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $result->column1 ?? '#' }}</td>
                        <td>{{ $result->column2 ?? '#' }}</td>
                        <td>{{ $result->column3 ?? '#' }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info text-white">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="#" class="btn btn-sm btn-warning text-white">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="#" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
