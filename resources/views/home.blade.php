@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Rent a Car</h1>
        </div>
        <div class="section-body">

            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-body p-0 overflow-hidden rounded">
                            <map-component></map-component>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Car Park List</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-action active">
                                    <div class="d-flex w-100 align-items-start justify-content-between">
                                        <h6 class="mb-1">Car Park A</h6>
                                        <span class="badge badge-light p-1"
                                              data-toggle="tooltip"
                                              ata-original-title="Available car quantity">14</span>
                                    </div>
                                    <p class="mb-1">124 La Trobe St, Melbourne VIC 3000</p>
                                    <div class="d-flex w-100">
                                        <small class="mr-2"><i class="fas fa-route mr-1"></i> 830m</small>
                                        <small class="mr-2"><i class="fas fa-walking mr-1"></i> 20 min</small>
                                        <small class="mr-2"><i class="fas fa-taxi mr-1"></i> 8 min</small>
                                        <a href="#" class="btn btn-warning btn-sm ml-auto">More Detail</a>
                                    </div>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 align-items-start justify-content-between">
                                        <h6 class="mb-1">Car Park B</h6>
                                        <span class="badge badge-light p-1"
                                              data-toggle="tooltip"
                                              ata-original-title="Available car quantity">14</span>
                                    </div>
                                    <p class="mb-1">124 La Trobe St, Melbourne VIC 3000</p>
                                    <div class="d-flex w-100">
                                        <small class="mr-2"><i class="fas fa-route mr-1"></i> 830m</small>
                                        <small class="mr-2"><i class="fas fa-walking mr-1"></i> 20 min</small>
                                        <small class="mr-2"><i class="fas fa-taxi mr-1"></i> 8 min</small>
                                        <a href="#" class="btn btn-warning btn-sm ml-auto">More Detail</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <a href="#" class="btn btn-link btn-icon mr-3"><i class="fas fa-chevron-left"></i></a>
                            <h4>[Selected car park name]</h4>
                            <span class="badge badge-light p-1"
                                  data-toggle="tooltip"
                                  ata-original-title="Available car quantity">14</span>
                        </div>
                        <div class="card-body">

                            <div class="d-flex w-100 mb-2">
                                <small class="mr-2"><i class="fas fa-route mr-1"></i> 830m</small>
                                <small class="mr-2"><i class="fas fa-walking mr-1"></i> 20 min</small>
                                <small class="mr-2"><i class="fas fa-taxi mr-1"></i> 8 min</small>
                            </div>

                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 align-items-start justify-content-between">
                                        <h6 class="mb-1">Car A</h6>
                                        <b class="text-danger">$14</b>
                                    </div>
                                    <div class="d-flex w-100">
                                        <small class="mr-2">5 seats</small>
                                        <small class="mr-2">Toyota</small>
                                    </div>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 align-items-start justify-content-between">
                                        <h6 class="mb-1">Car B</h6>
                                        <b class="text-danger">$14</b>
                                    </div>
                                    <div class="d-flex w-100">
                                        <small class="mr-2">5 seats</small>
                                        <small class="mr-2">Toyota</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
