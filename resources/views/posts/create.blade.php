@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row mt-4">

            <div class="col-lg-6 mt-4 mx-auto">
                <form method="post" action="{{ route('store') }}" enctype="multipart/form-data">@csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description">
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Images</label>
                        <input type="file" name="filepond" multiple class="filepond" />

                        @foreach (old('file_ids', []) as $fileId)
                            <input type="hidden" name="file_ids[]" value="{{ $fileId }}">
                        @endforeach

                    </div>
                    <button type="submit" class="btn btn-primary">create</button>
                    <a href="{{ route('home') }}"><button type="button" class="btn btn-secondary">back</button></a>
                </form>
            </div>

        </div>
    </div>
@endsection


@section('header')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endsection

@section('footer')
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    <script>
        const fileInput = document.querySelector('input[name="filepond"]');
        FilePond.registerPlugin(FilePondPluginImagePreview);
        const pond = FilePond.create(fileInput, {
            allowMultiple: true,
            server: {
                process: {
                    url: '{{ route('temp.upload') }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    method: 'POST',
                    onload: (response) => {
                        const fileId = response;
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'file_ids[]';
                        input.value = fileId;
                        document.querySelector('form').appendChild(input);
                    }
                },
                onprocessfiles: () => {
                    document.querySelector('button[type="submit"]').disabled = true;
                },
                onprocessfile: (error, file) => {
                    if (error) {
                        file.error = true;
                        file.errorText = error;
                    } else {
                        file.error = false;
                    }
                },
                acceptedFileTypes: ['image/*', 'application/pdf'],
                maxFileSize: '10MB',
                allowFileTypeValidation: true,
                allowFileSizeValidation: true,
                instantUpload: true,
            }
        });
    </script>
@endsection
