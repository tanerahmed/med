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
                                        <th>Article Name</th>
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
                                            <td>@if (isset($log->properties['articleName']))
                                                {{ $log->properties['articleName'] }}
                                            @endif</td>
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
                                                @if (isset($log->properties['createArticle']))
                                                    {{ $log->properties['createArticle'] }}
                                                @endif
                                                @if (isset($log->properties['updateArticle']))
                                                    {{ $log->properties['updateArticle'] }}
                                                @endif
                                                @if (isset($log->properties['deleteArticle']))
                                                    {{ $log->properties['deleteArticle'] }}
                                                @endif

                                                {{-- sendEmailForReviewRequest --}}
                                                @if (isset($log->properties['sendEmailForReviewRequest']))
                                                    {{ $log->properties['sendEmailForReviewRequest'] }}
                                                @endif
                                                {{-- coAuthorApprove --}}
                                                {{-- @if (isset($log->properties['coAuthorApprove']))
                                                    {{ $log->properties['coAuthorApprove'] }} 
                                                @endif --}}

                                                {{-- Co Author --}}
                                                @if (isset($log->properties['attributes']['contact_email']))
                                                    Email: <b>{{ $log->properties['attributes']['contact_email'] }}
                                                    </b>
                                                @endif

                                                {{-- review --}}
                                                @if (isset($log->properties['review']))
                                                    {{ $log->properties['review'] }}
                                                @endif
                                                @if (isset($log->properties['fullAccept']))
                                                    {{ $log->properties['fullAccept'] }}
                                                @endif
                                                @if (isset($log->properties['approveReviewRequestArticleId']))
                                                    {{ $log->properties['approveReviewRequestArticleId'] }}
                                                @endif
                                                @if (isset($log->properties['rejectReviewRequest']))
                                                    {{ $log->properties['rejectReviewRequest'] }}
                                                @endif
                                                @if (isset($log->properties['xmlFIleCreate']))
                                                    {{ $log->properties['xmlFIleCreate'] }}
                                                @endif
                                                @if (isset($log->properties['xmlFIleError']))
                                                    {{ $log->properties['xmlFIleError'] }}
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
