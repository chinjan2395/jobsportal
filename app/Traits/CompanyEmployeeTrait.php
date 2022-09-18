<?php

namespace App\Traits;


use App\Employee;
use App\Helpers\DataArrayHelper;
use App\Http\Requests\EmployeeFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

trait CompanyEmployeeTrait
{
    public function indexEmployee()
    {
        return view('admin.employee.index');
    }

    public function createEmployee()
    {
        $companies = DataArrayHelper::companiesArray();
        $countries = DataArrayHelper::defaultCountriesArray();
        $industries = DataArrayHelper::defaultIndustriesArray();
        $ownershipTypes = DataArrayHelper::defaultOwnershipTypesArray();

        return view('admin.employee.add')
            ->with('companies', $companies)
            ->with('countries', $countries)
            ->with('industries', $industries)
            ->with('ownershipTypes', $ownershipTypes);
    }

    public function storeEmployee(EmployeeFormRequest $request)
    {
        $company = new Employee();
        /*         * **************************************** */
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $fileName = ImgUploader::UploadImage('company_logos', $image, $request->input('name'), 300, 300, false);
            $company->logo = $fileName;
        }
        /*         * ************************************** */

        $company->name = $request->input('name');
        $company->email = $request->input('email');

        if (!empty($request->input('password'))) {
            $company->password = Hash::make($request->input('password'));
        }
        $company->ceo = $request->input('ceo');
        $company->industry_id = $request->input('industry_id');
        $company->ownership_type_id = $request->input('ownership_type_id');
        $company->description = $request->input('description');
        $company->location = $request->input('location');
        $company->map = $request->input('map');
        $company->no_of_offices = $request->input('no_of_offices');
        $website = $request->input('website');
        $company->website = (false === strpos($website, 'http')) ? 'http://' . $website : $website;
        $company->no_of_employees = $request->input('no_of_employees');
        $company->established_in = $request->input('established_in');
        $company->fax = $request->input('fax');
        $company->phone = $request->input('phone');
        $company->facebook = $request->input('facebook');
        $company->twitter = $request->input('twitter');
        $company->linkedin = $request->input('linkedin');
        $company->google_plus = $request->input('google_plus');
        $company->pinterest = $request->input('pinterest');
        $company->country_id = $request->input('country_id');
        $company->state_id = $request->input('state_id');
        $company->city_id = $request->input('city_id');
        $company->is_active = $request->input('is_active');
        $company->is_featured = $request->input('is_featured');
        $company->is_employee = 1;
        $company->belongs_to = $request->input('belongs_to');
        $company->save();

        /*         * ******************************* */
        $company->slug = Str::slug($company->name, '-') . '-' . $company->id;

        /*         * ******************************* */
        $company->update();

        /*         * ************************************ */

