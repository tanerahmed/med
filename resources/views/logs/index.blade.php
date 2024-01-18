@extends('admin.dashboard')
@section('admin')


<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Logs</h4>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Logs</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>       
                                    <th>Causer</th>                             
                                    <th>Subject</th>

                                    <th>Description</th>
                                    <th>Properties</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <td>{{ $log->id }}</td>
                                        <td>{{ $log->created_at }}</td>
                                        <td>{{ optional($log->causer)->name }}</td>
                                        <td>{{ $log->subject_type }} ({{ $log->subject_id }})</td>
                                        <td>{{ $log->description }}</td>

                                        <td>
                                            @if(isset($log->properties['attributes']))
                                                @if(isset($log->properties['attributes']['name']))
                                                    Name: <b>{{ $log->properties['attributes']['name'] }} </b> |
                                                @endif
                                                @if(isset($log->properties['attributes']['email']))
                                                    Email: <b>{{ $log->properties['attributes']['email'] }}</b> |
                                                @endif
                                                @if(isset($log->properties['attributes']['role']))
                                                    Role: <b>{{ $log->properties['attributes']['role'] }} </b>
                                                @endif
                                            @endif

                                            @if(isset($log->properties['old']))
                                            @if(isset($log->properties['old']['name']))
                                                Name: <b>{{ $log->properties['old']['name'] }} </b> |
                                            @endif
                                            @if(isset($log->properties['old']['email']))
                                                Email: <b>{{ $log->properties['old']['email'] }}</b> |
                                            @endif
                                            @if(isset($log->properties['old']['role']))
                                                Role: <b>{{ $log->properties['old']['role'] }} </b>
                                            @endif
                                        @endif
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

</div>


@endsection