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
                <form action="{{ route('admin.plans.store') }}" method="post" id="addplanform">
                    @csrf
                    @if (count($products) == 0)
                        <div class="alert alert-danger">
                            You need to create a <a href="{{ route('admin.products') }}">product</a> before
                            making a plan.
                        </div>
                    @endif

                    <div class="row">
                        @if (count($products) !== 0)
                            <div class="col-xs-12 col-md-6">
                                <label for="planinterval">Product:</label>
                                <select class="custom-select" name="product_id">
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="planname">Plan name:</label>
                                <input type="text" name="name" class="form-control" id="planname" placeholder="Enter a plan name" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <label for="planamount">Plan amount:</label>
                                <div class="input-group">
                                    <input type="number" name="amount" class="form-control" placeholder="Plan amount" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">$</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-6">
                                <label for="planinterval">Plan duration:</label>
                                <div class="input-group">
                                    <input type="number" name="duration" class="form-control" id="planinterval" required>
                                    <select class="custom-select" name="interval">
                                       @foreach(config('app.plan_intervals') as $interval)
                                            <option value="{{ $interval }}">{{ $interval }}/s</option>
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (count($plans) !== 0)
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <label for="orderpost">Order:</label>
                                    <div class="input-group">
                                        <select class="custom-select" required="true" name="order_dir">
                                            <option value="-1">Before</option>
                                            <option value="1">After</option>
                                        </select>
                                        <select class="custom-select" required="true" id="orderpost" name="order">
                                            @foreach($plans as $plan)
                                                <option value="{{ $plan->order }}">{{ $plan->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <label>Features (optional):</label>
                                <small class="form-text text-muted">This can be added later in the Features section.</small>
                            </div>
                            @foreach($features as $feature)
                                <div class="col-xs-12 col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="{{ $feature->id }}" id="feature_{{ $feature->id }}">
                                        <label class="form-check-label" for="feature_{{ $feature->id }}">
                                            {{ $feature->name }}
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
                <button type="submit" class="btn btn-primary" form="addplanform">Add a plan</button>
            </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-6"><h1>Plans</h1></div>
        <div class="col-xs-12 col-md-6 text-right">
            <a href="#addnew" data-toggle="modal" class="btn btn-primary" role="button">Add a new plan</a>
        </div>
    </div>

    <div class="dashboard-card dashboard-card--no-padding">
        <table class="table table-striped dashboard-card__table">
            <thead>
            <tr>
                <th>Features</th>
                @foreach($plans as $plan)
                    <th class="text-center">
                        <h5>{{ $plan->name }}</h5>

                        <strong>{{ $plan->price() }}</strong>
                    </th>
                @endforeach
            </tr>
            </thead>
            <tbody>
                @foreach($features as $feature)
                    <tr>
                        <th>
                            {{ $feature['name'] }}
                            <span data-toggle="tooltip" data-placement="top" data-title="{{ $feature['description'] }}">@icon('help-circle')</span>
                        </th>
                        @foreach($plans as $plan)
                            <?php
                                $value = false;
                                $planFeatures = $plan->features->pluck('pivot')->toArray();
                                $foundPlanIdx = array_search($feature->id, array_column($planFeatures, 'feature_id'));

                                if ($foundPlanIdx !== false) {
                                    $value = (bool) $planFeatures[$foundPlanIdx]['value'];
                                }
                            ?>
                            @if ($value)
                                <td class="text-center">@icon('check-circle')</td>
                            @else
                                <td></td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Options:</th>
                    @foreach($plans as $plan)
                        <td class="text-center">
                            <a href="{{ route('admin.plans.edit.view', $plan->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <form action="{{ route('admin.plans.delete', $plan->id) }}" method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <span>DELETE</span>
                                </button>
                            </form>
                        </td>
                    @endforeach
                </tr>
            </tfoot>
        </table>
    </div>
@endsection