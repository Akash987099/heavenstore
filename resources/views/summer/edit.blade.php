@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">

                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="m-0">Update</h6>
                </div>

                <div class="card-body px-4 pt-4 pb-2">
                    <form action="{{ route('summer.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$summer->id}}">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter name" value="{{$summer->name}}"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Enter title" value="{{$summer->sub_name}}"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Time</label>
                                    <input type="time" class="form-control" name="time" value="{{$summer->time}}" required>
                                </div>
                            </div>

                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>

                            <a href="{{ route('summer.index') }}" class="btn btn-secondary ms-2">
                                Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection