@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center category-card-header">
                    <div class="category-card-header-top">
                        <h6 class="m-0">Courier</h6>

                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('courier.add') }}" class="btn btn-primary btn-sm category-card-add-btn">
                                + Add
                            </a>
                        </div>
                    </div>

                    <input type="text" id="searchInput" placeholder="Search..."
                        class="py-2 border border-gray-300 rounded-lg h-6 dark:bg-gray-700 dark:border-gray-600 dark:text-white card-header-search">
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">

                        <table class="table align-items-center mb-0 datatable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Sr No.
                                    </th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Logo
                                    </th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Courier Name
                                    </th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Courier Code
                                    </th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Contact
                                    </th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        COD
                                    </th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Prepaid
                                    </th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Reverse Pickup
                                    </th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Status
                                    </th>

                                    <th class="text-secondary opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($couriers as $key => $item)
                                    <tr>

                                        <td>
                                            {{ $couriers->firstItem() + $key }}
                                        </td>

                                        <td>
                                            @if ($item->logo)
                                                <img src="{{ asset($item->logo) }}"
                                                    style="width:50px;height:50px;object-fit:contain;border-radius:8px;">
                                            @else
                                                <span class="text-xs">N/A</span>
                                            @endif
                                        </td>

                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $item->courier_name }}
                                            </p>
                                        </td>

                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $item->courier_code }}
                                            </p>
                                        </td>

                                        <td>
                                            <p class="text-xs mb-0">
                                                {{ $item->contact_person }}
                                            </p>

                                            <small>{{ $item->contact_mobile }}</small>
                                        </td>

                                        <td>
                                            @if ($item->supports_cod)
                                                <span class="badge bg-success">
                                                    Yes
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    No
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($item->supports_prepaid)
                                                <span class="badge bg-success">
                                                    Yes
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    No
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($item->supports_reverse_pickup)
                                                <span class="badge bg-success">
                                                    Yes
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    No
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <select name="status"
                                                class="form-control text-xs font-weight-bold courier-status">

                                                <option value="1" data-id="{{ $item->id }}"
                                                    {{ $item->status == 1 ? 'selected' : '' }}>
                                                    Active
                                                </option>

                                                <option value="0" data-id="{{ $item->id }}"
                                                    {{ $item->status == 0 ? 'selected' : '' }}>
                                                    Inactive
                                                </option>

                                            </select>
                                        </td>

                                        <td>
                                            <a href="{{ route('courier.edit', $item->id) }}"
                                                class="text-secondary font-weight-bold text-xs">
                                                Edit
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $couriers->links('shared.pagination') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.courier-status').on('change', function() {

            var id = $(this).find(':selected').data('id');
            var status = $(this).val();

            $.ajax({
                url: "{{ route('courier.status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    status: status
                },
                success: function(res) {
                    showNotification('success', 'Status Updated Successfully');
                }
            });
        });
    </script>
@endsection