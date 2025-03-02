<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="crudModalLabel">Edit {{ $role == '2' ? 'Agent' : '' }}
                {{ $role == '3' ? 'Sub Agent' : '' }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="crudUpdateForm">
                @csrf
                <input type="hidden" name="id" value="{{ $agent->id }}">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name"
                        value="{{ $agent->first_name }}" placeholder="Enter first name" required>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name"
                        value="{{ $agent->last_name }}" placeholder="Enter last name" required>
                </div>
                <div class="mb-3">
                    <label for="father_name" class="form-label">Father Name</label>
                    <input type="text" class="form-control" id="father_name" name="father_name" value="{{ $agent->father_name }}"
                        placeholder="Enter father name" required>
                </div>
                <div class="mb-3">
                    <label for="nid" class="form-label">NID</label>
                    <input type="text" class="form-control" id="nid" name="nid" value="{{ $agent->nid }}"
                        placeholder="Enter nid" required>
                </div>
                <div class="mb-3">
                    <label for="passport" class="form-label">Passport</label>
                    <input type="text" class="form-control" id="passport" name="passport" value="{{ $agent->passport }}"
                        placeholder="Enter passport" required>
                </div>
                <div class="mb-3">
                    <label for="company" class="form-label">Company</label>
                    <input type="text" class="form-control" id="company" name="company" value="{{ $agent->company }}"
                        placeholder="Enter company" required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <input type="text" class="form-control" id="category" name="category" value="{{ $agent->category }}"
                        placeholder="Enter category">
                </div>
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <input type="text" class="form-control" id="rating" name="rating" value="{{ $agent->rating }}"
                        placeholder="Enter rating">
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">Note</label>
                    <input type="text" class="form-control" id="note" name="note" value="{{ $agent->note }}"
                        placeholder="Enter note" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ $agent->email }}" placeholder="Enter email address" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" class="form-control" id="phone" name="phone"
                        value="{{ $agent->phone }}" placeholder="Enter phone number" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter password">
                </div>
                <div class="mb-3">
                    <label for="profile_image" class="form-label">Profile Image</label>
                    <input type="file" class="form-control" id="profile_image" name="profile_image" onchange="previewImages(event)" data-preview-container="#image_preview" accept="image/*">
                </div>
                <div id="image_preview" class="d-flex flex-wrap mt-2">
                    <img src="{{ asset($agent->profile_image) }}" class="img-thumbnail mr-2" style="width: 100px; height: 100px;">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option {{ $agent->status == 1 ? 'selected' : '' }} value="1">Active</option>
                        <option {{ $agent->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="crudUpdateBtn">Update</button>
        </div>
    </div>
</div>
