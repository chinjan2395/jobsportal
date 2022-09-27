<?php

namespace App\Traits;

use Auth;
use DB;
use Illuminate\Support\Facades\Log;
use Input;
use Redirect;
use App\User;
use App\ProfileRating;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\ProfileRatingFormRequest;
use App\Helpers\DataArrayHelper;

trait ProfileRatingTrait
{

    public function showProfileRatings(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $html = '<div class="col-mid-12"><table class="table table-bordered table-condensed">';
        if (isset($user) && count($user->profileRatings)):
            foreach ($user->profileRatings as $rating):


                $html .= '<tr id="rating_' . $rating->id . '">
						<td><span class="text text-success">' . $rating->getRating('title') . '</span></td>
						<td><a href="javascript:;" onclick="showProfileRatingEditModal(' . $rating->id . ');" class="text text-warning">' . __('Edit') . '</a>&nbsp;|&nbsp;<a href="javascript:;" onclick="delete_profile_rating(' . $rating->id . ');" class="text text-danger">' . __('Delete') . '</a></td>
								</tr>';
            endforeach;
        endif;

        echo $html . '</table></div>';
    }

    public function showApplicantProfileRatings(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $html = '<div class="col-mid-12"><table class="table table-bordered table-condensed">
                <tr>
                <td width="130"><span class="text text-bold">Rating</span></td>
                <td><span class="text text-bold">Description</span></td>
                </tr>';
        if (isset($user) && count($user->profileRatings)):
            foreach ($user->profileRatings as $rating):


                $html .= '
                <tr id="rating_' . $rating->id . '">
						<td><span class="text text-success">' . $rating->getRating('title') . '</span></td>
						<td><span class="text">' . $rating->reason . '</span></td>
						</tr>';
            endforeach;
        endif;

        echo $html . '</table></div>';
    }

    public function getProfileRatingForm(Request $request, $user_id)
    {

        $ratings = DataArrayHelper::ratingsArray();
        $user = User::find($user_id);
        $returnHTML = view('admin.user.forms.rating.rating_modal')
                ->with('user', $user)
                ->with('ratings', $ratings)
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function getFrontProfileRatingForm(Request $request, $user_id)
    {

        $ratings = DataArrayHelper::ratingsArray();

        $user = User::find($user_id);
        $returnHTML = view('user.forms.rating.rating_modal')
                ->with('user', $user)
                ->with('ratings', $ratings)
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function storeProfileRating(ProfileRatingFormRequest $request, $user_id)
    {

        $profileRating = new ProfileRating();
        $profileRating = $this->assignRatingValues($profileRating, $request, $user_id);
        $profileRating->save();
        /*         * ************************************ */
        $returnHTML = view('admin.user.forms.rating.rating_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }

    public function storeFrontProfileRating(ProfileRatingFormRequest $request, $user_id)
    {

        $profileRating = new ProfileRating();
        $profileRating = $this->assignRatingValues($profileRating, $request, $user_id);
        if ($profileRating->save() == true) {
            $arr = array('msg' => 'Your rating have successfully been posted. ', 'status' => true);
            return Response()->json($arr);
        }
        return Response()->json(array('msg' => 'Something went wrong. ', 'status' => false));
    }

    public function getProfileRatingEditForm(Request $request, $user_id)
    {
        $profile_rating_id = $request->input('profile_rating_id');

        $ratings = DataArrayHelper::ratingsArray();

        $profileRating = ProfileRating::find($profile_rating_id);
        $user = User::find($user_id);

        $returnHTML = view('admin.user.forms.rating.rating_edit_modal')
                ->with('user', $user)
                ->with('profileRating', $profileRating)
                ->with('ratings', $ratings)
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function getFrontProfileRatingEditForm(Request $request, $user_id)
    {
        $profile_rating_id = $request->input('profile_rating_id');

        $ratings = DataArrayHelper::ratingsArray();

        $profileRating = ProfileRating::find($profile_rating_id);
        $user = User::find($user_id);

        $returnHTML = view('user.forms.rating.rating_edit_modal')
                ->with('user', $user)
                ->with('profileRating', $profileRating)
                ->with('ratings', $ratings)
                ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function updateProfileRating(ProfileRatingFormRequest $request, $profile_rating_id, $user_id)
    {

        $profileRating = ProfileRating::find($profile_rating_id);
        $profileRating = $this->assignRatingValues($profileRating, $request, $user_id);
        $profileRating->update();
        /*         * ************************************ */

        $returnHTML = view('admin.user.forms.rating.rating_edit_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }

    public function updateFrontProfileRating(ProfileRatingFormRequest $request, $profile_rating_id, $user_id)
    {

        $profileRating = ProfileRating::find($profile_rating_id);
        $profileRating = $this->assignRatingValues($profileRating, $request, $user_id);
        $profileRating->update();
        /*         * ************************************ */

        $returnHTML = view('user.forms.rating.rating_edit_thanks')->render();
        return response()->json(array('success' => true, 'status' => 200, 'html' => $returnHTML), 200);
    }

    public function assignRatingValues($profileRating, $request, $user_id)
    {
        $profileRating->user_id = $user_id;
        $profileRating->rating_id = $request->input('rating_id');
        $profileRating->company_id = \Illuminate\Support\Facades\Auth::guard('company')->user()->id;
        $profileRating->reason = $request->input('reason');
        return $profileRating;
    }

    public function deleteProfileRating(Request $request)
    {
        $id = $request->input('id');
        try {
            $profileRating = ProfileRating::findOrFail($id);
            $profileRating->delete();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

}