        flash('Employee has been added!')->success();
        return \Redirect::route('edit.employee', array($company->id));
    }

    public function editEmployee($id)
    {
        $companies = DataArrayHelper::companiesArray();
        $countries = DataArrayHelper::defaultCountriesArray();
        $industries = DataArrayHelper::defaultIndustriesArray();
        $ownershipTypes = DataArrayHelper::defaultOwnershipTypesArray();
        $company = Employee::with('company')->findOrFail($id);

        return view('admin.employee.edit')
            ->with('companies', $companies)
            ->with('company', $company)
            ->with('countries', $countries)
            ->with('industries', $industries)
            ->with('ownershipTypes', $ownershipTypes);
    }

    public function updateEmployee($id, EmployeeFormRequest $request)
    {
        $company = Employee::findOrFail($id);
        /*         * **************************************** */
        if ($request->hasFile('logo')) {
            $is_deleted = $this->deleteCompanyLogo($company->id);
            $image = $request->file('logo');
            $fileName = ImgUploader::UploadImage('company_logos', $image, $request->input('name'), 300, 300, false);
            $company->logo = $fileName;
        }
        /*         * ************************************** */
        $company->name = $request->input('name');
        $company->email = $request->input('email');

        if (!empty($request->input('password'))) {
            $company->password = Hash::make($request->input('password'));
        }

        $company->ceo = $request->input('ceo');
        $company->industry_id = $request->input('industry_id');
        $company->ownership_type_id = $request->input('ownership_type_id');
        $company->description = $request->input('description');
        $company->location = $request->input('location');
        $company->map = $request->input('map');
        $company->no_of_offices = $request->input('no_of_offices');
        $website = $request->input('website');
        $company->website = (false === strpos($website, 'http')) ? 'http://' . $website : $website;
        $company->no_of_employees = $request->input('no_of_employees');
        $company->established_in = $request->input('established_in');
        $company->fax = $request->input('fax');
        $company->phone = $request->input('phone');
        $company->facebook = $request->input('facebook');
        $company->twitter = $request->input('twitter');
        $company->linkedin = $request->input('linkedin');
        $company->google_plus = $request->input('google_plus');
        $company->pinterest = $request->input('pinterest');
        $company->country_id = $request->input('country_id');
        $company->state_id = $request->input('state_id');
        $company->city_id = $request->input('city_id');
        $company->is_active = $request->input('is_active');
        $company->is_featured = $request->input('is_featured');
        $company->slug = Str::slug($company->name, '-') . '-' . $company->id;
        $company->is_employee = $request->input('is_employee');
        $company->belongs_to = $request->input('belongs_to');
        $company->update();

        flash('Employee has been updated!')->success();
        return \Redirect::route('edit.employee', array($company->id));
    }

    public function fetchEmployeesData(Request $request)
    {
        $companies = Employee::select([
            'companies.id',
            'companies.name',
            'companies.email',
            'companies.password',
            'companies.ceo',
            'companies.industry_id',
            'companies.ownership_type_id',
            'companies.description',
            'companies.location',
            'companies.no_of_offices',
            'companies.website',
            'companies.no_of_employees',
            'companies.established_in',
            'companies.fax',
            'companies.phone',
            'companies.logo',
            'companies.country_id',
            'companies.state_id',
            'companies.city_id',
            'companies.is_active',
            'companies.is_employee',
        ]);

        return Datatables::of($companies)
            ->filter(function ($query) use ($request) {
                if ($request->has('name') && !empty($request->name)) {
                    $query->where('companies.name', 'like', "%{$request->get('name')}%");
                }

                if ($request->has('email') && !empty($request->email)) {
                    $query->where('companies.email', 'like', "%{$request->get('email')}%");
                }

                if ($request->has('is_active') && $request->is_active != -1) {
                    $query->where('companies.is_active', '=', "{$request->get('is_active')}");
                }
            })
            ->addColumn('is_active', function ($companies) {
                return ((bool)$companies->is_active) ? 'Yes' : 'No';
            })
            ->addColumn('action', function ($companies) {
                $activeTxt = 'Make Active';
                $activeHref = 'makeActive(' . $companies->id . ');';
                $activeIcon = 'square-o';

                if ((int)$companies->is_active == 1) {
                    $activeTxt = 'Make InActive';
                    $activeHref = 'makeNotActive(' . $companies->id . ');';
                    $activeIcon = 'check-square-o';
                }
                return '
				<div class="btn-group">
					<button class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action<i class="fa fa-angle-down"></i></button>
					<ul class="dropdown-menu">
						<li><a href="' . route('edit.employee', ['id' => $companies->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a></li>						
						<li><a href="javascript:void(0);" onclick="deleteCompany(' . $companies->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a></li>
						<li><a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $companies->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a></li>
                    </ul>
				</div>';
            })
            ->rawColumns(['action', 'is_active'])
            ->setRowId(function ($companies) {
                return 'companyDtRow' . $companies->id;
            })
            ->make(true);
    }
}
