<div class="modal fade in" id="show_alert" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Job Applications
                    <button type="button" class="close" data-dismiss="modal">&times;</button></h4>
            </div>
            <div class="modal-body">

                <table class="table table-striped">
                    <thead>
                    <tr role="row">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Current Salary</th>
                        <th>Expected Salary</th>
                        <th>Salary Currency</th>
                        <th>Applied Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($applications as $application)
                        <tr>
                            @php
                                $user = $application->user;
                            @endphp
                            @if($user)
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$application->current_salary}}</td>
                                <td>{{$application->expected_salary}}</td>
                                <td>{{$application->salary_currency}}</td>
                                <td>{{$application->created_at}}</td>
                            @else
                                <td colspan="6" class="text-center">User information not available.</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
