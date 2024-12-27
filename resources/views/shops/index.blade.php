@extends('layouts.app', ['page' => 'List of shops', 'pageSlug' => 'shops', 'section' => 'shops'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">shops</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('shops.create') }}" class="btn btn-sm btn-primary">New shop</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <th scope="col">Name</th>
                                <th scope="col">Address</th>
                                
                                <th scope="col">Created</th>
                                <th scope="col">Updated</th>
                                <th scope="col"></th>
                            </thead>
                            <tbody>
                                @foreach ($shops as $shop)
                                    <tr>
                                        <td>{{ $shop->name }}</td>
                                        <td>{{ $shop->address }}</td>
                                        <td>{{ $shop->created_at }}</td>
                                        <td>{{  $shop->updated_at }}</td>
                                        <td class="td-actions text-right">
                                            <a href="{{ route('shops.show', $shop) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                                <i class="tim-icons icon-zoom-split"></i>
                                            </a>
                                            <a href="{{ route('shops.edit', $shop) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit shop">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                            <form action="{{ route('shops.destroy', $shop) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete shop" onclick="confirm('Are you sure you want to delete this shop? Records of payments made to him will not be deleted.') ? this.parentElement.submit() : ''">
                                                    <i class="tim-icons icon-simple-remove"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $shops->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
