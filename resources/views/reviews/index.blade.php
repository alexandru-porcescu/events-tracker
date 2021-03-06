@extends('app')

@section('title','Reviews')

@section('content')

    <h4>Reviews
        @include('reviews.crumbs')
    </h4>
    <div class="row" class="tab-content filters-content">
        <div class="col-md-6">
            <a href="{{ url('/reviews/all') }}" class="btn btn-info">Show all reviews</a>
            <a href="{!! URL::route('reviews.index') !!}" class="btn btn-info">Show paginated reviews</a>
            <a href="{!! URL::route('reviews.create') !!}" class="btn btn-primary">Add an review</a>	<a href="{!! URL::route('series.create') !!}" class="btn btn-primary">Add an review series</a>
        </div>

        <!-- NAV / FILTER -->

        <div class="col-md-6">
        {!! Form::open(['route' => ['reviews.filter'], 'method' => 'GET']) !!}

        <!-- BEGIN: FILTERS -->
            @if ($hasFilter)

                <div class="form-group col-sm-3">
                    {!! Form::label('filter_name','Filter By Name') !!}
                    {!! Form::text('filter_name', (isset($filters['filter_name']) ? $filters['filter_name'] : NULL), ['class' =>'form-control']) !!}
                </div>

                <div class="form-group col-sm-2">
                    {!! Form::label('filter_venue','Filter By Venue') !!}
                    <?php $venues = [''=>''] + App\Entity::getVenues()->pluck('name','name')->all();?>
                    {!! Form::select('filter_venue', $venues, (isset($filters['filter_venue']) ? $filters['filter_venue'] : NULL), ['class' =>'form-control select2', 'data-placeholder' => 'Select a venue']) !!}
                </div>

                <div class="form-group col-sm-2">
                    {!! Form::label('filter_tag','Filter By Tag') !!}
                    <?php $tags =  [''=>'&nbsp;'] + App\Tag::orderBy('name','ASC')->pluck('name', 'name')->all();?>
                    {!! Form::select('filter_tag', $tags, (isset($filters['filter_tag']) ? $filters['filter_tag'] : NULL), ['class' =>'form-control select2', 'data-placeholder' => 'Select a tag']) !!}
                </div>

                <div class="form-group col-sm-2">
                    {!! Form::label('filter_related','Filter By Related') !!}
                    <?php $related = [''=>''] + App\Entity::orderBy('name','ASC')->pluck('name','name')->all();?>
                    {!! Form::select('filter_related', $related, (isset($filters['filter_related']) ? $filters['filter_related'] : NULL), ['class' =>'form-control select2', 'data-placeholder' => 'Select an entity']) !!}
                </div>

                <div class="form-group col-sm-2">
                    {!! Form::label('filter_rpp','RPP') !!}
                    <?php $rpp_options =  [''=>'&nbsp;', 5 => 5, 10 => 10, 25 => 25, 100 => 100, 1000 => 1000];?>
                    {!! Form::select('filter_rpp', $rpp_options, (isset($filters['filter_rpp']) ? $filters['filter_rpp'] : NULL), ['class' =>'form-control auto-submit']) !!}
                </div>
            @endif

            <div class="col-sm-2">
                <div class="btn-group col-sm-1">
                    {!! Form::submit('Filter',  ['class' =>'btn btn-primary btn-sm btn-tb', 'id' => 'primary-filter-submit']) !!}
                    {!! Form::close() !!}
                    {!! Form::open(['route' => ['reviews.reset'], 'method' => 'GET']) !!}
                    {!! Form::submit('Reset',  ['class' =>'btn btn-primary btn-sm btn-tb', 'id' => 'primary-filter-reset']) !!}
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
        <!-- END: FILTERS -->
    </div>


    <br style="clear: left;"/>

    <div class="row">

        @if (isset($reviews) && count($reviews) > 0)
            <div class="col-lg-6">
                <div class="bs-component">
                    <div class="panel panel-info">

                        <div class="panel-heading">
                            <h3 class="panel-title">Events</h3>
                        </div>

                        <div class="panel-body">
                            {!! $reviews->render() !!}
                            {!! $reviews->appends(['sort_by' => $sortBy,
                                'rpp' => $rpp,
                                'filter_venue' => isset($filters['filter_venue']) ? $filters['filter_venue'] : NULL,
                                'filter_tag' => isset($filters['filter_tag']) ? $filters['filter_tag'] : NULL,
                                'filter_name' => isset($filters['filter_name']) ? $filters['filter_name'] : NULL,
                            ])->render() !!}
                            @include('reviews.list', ['reviews' => $reviews])
                        </div>

                    </div>
                </div>
            </div>
        @endif

    </div>

@stop


@section('footer')
    <script>
    </script>
@endsection