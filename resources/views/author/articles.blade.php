@extends('admin.dashboard')
@section('admin')

<style>
    #dataTable {
        width: 100% !important;
        table-layout: fixed;
    }
    #dataTable td, #dataTable th {
        white-space: normal;
        height: auto;
    }
    /* ID */
    #dataTable th:nth-child(1), #dataTable td:nth-child(1) {
        width: 20px; /* Можеш да промениш тази стойност според нуждите */
        text-align: center;
    }
/* Type */
    #dataTable th:nth-child(2), #dataTable td:nth-child(2) {
        width: 80px;
        text-align: center;
    }
/* Specality */
    #dataTable th:nth-child(3), #dataTable td:nth-child(3) {
        width: 70px;
        text-align: center;
    }

    /* Specality Area */
    #dataTable th:nth-child(4), #dataTable td:nth-child(4) {
        width: 100px;
        text-align: center;
    }


    /* Title*/
    #dataTable th:nth-child(5), #dataTable td:nth-child(5) {
        width: 500px;
    }

    /* Date*/
    #dataTable th:nth-child(6), #dataTable td:nth-child(6) {
        width: 50px;
    }

    /* Issue*/
    #dataTable th:nth-child(7), #dataTable td:nth-child(7) {
        width: 25px;
    }

       /* Acction*/
       #dataTable th:nth-child(8), #dataTable td:nth-child(8) {
        width: 450px;
    }      
     /* Review*/
       #dataTable th:nth-child(9), #dataTable td:nth-child(98) {
        width: 100px;
    }
