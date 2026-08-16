@extends('pos.layout.app')

@section('content')

<div class="flex-1 overflow-y-auto bg-slate-50 p-4 md:p-6">

    <div class="max-w-7xl mx-auto">

        {{-- Dashboard Header --}}
        <div class="mb-6">

            <h1 class="text-2xl md:text-3xl font-bold text-[#0F172A]">
                POS Dashboard
            </h1>

            <p class="text-slate-500 mt-1">
                Manage your orders and sales from one place.
            </p>

        </div>


        {{-- Order Summary --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">


            {{-- Today's Orders --}}
            <div
                class="glass rounded-2xl p-5
                       border border-white/70
                       shadow-lg shadow-slate-200/40"
            >

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Today's Orders
                        </p>

                        <h3
                            class="text-3xl font-bold
                                   text-[#0F172A] mt-2"
                        >
                            {{ $todayorder }}
                        </h3>

                    </div>


                    <div
                        class="w-12 h-12 rounded-xl
                               bg-emerald-100
                               text-[#128C7E]
                               flex items-center justify-center"
                    >
                        <i class="fas fa-shopping-cart text-xl"></i>
                    </div>

                </div>


                <p class="text-xs text-slate-400 mt-4">
                    Orders created today
                </p>

            </div>


            {{-- This Week --}}
            <div
                class="glass rounded-2xl p-5
                       border border-white/70
                       shadow-lg shadow-slate-200/40"
            >

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            This Week
                        </p>

                        <h3
                            class="text-3xl font-bold
                                   text-[#0F172A] mt-2"
                        >
                            {{ $thisweek }}
                        </h3>

                    </div>


                    <div
                        class="w-12 h-12 rounded-xl
                               bg-blue-100
                               text-blue-600
                               flex items-center justify-center"
                    >
                        <i class="fas fa-calendar-week text-xl"></i>
                    </div>

                </div>


                <p class="text-xs text-slate-400 mt-4">
                    Orders created this week
                </p>

            </div>


            {{-- This Month --}}
            <div
                class="glass rounded-2xl p-5
                       border border-white/70
                       shadow-lg shadow-slate-200/40"
            >

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            This Month
                        </p>

                        <h3
                            class="text-3xl font-bold
                                   text-[#0F172A] mt-2"
                        >
                            {{ $thismonth }}
                        </h3>

                    </div>


                    <div
                        class="w-12 h-12 rounded-xl
                               bg-purple-100
                               text-purple-600
                               flex items-center justify-center"
                    >
                        <i class="fas fa-calendar-alt text-xl"></i>
                    </div>

                </div>


                <p class="text-xs text-slate-400 mt-4">
                    Orders created this month
                </p>

            </div>


            {{-- Total Orders --}}
            <div
                class="glass rounded-2xl p-5
                       border border-white/70
                       shadow-lg shadow-slate-200/40"
            >

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Total Orders
                        </p>

                        <h3
                            class="text-3xl font-bold
                                   text-[#0F172A] mt-2"
                        >
                            {{ $totalorder }}
                        </h3>

                    </div>


                    <div
                        class="w-12 h-12 rounded-xl
                               bg-orange-100
                               text-orange-600
                               flex items-center justify-center"
                    >
                        <i class="fas fa-receipt text-xl"></i>
                    </div>

                </div>


                <p class="text-xs text-slate-400 mt-4">
                    All POS orders
                </p>

            </div>

        </div>


        {{-- Quick Actions --}}
        <div class="mt-6">

            <div
                class="bg-white rounded-2xl
                       border border-slate-200
                       shadow-sm p-5"
            >

                <h2 class="text-lg font-bold text-slate-800">
                    Quick Actions
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Quickly manage your POS operations.
                </p>


                <div
                    class="grid grid-cols-1 sm:grid-cols-2
                           gap-3 mt-5"
                >

                    <a
                        href="{{ route('pos.order') }}"
                        class="flex items-center gap-3
                               p-4 rounded-xl
                               border border-slate-200
                               hover:border-[#128C7E]
                               hover:bg-emerald-50/50
                               transition"
                    >

                        <div
                            class="w-10 h-10 rounded-lg
                                   bg-emerald-100
                                   text-[#128C7E]
                                   flex items-center justify-center"
                        >
                            <i class="fas fa-plus"></i>
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-slate-800">
                                Create New Order
                            </p>

                            <p class="text-xs text-slate-400 mt-1">
                                Create a new POS bill
                            </p>

                        </div>

                    </a>


                    <a
                        href="{{ route('pos.bills') }}"
                        class="flex items-center gap-3
                               p-4 rounded-xl
                               border border-slate-200
                               hover:border-[#128C7E]
                               hover:bg-emerald-50/50
                               transition"
                    >

                        <div
                            class="w-10 h-10 rounded-lg
                                   bg-blue-100
                                   text-blue-600
                                   flex items-center justify-center"
                        >
                            <i class="fas fa-receipt"></i>
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-slate-800">
                                View Bills
                            </p>

                            <p class="text-xs text-slate-400 mt-1">
                                View all POS transactions
                            </p>

                        </div>

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection