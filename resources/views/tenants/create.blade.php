@extends('layouts.app', ['page' => __('Tenant Management'), 'pageSlug' => 'tenants-create', 'section' => 'tenants'])

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Tenant Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('companies.index') }}"
                                   class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <form method="post" action="{{ route('tenant.store') }}" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6">


                                    <h6 class="heading-small text-muted mb-4">{{ __('Company information') }}</h6>
                                    <div class="pl-lg-4">
                                        <div class="form-group{{ $errors->has('company_name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('Company Name') }}</label>
                                            <input type="text" name="company_name" id="company_name"
                                                   class="form-control form-control-alternative{{ $errors->has('company_name') ? ' is-invalid' : '' }}"
                                                   placeholder="{{ __('Company Name') }}" value="{{ old('company_name') }}" required
                                                   autofocus>
                                            @include('alerts.feedback', ['field' => 'company_name'])
                                        </div>
                                        <div class="form-group{{ $errors->has('company_email') ? ' has-danger' : '' }}">
                                            <label class="form-control-label"
                                                   for="input-email">{{ __('Company Email') }}</label>
                                            <input type="email" name="company_email" id="input-email"
                                                   class="form-control form-control-alternative{{ $errors->has('company_email') ? ' is-invalid' : '' }}"
                                                   placeholder="{{ __('Company Email') }}" value="{{ old('company_email') }}" required>
                                            @include('alerts.feedback', ['field' => 'company_email'])
                                        </div>
                                        <div class="form-group{{ $errors->has('business_type') ? ' has-danger' : '' }}">
                                            <label class="form-control-label"
                                                   for="input-password">{{ __('Business Type') }}</label>
                                            <input type="text" name="business_type" id="input-password"
                                                   class="form-control form-control-alternative{{ $errors->has('business_type') ? ' is-invalid' : '' }}"
                                                   placeholder="{{ __('Business Type') }}" value="" required>
                                            @include('alerts.feedback', ['field' => 'business_type'])
                                        </div>
                                        <div class="form-group{{ $errors->has('company_db_name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label"
                                                   for="company_db_name">{{ __('Company DB Name') }}</label>
                                            <input type="text" name="company_db_name"
                                                   id="company_db_name"
                                                   class="form-control form-control-alternative"
                                                   placeholder="{{ __('Company DB Name') }}" value="" required>
                                            @include('alerts.feedback', ['field' => 'company_db_name'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">

                                    <h6 class="heading-small text-muted mb-4">{{ __('Default user information') }}</h6>
                                    <div class="pl-lg-4">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                            <input type="text" name="name" id="input-name"
                                                   class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                   placeholder="{{ __('Name') }}" value="{{ old('name') }}" required
                                                   autofocus>
                                            @include('alerts.feedback', ['field' => 'name'])
                                        </div>
                                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <label class="form-control-label"
                                                   for="input-email">{{ __('Email') }}</label>
                                            <input type="email" name="email" id="input-email"
                                                   class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                   placeholder="{{ __('Email') }}" value="{{ old('email') }}" required>
                                            @include('alerts.feedback', ['field' => 'email'])
                                        </div>
                                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                            <label class="form-control-label"
                                                   for="input-password">{{ __('Password') }}</label>
                                            <input type="password" name="password" id="input-password"
                                                   class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                   placeholder="{{ __('Password') }}" value="" required>
                                            @include('alerts.feedback', ['field' => 'password'])
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                   for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                                            <input type="password" name="password_confirmation"
                                                   id="input-password-confirmation"
                                                   class="form-control form-control-alternative"
                                                   placeholder="{{ __('Confirm Password') }}" value="" required>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
