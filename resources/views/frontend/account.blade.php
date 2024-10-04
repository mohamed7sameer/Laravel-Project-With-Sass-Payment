@extends('layouts.app')
@section('content')

    <div class="card">
        <div class="card-header">Account</div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    @include('partial.frontend.sidebar')
                </div>
                <div class="col-8">
                    <h2 class="h5 text-uppercase mb-4">Update your information</h2>
                    <form action="{{ route('update_account') }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="text" name="email" value="{{ old('email', $user->email) }}" class="form-control">
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
