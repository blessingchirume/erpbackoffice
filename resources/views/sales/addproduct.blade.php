@extends('layouts.app', ['page' => 'Add Product', 'pageSlug' => 'sales', 'section' => 'transactions'])

@section('content')
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Add Product</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('sales.show', [$sale->id]) }}" class="btn btn-sm btn-primary">Back to List</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('sales.product.store', $sale) }}" autocomplete="off">
                            @csrf

                            <div class="pl-lg-4">
                                <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                                <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-product">Product</label>
                                    <select name="product_id" id="input-product" class="form-select form-control-alternative{{ $errors->has('product_id') ? ' is-invalid' : '' }}" required>
                                        @foreach ($products as $product)
                                            @if($product['id'] == old('product_id'))
                                                <option value="{{$product['id']}}" selected>[{{ $product->category->name }}] {{ $product->name }} - Base price: {{ $product->price }}$</option>
                                            @else
                                                <option value="{{$product['id']}}">[{{ $product->category->name }}] {{ $product->name }} - Base price: {{ $product->price }}$</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'product_id'])
                                </div>

                                <div class="form-group{{ $errors->has('applied_vat') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-applied_vat">Vat Group</label>
                                    <select name="applied_vat" id="input-product" class="form-select2 form-control-alternative{{ $errors->has('applied_vat') ? ' is-invalid' : '' }}" required>
                                        @foreach ($taxes as $tax)
                                            @if($tax['id'] == old('applied_vat'))
                                                <option value="{{$tax['rate']}}" selected>[{{ $tax->rate }}% - {{ $tax->name }}]</option>
                                            @else
                                                <option value="{{$tax['rate']}}">[{{ $tax->rate * 100 }}% - {{ $tax->name }}]</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'applied_vat'])
                                </div>

                                {{--<div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-price">Price per Unit</label>
                                    <input type="number" name="price" id="input-price" step=".01" class="form-control form-control-alternative{{ $errors->has('price') ? ' is-invalid' : '' }}" value="0" required>
                                    @include('alerts.feedback', ['field' => 'price'])
                                </div>--}}

                                <div class="form-group{{ $errors->has('qty') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-qty">Quantity</label>
                                    <input type="number" name="qty" id="input-qty" class="form-control form-control-alternative{{ $errors->has('qty') ? ' is-invalid' : '' }}" value="0" required>
                                    @include('alerts.feedback', ['field' => 'qty'])
                                </div>

                                {{--<div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-total">Total Amount</label>
                                    <input type="text" name="total_amount" id="input-total" class="form-control form-control-alternative{{ $errors->has('product_id') ? ' is-invalid' : '' }}" value="0$" disabled>
                                    @include('alerts.feedback', ['field' => 'product_id'])
                                </div>--}}

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">Continue</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('js')
    <script>
        new SlimSelect({
            select: '.form-select'
        });

        new SlimSelect({
            select: '.form-select2'
        });
    </script>
    <script>
        let input_qty = document.getElementById('input-qty');
        let input_price = document.getElementById('input-price');
        let input_total = document.getElementById('input-total');
        input_qty.addEventListener('input', updateTotal);
        input_price.addEventListener('input', updateTotal);
        function updateTotal () {
            input_total.value = (parseInt(input_qty.value) * parseFloat(input_price.value))+"$";
        }
    </script>
@endpush
