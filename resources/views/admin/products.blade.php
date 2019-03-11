@extends('admin.layouts.master')


@section('content')
    <div class="modal fade" tabindex="-1" role="dialog" id="addnew">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.products.store') }}" method="post" id="addplanform">
                        @csrf
                        <div class="form-group">
                            <label for="planname">Product name:</label>
                            <input type="text" name="name" class="form-control" id="planname" placeholder="Enter a plan name" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="addplanform">Add a product</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-6"><h1>Products</h1></div>
        <div class="col-xs-12 col-md-6 text-right">
            <a href="#addnew" data-toggle="modal" class="btn btn-primary" role="button">Add a new product</a>
        </div>
    </div>

    <div class="dashboard-card dashboard-card--no-padding">
        <table class="table table-striped dashboard-card__table">
            <thead>
            <tr>
                <th>Products</th>
                <th>Options</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>
                        {{ $product['name'] }}
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.products', $product->id) }}" class="btn btn-success btn-sm">Edit</a>
                        <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <span>DELETE</span>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection