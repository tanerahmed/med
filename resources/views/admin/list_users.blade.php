@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Users</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-xl-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="pt-0">#ID</th>
                                        <th class="pt-0">Name</th>
                                        <th class="pt-0">Role</th>
                                        <th class="pt-0">Email</th>
                                        <th class="pt-0">Status</th>
                                        <th class="pt-0">Assign</th>
                                        <th class="pt-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td><span
                                                    class="badge bg-{{ $user->status_color }}">{{ $user->status_text }}</span>
                                            </td>
                                            <td>{{ $user->updated_at }}</td>
                                            <td>
                                                <form action="{{ route('admin.assign-role', $user->id) }}" method="POST">
                                                    @csrf
                                                    <select class="form-select" name="role">
                                                        <option value="{{ $user->role }}">{{ $user->role }}</option>
                                                        <option value="admin">admin</option>
                                                        <option value="editor">editor</option>
                                                        <option value="reviewer">reviewer</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-primary">Assign Role</button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.users-destroy', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Deleate</button>
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
        </div>


    </div>
@endsection