</style>


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
                            {{-- <table class="table table-hover mb-0"> --}}
                            <table id="dataTable" class="table table-hover mb-0">

                                <thead>
                                    <tr>
                                        @if (Auth::check() && Auth::user()->role === 'admin')
                                            {{-- <th class="pt-0">Author</th> --}}
                                        @endif
                                        <th class="pt-0">#</th>
                                        <th class="pt-0">Type</th>
                                        <th class="pt-0">Specialty</th>
                                        <th class="pt-0">Scientific area</th>
                                        <th class="pt-0">Title</th>
                                        {{-- <th class="pt-0">Status</th> --}}
                                        <th class="pt-0">Date</th>
                                        <th class="pt-0">Issue</th>
                                        <th class="pt-0">Actions</th>
                                        <th class="pt-0">Reviews</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($articles as $article)
                                        <tr>
                                            @if (Auth::check() && Auth::user()->role === 'admin')
                                                {{-- <td>{{ $article->user->name }}</td> --}}
                                            @endif
                                            <td>{{ $article->id }}</td>
                                            <td>{{ $article->type }}</td>
                                            <td>{{ $article->specialty }}</td>
                                            <td>{{ $article->scientific_area }}</td>
                                            <td>{{ $article->title }}</td>
                                            {{-- <td><span class="badge bg-{{ $article->status_color }}">{{ $article->status_text }}</span></td> --}}
                                            {{-- <td>{!! $article->statusFromReview !!}</td> --}}
                                            <td>{{ $article->created_at }}</td>
                                            <td>{{ $article->issue_id }}</td>

                                            <td>
                                                @if (Auth::check())
                                                    @php
                                                        $user = Auth::user();
                                                    @endphp
                                            
                                                    @if ($user->role === 'admin')
                                                        @if ($article->status === 'declined')
                                                        <a href="#" class="btn btn-danger btn-sm disabled">Declined</a>
                                                        @else
                                                            @if ($article->admin_accept === 0)
                                                                <a href="{{ route('articles.adminAcceptArticleBlade', $article->id) }}"class="btn btn-warning btn-sm">Editor Accept</a>
                                                                <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary btn-sm disabled">Reviews</a>
                                                            @else
                                                                <a href="{{ route('articles.adminAcceptArticleBlade', $article->id) }}"class="btn btn-warning btn-sm disabled">Editor Accept</a>
                                                                <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary btn-sm">Reviews</a>
                                                                {{-- <a href="{{ route('pdfs.upload', $article->id) }}" class="btn btn-success btn-sm">Upload PDF</a> --}}
                                                            @endif
                                            
                                                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this article?')">Delete</button>
                                                            </form>
                                            
                                                            
                                            
                                                            @if ($article->status === 'accepted')
                                                                <a href="{{ route('articles.addIssueIdBlade', $article->id) }}" class="btn btn-warning btn-sm">Publish</a>
                                                            @endif

                                                            @if ($article->status === 'accepted')
                                                                <button type="submit" class="btn btn-warning btn-sm disabled">Send Edit</button>
                                                            @else
                                                                <form action="{{ route('article.editAuthorCanEdit', $article->id) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('GET')
                                                                    <input type="hidden" name="author_can_edit" value="1">
                                                                    <button type="submit" class="btn btn-warning btn-sm">Send Edit</button>
                                                                </form>
                                                            @endif

                                                        @endif
                                                    @endif
                                            
                                                    @if ($user->role === 'author')
                                                        @if ($article->status === 'accepted')
                                                            <a href="{{ route('articles.articleEdit', $article->id) }}" class="btn btn-warning btn-sm disabled">Full Accept</a>
                                                        @elseif ($article->status === 'declined')
                                                            <a href="{{ route('articles.articleEdit', $article->id) }}" class="btn btn-warning btn-sm disabled">Declined</a>
                                                        @elseif ($article->author_can_edit === 1)
                                                            <a href="{{ route('articles.articleEdit', $article->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                        @endif
                                                    @endif
                                            
                                                    @if ($user->role === 'reviewer' && $article->author_can_edit === 1)
                                                        <a href="{{ route('articles.articleEdit', $article->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    @endif
                                            
                                                    @if (($user->role === 'author' || $user->role === 'reviewer') && $article->status !== 'accepted')
                                                        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this article?')">Delete</button>
                                                        </form>
                                                    @endif
                                            
                                                    <a href="{{ route('review.downolad_files', $article->id) }}" class="btn btn-success btn-sm">Download ZIP</a>
                                                @endif
                                            </td>
                                            
                                            <td>
                                                @if (Auth::check() && Auth::user()->role === 'admin')
                                                    @foreach ($preparedReviews as $preparedReview)
                                                        @if ($preparedReview['article_id'] == $article->id)
                                                            <div class="review">
                                                                <span>1. {{ $preparedReview['reviewer1_name'] }} -
                                                                    @if (!empty($preparedReview['reviewer1_id']))
                                                                        <strong>
                                                                            <a
                                                                                href="{{ route('reviews.showReviewComments', ['article_id' => $article->id, 'user_id' => $preparedReview['reviewer1_id']]) }}">
                                                                                {{ $preparedReview['rating_1'] ?: '' }}
                                                                            </a>
                                                                        </strong>
                                                                    @else
                                                                        <strong>{{ $preparedReview['rating_1'] ?: '' }}</strong>
                                                                    @endif
                                                                </span>
                                                                <br>
                                                                <span>2. {{ $preparedReview['reviewer2_name'] }} -
                                                                    @if (!empty($preparedReview['reviewer2_id']))
                                                                        <strong>
                                                                            <a
                                                                                href="{{ route('reviews.showReviewComments', ['article_id' => $article->id, 'user_id' => $preparedReview['reviewer2_id']]) }}">
                                                                                {{ $preparedReview['rating_2'] ?: '' }}
                                                                            </a>
                                                                        </strong>
                                                                    @else
                                                                        <strong>{{ $preparedReview['rating_2'] ?: '' }}</strong>
                                                                    @endif
                                                                </span>
                                                                <br>
                                                                <span>3. {{ $preparedReview['reviewer3_name'] }} -
                                                                    @if (!empty($preparedReview['reviewer3_id']))
                                                                        <strong>
                                                                            <a
                                                                                href="{{ route('reviews.showReviewComments', ['article_id' => $article->id, 'user_id' => $preparedReview['reviewer3_id']]) }}">
                                                                                {{ $preparedReview['rating_3'] ?: '' }}
                                                                            </a>
                                                                        </strong>
                                                                    @else
                                                                        <strong>{{ $preparedReview['rating_3'] ?: '' }}</strong>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @if ($article->status === 'accepted')
                                                        <span>Full Accept!</span>
                                                    @elseif ($article->status === 'review_needed')
                                                        <span>Review Needed</span>
                                                    @elseif ($article->status === 'pending')
                                                        <span>Pending...</span>
                                                    @elseif ($article->status === 'declined')
                                                        <span>Declined!</span>
                                                    @else
                                                        <span>Under Review.</span>
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

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "order": [
                    [5, "desc"]
                ] // Сортиране по втората колона (индекс 1) във възходящ ред
            });
        });
    </script>
@endsection
