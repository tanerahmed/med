@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Logs</h4>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Causer</th>
                                        {{-- <th>Subject</th> --}}
                                        <th>Description</th>
                                        <th>Properties</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $log)
                                        <tr>
                                            <td>{{ $log->id }}</td>
                                            <td>{{ $log->created_at }}</td>
                                            <td>{{ optional($log->causer)->name }}</td>
                                            {{-- <td>{{ $log->subject_type }}</td> --}}
                                            <td>{{ $log->description }}</td>
                                            <td>
                                                {{-- User --}}
                                                @if (isset($log->properties['attributes']['name']))
                                                    Name: <b>{{ $log->properties['attributes']['name'] }} </b> |
                                                @endif
                                                @if (isset($log->properties['attributes']['email']))
                                                    Email: <b>{{ $log->properties['attributes']['email'] }}</b> |
                                                @endif
                                                @if (isset($log->properties['attributes']['role']))
                                                    Role: <b>{{ $log->properties['attributes']['role'] }} </b>
                                                @endif
                                                {{-- Article --}}
                                                @if (isset($log->properties['attributes']['id']))
                                                    Article ID: <b>{{ $log->properties['attributes']['id'] }} </b>
                                                @endif
                                                @if (isset($log->properties['attributes']['user_id']))
                                                    Author ID: <b>{{ $log->properties['attributes']['user_id'] }} </b>
                                                @endif
                                                {{-- Co Author --}}
                                                @if (isset($log->properties['attributes']['contact_email']))
                                                    Email: <b>{{ $log->properties['attributes']['contact_email'] }}
                                                    </b>
                                                @endif
                                                @if (isset($log->properties['rating']))
                                                    <b>Article ID {{ $log->properties['article_id'] }}</b> -
                                                    <b>{{ $log->properties['rating'] }} </b>
                                                @endif
                                                @if (isset($log->properties['approveReviewRequestArticleId']))
                                                    {{ $log->properties['approveReviewRequestArticleId'] }} 
                                                @endif
                                                @if (isset($log->properties['rejectReviewRequest']))
                                                    {{ $log->properties['rejectReviewRequest'] }}
                                                @endif
                                                @if (isset($log->properties['xmlFIleError']))
                                                    <b>There is a problem with create XML file for Article ID {{ $log->properties['xmlFIleError'] }}</b>
                                                @endif

                                                @if (isset($log->properties['force_reviewer_msg']))
                                                    {{ $log->properties['force_reviewer_msg'] }}
                                                @endif


                                                @if (isset($log->properties['old']))
                                                    {{-- User --}}
                                                    @if (isset($log->properties['old']['name']))
                                                        Name: <b>{{ $log->properties['old']['name'] }} </b> |
                                                    @endif
                                                    @if (isset($log->properties['old']['email']))
                                                        Email: <b>{{ $log->properties['old']['email'] }}</b> |
                                                    @endif
                                                    @if (isset($log->properties['old']['role']))
                                                        Role: <b>{{ $log->properties['old']['role'] }} </b>
                                                    @endif
                                                    {{-- Article --}}
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
