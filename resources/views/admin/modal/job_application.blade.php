<div class="modal fade in" id="show_alert" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="display:inline-block">Job Applications</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div style="width: 100%;overflow-x: scroll;">
                    <table id="jobApplicationDatatable" class="table table-striped">
                        <thead>
                        <tr role="row">
                            <th>Company</th>
                            <th>Job Title</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Current Salary</th>
                            <th>Expected Salary</th>
                            <th>Salary Currency</th>
                            <th>Career Level</th>
                            <th>Functional Area</th>
                            <th>Industry</th>
                            <th>Job Experience</th>
                            <th>Applied Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($applications as $application)
                            @php
                                $user = optional($application)->user;
                            @endphp
                            @if($user)
                                <tr>
                                    <td>{{optional(optional(optional($application)->job)->company)->name}}</td>
                                    <td>{{optional(optional($application)->job)->title}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$application->current_salary}}</td>
                                    <td>{{$application->expected_salary}}</td>
                                    <td>{{$application->salary_currency}}</td>
                                    <td>{{optional($user->careerLevel)->career_level}}</td>
                                    <td>{{optional($user->functionalArea)->functional_area}}</td>
                                    <td>{{optional($user->industry)->industry}}</td>
                                    <td>{{optional($user->jobExperience)->job_experience}}</td>
                                    <td>{{$application->created_at}}</td>
                                </tr>
                            @else
                                <tr>
                                    <td class="text-muted">User not available</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
