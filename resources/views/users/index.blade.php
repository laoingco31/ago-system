@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'editor')
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">User List</h4>
        </div>
        <div class="card-body">
            {{-- Search & Filter Form --}}
            <form method="GET" class="row g-2 g-md-3 mb-3">
                <div class="col-12 col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
                </div>
                <div class="col-12 col-md-4">
                    <select name="role" class="form-select">
                        <option value="">All Roles</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-3 d-grid">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>

            {{-- Responsive Table --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Date Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->role ?? 'N/A') }}</td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'editor')
                                        <a href="{{ url('/users/' . $user->id . '/edit') }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                                    @endif

                                    @if (auth()->user()->role == 'admin')
                                        <form action="{{ url('/users/' . $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger mb-1">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    @else
        <div class="alert alert-danger text-center shadow">
            <i class="fas fa-ban"></i> You are not authorized to view the user list.
        </div>
    @endif
</div>
@endsection
