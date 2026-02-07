@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="m-0">Products</h6>

                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('product.add') }}" class="btn btn-primary btn-sm">
                            + Add
                        </a>
                        <input type="text" id="searchInput" placeholder="Search..."
                            class="py-2  border border-gray-300 rounded-lg h-6 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">

                        <table class="table align-items-center mb-0 datatable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Sr No.</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Product Id</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">SKU
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">HSN
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Price</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Actual Price</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Summer</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">In Stock</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Stock</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Gallery</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Similar</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-table">
                                @foreach ($products as $key => $item)
                                    <tr data-id="{{ $item->id }}">
                                        <td>
                                            <i class="fas fa-bars text-secondary me-2 drag-handle" style="cursor:move"></i>
                                            {{ $products->firstItem() + $key }}
                                        </td>

                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->sku_product_id }}</p>
                                        </td>

                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->sku_code }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->hsn_code }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->price }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->ac_price }}</p>
                                        </td>

                                        <td>
                                            <select name="status" class="form-control text-xs font-weight-bold select_summer">
                                                <option value="">Select</option>
                                                @foreach ($summer as $key => $val)
                                                
                                                <option value="{{$val->id}}" data-id="{{ $item->id }}"
                                                    {{ $item->summer_id == $val->id ? 'selected' : '' }}>
                                                    {{$val->name}}
                                                </option>

                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <select name="status" class="form-control text-xs font-weight-bold select_top">
                                                <option value="">Select</option>
                                                <option value="active" data-id="{{ $item->id }}"
                                                    {{ $item->status == 'active' ? 'selected' : '' }}>
                                                    Active
                                                </option>
                                                 <option value="inactive" data-id="{{ $item->id }}"
                                                    {{ $item->status == 'inactive' ? 'selected' : '' }}>
                                                    InActive
                                                </option>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="status" class="form-control text-xs font-weight-bold select_stock">
                                                <option value="">Select</option>
                                                <option value="active" data-id="{{ $item->id }}"
                                                    {{ $item->in_stock == '1' ? 'selected' : '' }}>
                                                    Stock
                                                </option>
                                                 <option value="inactive" data-id="{{ $item->id }}"
                                                    {{ $item->in_stock == '0' ? 'selected' : '' }}>
                                                    out of stock
                                                </option>
                                            </select>
                                        </td>
                                        
                                        <td>
                                            <a href="{{ route('product.stock', $item->id) }}"
                                                class="text-xs font-weight-bold mb-0">
                                                Stock
                                            </a>
                                        </td>

                                        <td>
                                            <a href="{{ route('product.gallery', $item->id) }}"
                                                class="text-xs font-weight-bold mb-0">
                                                Gallery
                                            </a>
                                        </td>

                                        <td>
                                            <a href="{{ route('product.similar', $item->id) }}"
                                                class="text-xs font-weight-bold mb-0">
                                                Similar
                                            </a>
                                        </td>

                                        <td>
                                            <a href="{{ route('product.edit', $item->id) }}"
                                                class="text-xs font-weight-bold mb-0">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $products->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            
            $('.select_summer').on('change', function() {

                var product_id = $(this).find(':selected').data('id');
                var value = $(this).val();

                // console.log(product_id, value);

                $.ajax({
                    url: "{{ route('product.summer_status') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: product_id,
                        status: value,
                    },
                    success: function(res) {
                        console.log(res.message);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Something went wrong');
                    }
                });
            });

            $('.select_top').on('change', function() {

                var product_id = $(this).find(':selected').data('id');
                var value = $(this).val();

                // console.log(product_id, value);

                $.ajax({
                    url: "{{ route('product.status') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: product_id,
                        status: value,
                    },
                    success: function(res) {
                        console.log(res.message);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Something went wrong');
                    }
                });
            });

            $('.select_stock').on('change', function() {

                var product_id = $(this).find(':selected').data('id');
                var value = $(this).val();

                // console.log(product_id, value);

                $.ajax({
                    url: "{{ route('product.select_stock') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: product_id,
                        status: value,
                    },
                    success: function(res) {
                        console.log(res.message);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Something went wrong');
                    }
                });
            });
        });
    </script>
    
@endsection
