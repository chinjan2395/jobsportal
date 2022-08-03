<div class="modal-body">
    <div class="form-body">
        <div class="form-group" id="div_rating_id">
            <label for="rating_id" class="bold">Rating</label>
            <?php
            $rating_id = (isset($profileRating) ? $profileRating->rating_id : null);
            ?>
            {!! Form::select('rating_id', [''=>'Select rating']+$ratings, $rating_id, array('class'=>'form-control', 'id'=>'rating_id')) !!} <span class="help-block rating_id-error"></span> </div>
        <div class="form-group" id="div_rating_level_id">
            <label for="rating_level_id" class="bold">Rating Level</label>
            <?php
            $rating_level_id = (isset($profileRating) ? $profileRating->rating_level_id : null);
            ?>
            {!! Form::select('rating_level_id', [''=>'Select Rating Level']+$ratingLevels, $rating_level_id, array('class'=>'form-control', 'id'=>'rating_level_id')) !!} <span class="help-block rating_level_id-error"></span> </div>
    </div>
</div>
