@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">

                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="m-0">Summer</h6>

                    <div class="d-flex gap-2">
                        <a href="{{ route('summer.add') }}" class="btn btn-primary btn-sm">
                            + Add
                        </a>

                        <input type="text" id="searchInput" placeholder="Search..." class="form-control form-control-sm"
                            style="width:200px;">
                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">

                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        #
                                    </th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Title
                                    </th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Time
                                    </th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="sortable-table">
                                @forelse ($summer as $key => $item)
                                    <tr data-id="{{ $item->id }}">

                                        <td class="text-xs">
                                            <i class="fas fa-bars text-secondary me-2 drag-handle" style="cursor:move"></i>
                                            {{ $summer->firstItem() + $key }}
                                        </td>

                                        <td class="text-xs font-weight-bold">
                                            {{ $item->name }}
                                        </td>

                                        <td class="text-xs">
                                            {{ $item->sub_name }}
                                        </td>

                                        <td class="text-xs">
                                            {{ $item->time }}
                                        </td>

                                        <td>
                                            <a href="{{ route('summer.edit', $item->id) }}" class="text-primary me-2">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            No data found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-4 px-3">
                            {{ $summer->links('pagination::tailwind') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
