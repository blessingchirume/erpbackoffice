@extends('layouts.app', ['page' => 'New Payment', 'pageSlug' => 'payments', 'section' => 'transactions'])

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">New Payment</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('transactions.type', ['type' => 'payment']) }}" class="btn btn-sm btn-primary">Back to List</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('transactions.store') }}" autocomplete="off">
                            @csrf
                            <input type="hidden" name="type" value="payment">
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <h6 class="heading-small text-muted mb-4">Payment Information</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-title">Title</label>
                                    <input type="text" name="title" id="input-title" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="Title" value="{{ old('title') }}" required autofocus>
                                    @include('alerts.feedback', ['field' => 'title'])
                                </div>


                                <div class="form-group{{ $errors->has('currency_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-currency">Currency</label>
                                    <select name="currency_id" id="input-currency" class="form-select form-control-alternative{{ $errors->has('currency_id') ? ' is-invalid' : '' }}" required>
                                        @foreach ($currencies as $currency)
                                            @if($currency['id'] == old('currency_id'))
                                                <option value="{{$currency['id']}}" selected>{{$currency['name']}}</option>
                                            @else
                                                <option value="{{$currency['id']}}">{{$currency['name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'currency_id'])
                                </div>

                                <div class="form-group{{ $errors->has('provider_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-provider">Provider</label>
                                    <select name="provider_id" id="input-provider" class="form-select2 form-control-alternative{{ $errors->has('provider_id') ? ' is-invalid' : '' }}" required>
                                        @foreach ($providers as $provider)
                                            @if($provider['id'] == old('provider'))
                                                <option value="{{$provider['id']}}" selected>{{$provider['name']}}</option>
                                            @else
                                                <option value="{{$provider['id']}}">{{$provider['name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'provider_id'])
                                </div>

                                <div class="form-group{{ $errors->has('payment_method_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-method">Payment Method</label>
                                    <select name="payment_method_id" id="input-method" class="form-select3 form-control-alternative{{ $errors->has('payment_method_id') ? ' is-invalid' : '' }}" required>
                                        @foreach ($payment_methods as $payment_method)
                                            @if($payment_method['id'] == old('payment_method_id'))
                                                <option value="{{$payment_method['id']}}" selected>{{$payment_method['name']}}</option>
                                            @else
                                                <option value="{{$payment_method['id']}}">{{$payment_method['name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'payment_method_id'])
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

@push('js')
    <script>
        new SlimSelect({
            select: '.form-select'
        })
        new SlimSelect({
            select: '.form-select2'
        })

        new SlimSelect({
            select: '.form-select3'
        })
    </script>
@endpush('js')
