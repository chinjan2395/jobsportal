<div class="modal-body">
    <div class="form-body">
        <div class="form-group" id="div_rating_id">
            <label for="rating_id" class="bold">Rating</label>
            <?php
            $rating_id = (isset($profileRating) ? $profileRating->rating_id : null);
            ?>
            {!! Form::select('rating_id', [''=>'Select rating']+$ratings, $rating_id, array('class'=>'form-control', 'id'=>'rating_id')) !!} <span class="help-block rating_id-error"></span> </div>

        <div class="formrow" id="div_reason">
            <input class="form-control" id="reason" placeholder="{{__('Reason')}}" name="reason" type="text" value="{{(isset($profileRating)? $profileRating->reason:'')}}">
            <span class="help-block title-error"></span> </div>
    </div>
</div>
