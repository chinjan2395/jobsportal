<?php


namespace App\Traits;

use App\Helpers\DataArrayHelper;
use App\Http\Requests\CompanyEventFormRequest;
use App\CompanyEvent;
use App\Seo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


trait CompanyEventTrait
{
    public function eventsBySearch(Request $request)
    {
        $company = Auth::guard('company')->user();
        $search = $request->query('search', '');
        $event_titles = $request->query('event_title', array());
        $company_ids = $request->query('company_id', array());
        $order_by = $request->query('order_by', 'id');
        $limit = 15;

        $events = $company->events()->paginate();
        return view('company.events')
            ->with('events', $events);
    }

    public function eventDetail(Request $request, $event_slug)
    {

        $event = CompanyEvent::where('slug', 'like', $event_slug)->firstOrFail();
        /*         * ************************************************** */
        $search = '';
        $event_titles = array();
        $company_ids = array();
        $industry_ids = array();
        $start_date = 0;
        $end_date = 0;
        $is_featured = 2;
        $order_by = 'id';
        $limit = 5;

//        $relatedEvents = $this->fetchEvents($search, $event_titles, $company_ids, $industry_ids, $start_date, $end_date, $is_featured, $order_by, $limit);
        /*         * ***************************************** */

//        $seoArray = $this->getSEO();
        /*         * ************************************************** */
        $seo = (object)array(
            'seo_title' => $event->title,
            'seo_description' => '',
            'seo_keywords' => '',
            'seo_other' => ''
        );
        return view('company.inc.event-detail')
            ->with('event', $event)
            ->with('relatedEvents', [])
            ->with('seo', $seo);
    }

    private function updateFullTextSearch($model)
    {
        $str = '';
        $str .= ' ' . $model->title;
        $model->search = $str;

        $model->update();

    }

    private function assignCompanyEventValues($model, $request)
    {
        $model->title = $request->input('title');
        $model->description = $request->input('description');
        $model->start_date = $request->input('start_date');
        $model->end_date = $request->input('end_date');
        return $model;

    }

    public function createFrontCompanyEvent()
    {
        $company = Auth::guard('company')->user();

        if ((bool)$company->is_active === false) {
            flash(__('Your account is inactive contact site admin to activate it'))->error();
            return \Redirect::route('company.home');
        }

        return view('company.add_edit_event');

    }

    public function storeFrontCompanyEvent(CompanyEventFormRequest $request)
    {
        $company = Auth::guard('company')->user();

        if ((bool)$company->is_active === false) {
            flash(__('Your account is inactive contact site admin to activate it'))->error();
            return \Redirect::route('company.home');
        }

        $model = new CompanyEvent();
        $model->company_id = $company->id;
        $model = $this->assignCompanyEventValues($model, $request);
        $model->save();

        $model->slug = Str::slug($model->title, '-') . '-' . $model->id;

        $model->update();
        $this->updateFullTextSearch($model);

        $company->update();

//        event(new CompanyEventPosted($model));

        flash('Event has been added!')->success();

        return \Redirect::route('edit.front.event', array($model->id));

    }

    public function editFrontCompanyEvent($id)
    {
        $model = CompanyEvent::findOrFail($id);

        return view('company.add_edit_event')
            ->with('event', $model);

    }

    public function updateFrontCompanyEvent($id, CompanyEventFormRequest $request)
    {
        $model = CompanyEvent::findOrFail($id);
        $model = $this->assignCompanyEventValues($model, $request);
        $model->slug = Str::slug($model->title, '-') . '-' . $model->id;
        $model->update();
        /*         * ************************************ */
        $this->updateFullTextSearch($model);
        /*         * ************************************ */
        flash('Event has been updated!')->success();
        return \Redirect::route('edit.front.event', array($model->id));

    }

    public function deleteCompanyEvent(Request $request)
    {
        $id = $request->input('id');
        try {
            $model = CompanyEvent::findOrFail($id);
            $model->delete();
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }

    }

    public function scopeNotExpire($query)
    {
        return $query->whereDate('end_date', '>', Carbon::now());
        //where('end_date', '>=', date('Y-m-d'));
    }

    public function isEventExpired()
    {
        return ($this->end_date < Carbon::now()) ? true : false;
    }
}
