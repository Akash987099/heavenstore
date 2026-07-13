@extends('layout.app')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="m-0">Edit Platform</h6>
                </div>

                <div class="card-body px-4 pt-4 pb-2">
                    <form action="{{route('plateform.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="id" value="{{$plateform->id}}">
                        <div class="row g-3">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vehicle_name" class="form-label">Platform Name</label>
                                    <input type="text" class="form-control" id="name" value="{{$plateform->name}}" name="name" placeholder="Enter Details" required>
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vehicle_name" class="form-label">Platform Slug</label>
                                    <input type="text" class="form-control" id="slug" value="{{$plateform->slug}}" name="slug" placeholder="Enter Details" required>
                                </div>
                            </div>
                            
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vehicle_name" class="form-label">Website</label>
                                    <input type="text" class="form-control" id="website" value="{{$plateform->website_url}}" name="website" placeholder="Enter Details" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vehicle_number" class="form-label">Platform Image</label>
                                    <input type="file" class="form-control" id="image" name="image" placeholder="Enter vehicle number">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vehicle_number" class="form-label fw-semibold mb-2">
                                        Old Image
                                    </label>

                                    <div class="border rounded-3 p-3 text-center bg-light position-relative">
                                        <img src="{{ asset($plateform->logo) }}" alt="Old Image"
                                            class="img-fluid rounded-3 shadow-sm"
                                            style="max-height: 200px; object-fit: contain;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection