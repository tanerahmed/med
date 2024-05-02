@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Articles</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-xl-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="pt-0">ID</th>
                                        <th class="pt-0">Article ID</th>
                                        <th class="pt-0">Date</th>
                                        <th class="pt-0">Article Name</th>
                                        <th class="pt-0">Causer</th>
                                        {{-- <th class="pt-0">Subject</th> --}}
                                        <th class="pt-0">Description</th>
                                        <th class="pt-0">Properties</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $log)
                                        <tr>
                                            <td>{{ $log->id }}</td> {{-- ID --}}
                                            <td>
                                                @if (isset($log->properties['articleId']))
                                                    {{ $log->properties['articleId'] }}
                                                @endif
                                            </td> {{-- Article ID --}}
                                            <td>{{ $log->created_at }}</td> {{-- Date --}}
                                            <td>
                                                @if (isset($log->properties['articleName']))
                                                    {{ $log->properties['articleName'] }}
                                                @endif
                                            </td> {{-- Article NAME --}}
                                            <td>{{ optional($log->causer)->name }}</td> {{-- Caauser --}}
                                            <td>{{ $log->description }}</td> {{-- Description --}}
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
                                                @if (isset($log->properties['publishArticle']))
                                                    {{ $log->properties['publishArticle'] }}
                                                @endif
                                                @if (isset($log->properties['acceptArticle']))
                                                    {{ $log->properties['acceptArticle'] }}
                                                @endif

                                                {{-- sendEmailForReviewRequest --}}
                                                @if (isset($log->properties['sendEmailForReviewRequest']))
                                                    {{ $log->properties['sendEmailForReviewRequest'] }}
                                                @endif

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
                                            </td> {{-- Proparties --}}

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

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "pageLength": 100, // Set the default number of records per page to 100
                "order": [
                    [1, "asc"]
                ] // Сортиране по втората колона (индекс 1) във възходящ ред
            });
        });
    </script>
@endsection
