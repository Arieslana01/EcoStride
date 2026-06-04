@extends('admin.layout')

@section('title', 'Employee Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            👥 Employee Management
        </h2>
        <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add New Employee
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($employees->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <td class="fw-bold">{{ $employee->name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->department }}</td>
                                    <td>
                                        <span class="badge badge-success">{{ ucfirst($employee->role) }}</span>
                                    </td>
                                    <td>{{ $employee->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.employees.edit', $employee) }}" 
                                           class="btn btn-sm btn-secondary me-2">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('admin.employees.destroy', $employee) }}" 
                                              method="POST" 
                                              style="display:inline;"
                                              onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    {{ $employees->links('pagination::bootstrap-5') }}
                </nav>
            @else
                <div class="alert alert-info text-center py-4">
                    <p class="mb-0">No employees found. <a href="{{ route('admin.employees.create') }}">Create one now</a></p>
                </div>
            @endif
        </div>
    </div>
@endsection
