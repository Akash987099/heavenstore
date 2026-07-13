@extends('layout.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Add Courier Partner</h6>
            </div>

            <div class="card-body px-4 pt-4 pb-2">
                <form action="{{ route('courier.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Courier Name</label>
                            <input type="text" class="form-control" name="courier_name" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Courier Code</label>
                            <input type="text" class="form-control" name="courier_code" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Logo</label>
                            <input type="file" class="form-control" name="logo">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Person</label>
                            <input type="text" class="form-control" name="contact_person">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Email</label>
                            <input type="email" class="form-control" name="contact_email">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Mobile</label>
                            <input type="text" class="form-control" name="contact_mobile">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Website URL</label>
                            <input type="url" class="form-control" name="website_url">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tracking URL</label>
                            <input type="url" class="form-control" name="tracking_url">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">API Base URL</label>
                            <input type="text" class="form-control" name="api_base_url">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">API Key</label>
                            <textarea class="form-control" name="api_key" rows="2"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">API Secret</label>
                            <textarea class="form-control" name="api_secret" rows="2"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-control" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" name="supports_cod" value="1">
                                <label class="form-check-label">
                                    Supports COD
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" name="supports_prepaid" value="1" checked>
                                <label class="form-check-label">
                                    Supports Prepaid
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" name="supports_reverse_pickup" value="1">
                                <label class="form-check-label">
                                    Supports Reverse Pickup
                                </label>
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">
                        Save Courier Partner
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection