@extends('panel.layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="m-0">Hi, Welcome {{ auth()->user()->name }}!</h4>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card crm-widget">
            <div class="card-body p-0">
                <div
                    class="row row-cols-xxl-3 row-cols-md-3 row-cols-1 g-0">
                    <div class="col">
                        <div class="mt-3 mt-md-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">Total Product</h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-database-2-line display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span class="counter-value" data-target="{{ $totalProduct }}">{{
                                            $totalProduct }}</span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="mt-3 mt-md-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">Total Reward</h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-award-fill display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span class="counter-value"
                                            data-target="{{ $totalReward }}">{{
                                            $totalReward }}</span></h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="mt-3 mt-md-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">Total Customer</h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-team-line display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span class="counter-value"
                                            data-target="{{ $totalCustomer }}">{{
                                            $totalCustomer }}</span></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection