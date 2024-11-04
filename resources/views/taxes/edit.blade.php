@extends('layouts.app', ['page' => 'New Tax', 'pageSlug' => 'taxes', 'section' => 'taxes'])
@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">New Group</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('vat-groups.index') }}" class="btn btn-sm btn-primary">Back to List</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('vat-groups.update', $tax) }}" autocomplete="off">
                            @method('patch')
                            @csrf

                            <h6 class="heading-small text-muted mb-4">Tax Information</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">Name</label>
                                    <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Name" value="{{ old('name', $tax->name) }}" required autofocus>
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>

                                <div class="form-group{{ $errors->has('rate') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="address">Rate</label>
                                    <input type="number" step="0.01" min="0" max="1" name="rate" id="rate" class="form-control form-control-alternative{{ $errors->has('rate') ? ' is-invalid' : '' }}" placeholder="Rate" value="{{ old('rate', $tax->rate) }}" required autofocus>
                                    @include('alerts.feedback', ['field' => 'rate'])
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
