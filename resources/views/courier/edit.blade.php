@extends('layout.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Edit Courier Partner</h6>
            </div>

            <div class="card-body px-4 pt-4 pb-2">

                <form action="{{ route('courier.update',$courier->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $courier->id }}">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Courier Name</label>
                            <input type="text"
                                   class="form-control"
                                   name="courier_name"
                                   value="{{ $courier->courier_name }}"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Courier Code</label>
                            <input type="text"
                                   class="form-control"
                                   name="courier_code"
                                   value="{{ $courier->courier_code }}"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Logo</label>

                            <input type="file"
                                   class="form-control"
                                   name="logo">

                            @if($courier->logo)
                                <div class="mt-2">
                                    <img src="{{ asset($courier->logo) }}"
                                         width="80"
                                         class="img-thumbnail">
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Person</label>
                            <input type="text"
                                   class="form-control"
                                   name="contact_person"
                                   value="{{ $courier->contact_person }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Email</label>
                            <input type="email"
                                   class="form-control"
                                   name="contact_email"
                                   value="{{ $courier->contact_email }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Mobile</label>
                            <input type="text"
                                   class="form-control"
                                   name="contact_mobile"
                                   value="{{ $courier->contact_mobile }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Website URL</label>
                            <input type="text"
                                   class="form-control"
                                   name="website_url"
                                   value="{{ $courier->website_url }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tracking URL</label>
                            <input type="text"
                                   class="form-control"
                                   name="tracking_url"
                                   value="{{ $courier->tracking_url }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">API Base URL</label>
                            <input type="text"
                                   class="form-control"
                                   name="api_base_url"
                                   value="{{ $courier->api_base_url }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">API Key</label>
                            <textarea class="form-control"
                                      name="api_key"
                                      rows="3">{{ $courier->api_key }}</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">API Secret</label>
                            <textarea class="form-control"
                                      name="api_secret"
                                      rows="3">{{ $courier->api_secret }}</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>

                            <select class="form-control" name="status">
                                <option value="1" {{ $courier->status == 1 ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="0" {{ $courier->status == 0 ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check mt-4">
                                <input type="checkbox"
                                       class="form-check-input"
                                       name="supports_cod"
                                       value="1"
                                       {{ $courier->supports_cod ? 'checked' : '' }}>

                                <label class="form-check-label">
                                    Supports COD
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check mt-4">
                                <input type="checkbox"
                                       class="form-check-input"
                                       name="supports_prepaid"
                                       value="1"
                                       {{ $courier->supports_prepaid ? 'checked' : '' }}>

                                <label class="form-check-label">
                                    Supports Prepaid
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check mt-4">
                                <input type="checkbox"
                                       class="form-check-input"
                                       name="supports_reverse_pickup"
                                       value="1"
                                       {{ $courier->supports_reverse_pickup ? 'checked' : '' }}>

                                <label class="form-check-label">
                                    Supports Reverse Pickup
                                </label>
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">
                        Update Courier
                    </button>

                    <a href="{{ route('courier.index') }}"
                       class="btn btn-secondary">
                        Back
                    </a>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection