<h5>{{__('Event Details')}}</h5>
@if(isset($event))
    {!! Form::model($event, array('method' => 'put', 'route' => array('update.front.event', $event->id), 'class' => 'form')) !!}
    {!! Form::hidden('id', $event->id) !!}
    {!! Form::hidden('company_id', Auth::guard('company')->user()->id) !!}
@else
    {!! Form::open(array('method' => 'post', 'route' => array('store.front.event'), 'class' => 'form')) !!}
    {!! Form::hidden('company_id', Auth::guard('company')->user()->id) !!}
@endif
<div class="row">
    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'title') !!}"> {!! Form::text('title', null, array('class'=>'form-control', 'id'=>'title', 'placeholder'=>__('Event title'), 'required'=>'required')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'title') !!} </div>
    </div>
    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'description') !!}"> {!! Form::textarea('description', null, array('class'=>'form-control', 'id'=>'description', 'placeholder'=>__('Event description'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'description') !!} </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'start_date') !!}"> {!! Form::text('start_date', null, array('class'=>'form-control datepicker', 'id'=>'start_date', 'placeholder'=>__('Start date'), 'autocomplete'=>'off', 'required'=>'required')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'start_date') !!} </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'end_date') !!}"> {!! Form::text('end_date', null, array('class'=>'form-control datepicker', 'id'=>'end_date', 'placeholder'=>__('End date'), 'autocomplete'=>'off', 'required'=>'required')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'end_date') !!} </div>
    </div>

    <div class="col-md-12">
        <div class="formrow">
            <button type="submit" class="btn">{{__('Update Event')}}
                <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
        </div>
    </div>
</div>
<input type="file" name="image" id="image" style="display:none;" accept="image/*"/>
{!! Form::close() !!}
<hr>
@push('styles')
    <style type="text/css">
        .datepicker > div {
            display: block;
        }
    </style>
@endpush
@push('scripts')
    @include('includes.tinyMCEFront')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".datepicker").datepicker({
                autoclose: true,
                format: 'yyyy-m-d',

            });
        });
    </script>
@endpush
