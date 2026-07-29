@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center category-card-header">
                    <div class="category-card-header-top">
                        <h6 class="m-0">Product Position</h6>
                    </div>

                    <input type="text" id="searchInput" placeholder="Search..."
                        class="py-2 border border-gray-300 rounded-lg h-6 dark:bg-gray-700 dark:border-gray-600 dark:text-white card-header-search">
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">

                        <table class="table align-items-center mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Product Name</th>
                                    <th>Order</th>
                                </tr>
                            </thead>

                            <tbody id="sortable-product">
                                @foreach ($products as $key => $item)
                                    <tr data-id="{{ $item->id }}">
                                        <td>
                                            <i class="fas fa-bars drag-handle me-2" style="cursor: move;"></i>
                                            {{ $key + 1 }}
                                        </td>

                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->order }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#sortable-product").sortable({
            handle: '.drag-handle',
            update: function() {

                let positions = [];

                $("#sortable-product tr").each(function() {
                    positions.push($(this).data('id'));
                });

                $.ajax({
                    url: "{{ route('product_position.updatePosition') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        positions: positions,
                        position_id : "{{$id}}",
                        cat_type : "{{$type}}",
                    },
                    success: function(res) {
                        console.log(res.message);
                        showNotification('success', res.message || 'Position updated successfully');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        showNotification('danger', 'Failed to update position');
                    }
                });
            }
        });
    </script>
@endsection
