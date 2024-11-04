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
                        <form method="post" action="{{ route('payment.finalize', $transaction) }}" autocomplete="off">
                            @csrf
                            <input type="hidden" name="type" value="payment">
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <h6 class="heading-small text-muted mb-4">Receipt Information</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('receipt_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-method">Receipt</label>
                                    <select name="receipt_id" id="input-method" class="form-select form-control-alternative{{ $errors->has('receipt_id') ? ' is-invalid' : '' }}" required>
                                        @foreach ($receipts as $receipt)
                                            @if($receipt['id'] == old('receipt_id'))
                                                <option value="{{$receipt['id']}}" selected>{{$receipt['name']}}</option>
                                            @else
                                                <option value="{{$receipt['id']}}">{{$receipt['title']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'receipt_id'])
                                </div>
                                <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-amount">Amount</label>
                                    <input type="number" step=".01" name="amount" id="input-amount" class="form-control form-control-alternative" placeholder="Total Amount" value="{{ old('amount') }}" min="0" required>
                                    @include('alerts.feedback', ['field' => 'amount'])

                                </div>
                                <div class="form-group{{ $errors->has('reference') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-reference">Reference</label>
                                    <input type="text" name="reference" id="input-reference" class="form-control form-control-alternative{{ $errors->has('reference') ? ' is-invalid' : '' }}" placeholder="Reference" value="{{ old('reference') }}">
                                    @include('alerts.feedback', ['field' => 'reference'])
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

    </script>
@endpush('js')
