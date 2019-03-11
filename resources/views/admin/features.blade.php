@extends('admin.layouts.master')

@section('content')
    <div class="modal fade" tabindex="-1" role="dialog" id="addnew">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.features.store') }}" method="post" id="addfeatureform">
                        @csrf

                        <div class="form-group">
                            <label for="featname">Feature name:</label>
                            <input type="text" name="name" class="form-control" id="featname" placeholder="Feature name..." required>
                        </div>

                        <div class="form-group">
                            <label for="featdesc">Feature description:</label>
                            <textarea type="text" name="description" class="form-control" id="featdesc" placeholder="What does it do..." required></textarea>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <label>Plans (optional):</label>
                                    <small class="form-text text-muted">Attach the new feature to an existing plan/s.</small>
                                </div>
                                @foreach($plans as $plan)
                                    <div class="col-xs-12 col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="plans[]" value="{{ $plan->id }}" id="plan_{{ $plan->id }}">
                                            <label class="form-check-label" for="plan_{{ $plan->id }}">
                                                {{ $plan->name }} - {{$plan->price()}}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="addfeatureform">Add a feature</button>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12 col-md-6"><h1>Features</h1></div>
        <div class="col-xs-12 col-md-6 text-right">
            <a href="#addnew" data-toggle="modal" class="btn btn-primary" role="button">Add a new feature</a>
        </div>
    </div>

    <div class="dashboard-card dashboard-card--no-padding">
        <table class="table table-striped dashboard-card__table">
            <thead>
            <tr>
                <th>Feature</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Options</th>
            </tr>
            </thead>
            <tbody>
                @foreach($features as $feature)
                    <tr>
                        <td>{{ $feature->name }}</td>
                        <td><span class="badge badge-dark">{{ $feature->slug }}</span></td>
                        <td>{{ $feature->description }}</td>
                        <td class="text-center">
                            <form action="{{ route('admin.features.delete', $feature->id) }}" method="POST" style="display:inline-block">
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