<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DataArrayHelper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\FeedbackAndEnquiry;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class FeedbackAndEnquiryController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index($type = 'feedback')
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.' . $type . '.index')->with('languages', $languages);
    }

    public function fetchData(Request $request, $type = 'feedback')
    {
        $models = FeedbackAndEnquiry::select(['*'])->where('action', $type);
        return Datatables::of($models)
            ->filter(function ($query) use ($request) {
                if ($request->has('content') && !empty($request->get('content'))) {
                    $query->where('feedback_and_enquiries.content', 'like', "%{$request->get('content')}%");
                }
            })
            ->addColumn('company', function ($models) {
                $class = new $models->actionable_type;
                try {
                    return optional(optional($class->findOrFail($models->actionable_id))->company)->name;
                } catch (ModelNotFoundException $exception) {
                    return '-';
                }
            })
            ->addColumn('job', function ($models) {
                $class = new $models->actionable_type;
                try {
                    return optional($class->findOrFail($models->actionable_id))->title;
                } catch (ModelNotFoundException $exception) {
                    return '-';
                }
            })
            ->addColumn('user', function ($models) {
                try {
                    $user = User::findOrFail($models->user_id);
                    return optional($user)->name . " [<small>" . optional($user)->email . "</small>]";
                } catch (ModelNotFoundException $exception) {
                    return '-';
                }
            })
            ->addColumn('action', function ($models) {
                return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="javascript:void(0);" onclick="delete_faq(' . $models->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>																																							
					</ul>
				</div>';
            })
            ->rawColumns(['company', 'user', 'action'])
            ->setRowId(function ($models) {
                return 'faq_dt_row_' . $models->id;
            })
            ->make(true);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        try {
            $faq = FeedbackAndEnquiry::findOrFail($id);
            $faq->delete();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

}
