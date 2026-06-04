@extends('admin.layout')

@section('title', 'Edit Employee')

@section('content')
    <div class="mb-4">
        <h2>✏️ Edit Employee: {{ $employee->name }}</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.employees.update', $employee) }}">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Full Name *</label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $employee->name) }}"
                           placeholder="Enter employee name"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email Address *</label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $employee->email) }}"
                           placeholder="Enter email address"
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Department -->
                <div class="mb-3">
                    <label for="department" class="form-label fw-bold">Department *</label>
                    <select class="form-select @error('department') is-invalid @enderror" 
                            id="department" 
                            name="department" 
                            required>
                        <option value="">-- Select Department --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept }}" @selected(old('department', $employee->department) === $dept)>
                                {{ $dept }}
                            </option>
                        @endforeach
                    </select>
                    @error('department')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                <!-- Password (Optional) -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">
                        Password <span class="text-muted">(Leave blank to keep current password)</span>
                    </label>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Minimum 8 characters">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-bold">
                        Confirm Password
                    </label>
                    <input type="password" 
                           class="form-control" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           placeholder="Confirm password">
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        ✓ Update Employee
                    </button>
                    <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
                        ← Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
