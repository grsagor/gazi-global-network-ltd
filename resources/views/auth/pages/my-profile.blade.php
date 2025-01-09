@extends('backend.layout.app')
@section('content')
    <div class="card p-5">
        <h1 class="text-center">My Profile</h1>
        <form action="{{ route('auth.my.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="profile_image" name="profile_image"
                    onchange="previewImages(event)" data-preview-container="#image_preview" accept="image/*">
            </div>
            <div id="image_preview" class="d-flex flex-wrap mt-2">
                <img src="{{ asset($user->profile_image) }}" class="img-thumbnail mr-2"
                    style="width: 100px; height: 100px;">
            </div>
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}"
                    placeholder="Enter first name" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}"
                    placeholder="Enter last name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                    placeholder="Enter email address" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->phone }}"
                    placeholder="Enter phone number" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Save User</button>
            </div>
        </form>
    </div>
@endsection

@section('js')
@endsection
