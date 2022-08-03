{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <div class="form-group">
        <button class="btn purple btn-outline sbold" onclick="showProfileRatingModal();"> Add Rating </button>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption"> <i class=" icon-layers font-green"></i> <span class="caption-subject font-green bold uppercase">Rating</span> </div>
                </div>
                <div class="portlet-body"><div class="row" id="rating_div"></div></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-modal-lg" id="add_rating_modal" tabindex="-1" role="dialog" aria-hidden="true"></div>
@push('css')
<style type="text/css">
    .datepicker>div {
        display: block;
    }
</style>
@endpush
@push('scripts') 
<script type="text/javascript">
    /**************************************************/
    function showProfileRatingModal(){
    $("#add_rating_modal").modal();
    loadProfileRatingForm();
    }
    function loadProfileRatingForm(){
    $.ajax({
    type: "POST",
            url: "{{ route('get.profile.rating.form', $user->id) }}",
            data: {"_token": "{{ csrf_token() }}"},
            datatype: 'json',
            success: function (json) {
            $("#add_rating_modal").html(json.html);
            }
    });
    }
    function showProfileRatingEditModal(profile_rating_id){
    $("#add_rating_modal").modal();
    loadProfileRatingEditForm(profile_rating_id);
    }
    function loadProfileRatingEditForm(profile_rating_id){
    $.ajax({
    type: "POST",
            url: "{{ route('get.profile.rating.edit.form', $user->id) }}",
            data: {"profile_rating_id": profile_rating_id, "_token": "{{ csrf_token() }}"},
            datatype: 'json',
            success: function (json) {
            $("#add_rating_modal").html(json.html);
            }
    });
    }
    function submitProfileRatingForm() {
    var form = $('#add_edit_profile_rating');
    $.ajax({
    url     : form.attr('action'),
            type    : form.attr('method'),
            data    : form.serialize(),
            dataType: 'json',
            success : function (json){
            $ ("#add_rating_modal").html(json.html);
            showRatings();
            },
            error: function(json){
            if (json.status === 422) {
            var resJSON = json.responseJSON;
            $('.help-block').html('');
            $.each(resJSON.errors, function (key, value) {
            $('.' + key + '-error').html('<strong>' + value + '</strong>');
            $('#div_' + key).addClass('has-error');
            });
            } else {
            // Error
            // Incorrect credentials
            // alert('Incorrect credentials. Please try again.')
            }
            }
    });
    }
    function delete_profile_rating(id) {
    if (confirm('Are you sure! you want to delete?')) {
    $.post("{{ route('delete.profile.rating') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            if (response == 'ok')
            {
            $('#rating_' + id).remove();
            } else
            {
            alert('Request Failed!');
            }
            });
    }
    }
    $(document).ready(function(){
    showRatings();
    });
    function showRatings()
    {
    $.post("{{ route('show.profile.ratings', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            $('#rating_div').html(response);
            });
    }
</script> 
@endpush
