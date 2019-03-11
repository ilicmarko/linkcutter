@extends('admin.layouts.master')

@section('content')
    <h1>Plans</h1>
    <form action="{{ route('admin.plans.edit', $plan->id) }}" class="form">
        <div class="form-group">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <label for="name">Name</label>
                </div>
                <div class="col-xs-12 col-md-12">
                    <input type="text" name="name" id="name" class="form-control" value="{{$plan->name}}">
                </div>
            </div>
        </div>
        {{-- dd($plan->toArray()) --}}
        <div class="form-group">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <label>Features:</label>
                </div>
                @foreach($features as $feature)
                    <?php
                        $value = false;
                        $planFeatures = $plan->features->pluck('pivot')->toArray();
                        $foundPlanIdx = array_search($feature->id, array_column($planFeatures, 'feature_id'));

                        if ($foundPlanIdx !== false) {
                            $value = (bool) $planFeatures[$foundPlanIdx]['value'];
                        }
                    ?>
                    <div class="col-xs-12 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="features[]" value="{{ $feature->id }}"
                                   id="feature_{{ $feature->id }}"
                                   @if ($value)checked="true"@endif>
                            <label class="form-check-label" for="feature_{{ $feature->id }}">
                                {{ $feature->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Apply change</button>
    </form>
@endsection

@section('scripts')
    <script>
        function toggleItem(id) {
            if (features.includes(id)) {
                features.splice(features.indexOf(id), 1);
            } else {
                features.push(id);
            }
        }

        var checkboxes = document.querySelectorAll('.form input[type="checkbox"]');
        var features = [];

        if (checkboxes) {
            checkboxes.forEach((item) => {
                item.addEventListener('change', (e) => {
                    if (e.target.parentNode) {
                        let parent = e.target.parentNode;
                        toggleItem(e.target.value);
                        parent.classList.toggle('input-changed')
                        console.log(features);
                    }
                })
            })
        }
    </script>
@endsection