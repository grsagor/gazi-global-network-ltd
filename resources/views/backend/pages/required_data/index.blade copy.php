@extends('backend.layout.app')
@section('content')
    @if ($errors->any())
        {{-- <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $key => $error)
                <li><strong>{{ $key }}:</strong> {{ $error }}</li>
            @endforeach
        </ul>
    </div> --}}

        {{-- <pre>
        <?php
        print_r($errors);
        ?>
    </pre> --}}
    @endif


    <div class="card p-5 mb-3">
        <div class="head-label">
            <h5 class="card-title mb-0">Existing Required Data</h5>
        </div>
        <div>
            @foreach ($required_data as $index => $item)
                <p><strong>{{ $index + 1 }}: </strong>{{ $item->required_text }}</p>
                <div class="submitted-info-container">
                    @if ($item->submitted_text)
                        <p class="submitted-text"><strong>Submitted Text:</strong> {{ $item->submitted_text }}</p>
                    @endif
                    @if ($item->submitted_files)
                        @foreach ($item->submitted_files as $file)
                            @if (strpos($file->type, 'image') !== false)
                                <a href="{{ asset($file->path) }}" target="_blank">
                                    <img class="submitted-image" src="{{ asset($file->path) }}" alt="">
                                </a>
                            @else
                                <a href="{{ asset($file->path) }}" target="_blank">
                                    {{ $file->file_name }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>
                <form action="{{ route('admin.required_data.single.passenger.submit', ['data_id' => $item->id]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="submitted_text_{{ $index }}" class="form-label">What to say?</label>
                        <input type="text"
                            class="form-control @error('submitted_text_' . $item->id) is-invalid @enderror"
                            id="submitted_text_{{ $index }}" name="submitted_text_{{ $item->id }}"
                            placeholder="Enter what to say" required>
                        @error('submitted_text_' . $item->id)
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <?php
                        $has_error = false;
                        ?>
                        @foreach (array_keys($errors->getMessages()) as $errorKey)
                            @if (str_contains($errorKey, 'submitted_files_' . $item->id))
                                <?php
                                $has_error = true;
                                ?>
                            @endif
                        @endforeach
                        <label for="submitted_files_{{ $index }}" class="form-label">Upload Files</label>
                        <input type="file"
                            class="form-control @error('submitted_files_' . $item->id) is-invalid @enderror"
                            id="submitted_files_{{ $index }}" name="submitted_files_{{ $item->id }}[]" required
                            multiple>
                            @if ($has_error)
                                <div class="invalid-feedback">
                                    {{ $errors->first($errorKey) }}
                                </div>
                            @endif
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </form>
            @endforeach


        </div>
    </div>
    <div class="card p-5 mb-3">
        <div class="head-label">
            <h5 class="card-title mb-0">New Required Data</h5>
        </div>
        <form action="{{ route('admin.required_data.single.passenger.new', ['passenger_id' => $passenger_id]) }}"
            method="POST">
            @csrf
            <div class="mb-3">
                <label for="required_text" class="form-label">New Reqruirement</label>
                <input type="text" class="form-control" id="required_text" name="required_text"
                    placeholder="Enter what is required" required>
            </div>
            <div>
                <button type="submit" class="btn btn-primary btn-sm">Save</button>
            </div>
        </form>
    </div>
@endsection

@section('js')
@endsection
