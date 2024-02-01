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
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    @if (Auth::check() && Auth::user()->role === 'admin')
                                    <th class="pt-0">User</th>
                                    @endif
                                    <th class="pt-0">#</th>
                                    <th class="pt-0">Type</th>
                                    <th class="pt-0">Specialty</th>
                                    <th class="pt-0">Scientific area</th>
                                    <th class="pt-0">Status</th>
                                    <th class="pt-0">Date</th>
                                    <th class="pt-0">Download</th>
                                    <th class="pt-0">Reviews</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($articles as $article)
                                    <tr>
                                        @if (Auth::check() && Auth::user()->role === 'admin')
                                        <td>{{ Auth::user()->name }}</td>
                                        @endif
                                        <td>{{ $article->id }}</td>
                                        <td>{{ $article->type }}</td>
                                        <td>{{ $article->specialty }}</td>
                                        <td>{{ $article->scientific_area }}</td>
                                        <td><span class="badge bg-{{ $article->status_color }}">{{ $article->status_text }}</span></td>
                                        <td>{{ $article->updated_at }}</td>
                                        <td>
                                            <button>Html</button>
                                            <button>PDF</button>
                                        </td>
                                        <td>
                                            <!-- Разгъната секция за ревюта -->
                                            @foreach ($preparedReviews as $preparedReview)
                                                @if (isset($review['message']))
                                                    <span>{{ $review['message'] }}</span>
                                                @else
                                                    @if ($preparedReview['article_id'] == $article->id)
                                                        <div class="review">
                                                            <span>Reviewer 1: {{ $preparedReview['reviewer1_name'] }} - Rating: {{ $preparedReview['rating_1'] ?: 'N/A' }}</span><br>
                                                            <span>Reviewer 2: {{ $preparedReview['reviewer2_name'] }} - Rating: {{ $preparedReview['rating_2'] ?: 'N/A' }}</span><br>
                                                            <span>Reviewer 3: {{ $preparedReview['reviewer3_name'] }} - Rating: {{ $preparedReview['rating_3'] ?: 'N/A' }}</span><br>
                                                            <!-- Добавете подобни редове за останалите ревютори -->
                                                        </div>
                                                    @endif
                                                @endif
                                            @endforeach
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
