@extends('layouts.app', ['page' => 'Add Product', 'pageSlug' => 'receipt', 'section' => 'inventory'])

@section('content')
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Add Permission</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('receipts.show', $role) }}" class="btn btn-sm btn-primary">Back to List</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('roles.permissions.store', $role) }}" autocomplete="off">
                            @csrf

                            <div class="pl-lg-4">
{{--                                <input type="hidden" name="receipt_id" value="{{ $receipt->id }}">--}}
                                <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
{{--                                    <label class="form-control-label" for="input-product">Product</label>--}}
{{--                                    @foreach($permissions as $permission)--}}
{{--                                        <div class="col-sm-4">--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input name="permission[]" class="form-check-input" type="radio">--}}
{{--                                                <label class="form-check-label" for="item_description">--}}
{{--                                                    {{ $permission->name }}--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                    @endforeach--}}
                                    <select name="permission" id="input-provider" class="form-select form-control-alternative{{ $errors->has('permission') ? ' is-invalid' : '' }}">
                                        <option value="">Not Specified</option>
                                        @foreach ($permissions as $permission)
                                            @if($permission['id'] == old('permission'))
                                                <option value="{{$permission['id']}}" selected>{{$permission['name']}}</option>
                                            @else
                                                <option value="{{$permission['id']}}">{{$permission['name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
{{--                                    <select name="product_id" id="input-product" class="form-select form-control-alternative{{ $errors->has('product_id') ? ' is-invalid' : '' }}" required>--}}
{{--                                        @foreach ($products as $product)--}}
{{--                                            @if($product['id'] == old('product_id'))--}}
{{--                                                <option value="{{$product['id']}}" selected>[{{ $product->category->name }}] {{ $product->name }}</option>--}}
{{--                                            @else--}}
{{--                                                <option value="{{$product['id']}}">[{{ $product->category->name }}] {{ $product->name }}</option>--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
                                    </select>
                                    @include('alerts.feedback', ['field' => 'permission'])
                                </div>

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
    </script>
@endpush
