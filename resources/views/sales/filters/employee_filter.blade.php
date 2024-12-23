@extends('layouts.app', ['page' => 'Register Sale', 'pageSlug' => 'sales-create', 'section' => 'transactions'])

@section('content')
    <div class="container-fluid mt--7">
        @include('alerts.error')
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Select Employee</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('sales.index') }}" class="btn btn-sm btn-primary">Back to list</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('sales.employee') }}" autocomplete="off">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">Employee information</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('client_id') ? ' has-danger' : '' }}">
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <label class="form-control-label" for="input-name">Client</label>
                                    <select name="user_id" id="input-category" class="form-select form-control-alternative{{ $errors->has('client') ? ' is-invalid' : '' }}" required>
                                        @foreach ($users as $user)
                                            @if($user['id'] == old('client'))
                                                <option value="{{$user['id']}}" selected>{{$user['name']}}</option>
                                            @else
                                                <option value="{{$user['id']}}">{{$user['name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'client_id'])
                                </div>

                                <button type="submit" class="btn btn-success mt-4">Continue</button>
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
    </script>
@endpush
