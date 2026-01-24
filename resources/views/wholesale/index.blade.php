@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="m-0">Wholesale Users</h6>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">

                        <table class="table align-items-center mb-0 datatable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Sr No.</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone</th>
                                    <th class="text-secondary opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-table">
                                @foreach ($users as $key => $item)
                                    <tr data-id="{{ $item->id }}">
                                        <td>
                                            <i class="fas fa-bars text-secondary me-2 drag-handle" style="cursor:move"></i>
                                            {{ $users->firstItem() + $key }}
                                        </td>

                                        <td><p class="text-xs font-weight-bold mb-0">{{ $item->name }}</p></td>
                                        <td><p class="text-xs font-weight-bold mb-0">{{ $item->email }}</p></td>
                                        <td><p class="text-xs font-weight-bold mb-0">{{ $item->phone }}</p></td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $users->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
