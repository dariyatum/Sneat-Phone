@extends('layouts.app')
@push('styles')
@endpush

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="pull-right">
                @can('user-create')
                    <a class="btn btn-outline-primary" href="{{ route('register', withLang()) }}">
                        <i class='bx bx-plus-circle'></i> Create New User
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- List User Table -->
    <div class="card">
        <h5 class="card-header">List of users</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Position</th>
                        <th>Status</th>
                        @canany(['user-edit', 'user-delete'])
                        <th>Actions</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <td>
                                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                    <li
                                        data-bs-toggle="tooltip"
                                        data-popup="tooltip-custom"
                                        data-bs-placement="top"
                                        class="avatar avatar-xs pull-up"
                                        title="{{ $user->name }}"
                                    >
                                        <img src="{{ $user->getProfile() }}" alt="Avatar" class="rounded-circle"
                                            onError="this.onerror=null;this.src='{{ asset('/assets/img/blank-profile.png') }}';" />
                                    </li>
                                </ul>
                            </td>
                            <td><strong>{{ $user->name ?? '' }}</strong></td>
                            <td>{{ $user->email ?? '' }}</td>
                            <td>{{ $user->phone ?? '' }}</td>
                            <td>{{ $user->employee->position ?? '' }}</td>
                            <td>{!! $user->employee->statusname ?? '' !!}</td>
                            @canany(['user-edit', 'user-delete'])
                            <td>
                                @can('user-edit')
                                <a href="{{ route('users.edit', withLang(['id' => $user->id])) }}"
                                    class="btn btn-icon btn-outline-secondary"
                                    title="Edit">
                                    <span class="tf-icons bx bx-edit-alt"></span>
                                </a>
                                @endcan

                                @can('user-delete')
                                <button type="button"
                                    class="btn btn-icon btn-outline-danger"
                                    title="Delete"
                                    onclick="openDeleteModal(
                                        '{{ route('users.destroy', withLang(['id' => $user->id])) }}',
                                        '{{ addslashes($user->name) }}'
                                    )">
                                    <span class="tf-icons bx bx-trash"></span>
                                </button>
                                @endcan
                            </td>
                            @endcanany
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@can('user-delete')
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center px-4">
                <i class='bx bx-error-circle text-danger' style="font-size: 3.5rem;"></i>
                <h5 class="mt-2">Delete User</h5>
                <p class="text-muted mb-0">
                    Are you sure you want to delete <strong id="deleteUserName"></strong>?
                    This action cannot be undone.
                </p>
            </div>
            <div class="modal-footer border-0 justify-content-center gap-2">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="confirm" value="DELETE" />
</form>
@endcan
@endsection

@push('script')
<script>
    let deleteModal;

    document.addEventListener('DOMContentLoaded', function () {
        deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

        document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
            document.getElementById('deleteForm').submit();
        });
    });

    function openDeleteModal(actionUrl, userName) {
        document.getElementById('deleteForm').action = actionUrl;
        document.getElementById('deleteUserName').textContent = userName;
        deleteModal.show();
    }
</script>
@endpush