@extends('layouts.app')

@section('content')
<!-- Content -->
<div class="container-fluid flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add New Account</h5>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('register', withLang()) }}">
                        @csrf

                        <!-- NAME -->
                        <div class="mb-3">
                            <label class="form-label" for="name">Login Name</label>

                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bx bx-user"></i>
                                </span>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Full Name"
                                    required
                                    autocomplete="name"
                                    autofocus
                                />
                            </div>

                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- EMAIL -->
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>

                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bx bx-envelope"></i>
                                </span>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="example@email.com"
                                    required
                                />
                            </div>

                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- PHONE -->
                        <div class="mb-3">
                            <label class="form-label" for="phone">Phone</label>

                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bx bx-phone"></i>
                                </span>

                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="012345678"
                                    required
                                />
                            </div>

                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- POSITION -->
                        <div class="mb-3">
                            <label class="form-label" for="position">Position</label>

                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bx bx-briefcase"></i>
                                </span>

                                <select
                                    id="position"
                                    name="position"
                                    class="form-select @error('position') is-invalid @enderror"
                                >
                                    <option value="">Select Position</option>

                                    @foreach($roles as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ old('position') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @error('position')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- PASSWORD -->
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>

                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bx bx-key"></i>
                                </span>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="••••••••"
                                    required
                                    autocomplete="new-password"
                                />
                            </div>

                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- CONFIRM PASSWORD -->
                        <div class="mb-3">
                            <label class="form-label" for="password_confirmation">Confirm Password</label>

                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bx bx-key"></i>
                                </span>

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="••••••••"
                                    required
                                    autocomplete="new-password"
                                />
                            </div>
                        </div>

                        <!-- SUBMIT -->
                        <button type="submit" class="btn btn-primary">
                            Register
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection