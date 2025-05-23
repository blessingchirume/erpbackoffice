@extends('layouts.app', ['page' => __('User Management'), 'pageSlug' => 'users', 'section' => 'users'])

@section('content')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('User Management') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('users.index') }}"
                                class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('users.store') }}" autocomplete="off">
                        @csrf

                        <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
                        <div class="pl-lg-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                <input type="text" name="name" id="input-name"
                                    class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                <input type="email" name="email" id="input-email"
                                    class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Email') }}" value="{{ old('email') }}" required>
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                            <div class="form-group{{ $errors->has('user_role_id') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-role">Roles</label>
                                <select name="user_role_id" id="input-role"
                                    class="form-select form-control-alternative{{ $errors->has('user_role_id') ? ' is-invalid' : '' }}"
                                    required>
                                    @foreach ($roles as $role)
                                    @if($role['id'] == old('user_role_id'))
                                    <option value="{{$role['id']}}"
                                        selected>{{$role['name']}}</option>
                                    @else
                                    <option value="{{$role['id']}}">{{$role['name']}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'user_role_id'])
                            </div>
                            <div class="form-group{{ $errors->has('shop_id') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-role">Shop</label>
                                <select name="shop_id" id="shop-select"
                                    class="form-select form-control-alternative{{ $errors->has('shop_id') ? ' is-invalid' : '' }}"
                                    required>
                                    @foreach ($shops as $shop)
                                    @if($shop->id == old('shop_id'))
                                    <option value="{{$shop->id}}"
                                        selected>{{$shop->name}}</option>
                                    @else
                                    <option value="{{$shop->id}}">{{$shop->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'shop_id'])
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-password">{{ __('Password') }}</label>
                                <input type="password" name="password" id="input-password"
                                    class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Password') }}" value="" required>
                                @include('alerts.feedback', ['field' => 'password'])
                            </div>
                            <div class="form-group">
                                <label class="form-control-label"
                                    for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                                <input type="password" name="password_confirmation" id="input-password-confirmation"
                                    class="form-control form-control-alternative"
                                    placeholder="{{ __('Confirm Password') }}" value="" required>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    new SlimSelect({
        select: '.form-select'
    })

    new SlimSelect({
        select: '#shop-select'
    })
</script>
@endpush('js')