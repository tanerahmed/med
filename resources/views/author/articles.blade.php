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
                                            <th class="pt-0">Author</th>
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
                                                <td>{{ $article->user->name }}</td>
                                            @endif
                                            <td>{{ $article->id }}</td>
                                            <td>{{ $article->type }}</td>
                                            <td>{{ $article->specialty }}</td>
                                            <td>{{ $article->scientific_area }}</td>
                                            <td>{{ $article->title }}</td>
                                            {{-- <td><span class="badge bg-{{ $article->status_color }}">{{ $article->status_text }}</span></td> --}}
                                            {{-- <td>{!! $article->statusFromReview !!}</td> --}}
                                            <td>{{ $article->updated_at }}</td>
                                            <td>{{ $article->issue_id }}</td>
                                            <td>
                                                @if (Auth::check() && Auth::user()->role === 'admin')
                                                    @if ($article->admin_accept === 0)
                                                        <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary btn-sm disabled">Reviews<i class="fas fa-users"></i></a>
                                                    @else
                                                        <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary btn-sm" >Reviews<i class="fas fa-users"></i></a>
                                                    @endif
                                               
                                                @endif
                                                @if (Auth::user()->role === 'author' && $article->isAccepted)
                                                    <a href="{{ route('articles.articleEdit', $article->id) }}" class="btn btn-warning btn-sm disabled" >Full Accept<i class="fas fa-edit"></i></a>
                                                @elseif  (Auth::user()->role === 'author' && $article->isDeclined)
                                                    <a href="{{ route('articles.articleEdit', $article->id) }}" class="btn btn-warning btn-sm disabled" >Declined<i class="fas fa-edit"></i></a>
                                                @elseif  (Auth::user()->role === 'author' || Auth::user()->role === 'admin')
                                                    <a href="{{ route('articles.articleEdit', $article->id) }}" class="btn btn-warning btn-sm">Edit<i class="fas fa-edit"></i></a>
                                                @endif
                                                
                                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this article?')">Delete</button>
                                                </form>
                                                
                                                <a href="{{ route('review.downolad_files', $article->id) }}" class="btn btn-success btn-sm">Download ZIP<i class="fas fa-download"></i></a>
                                                <a href="{{ route('admin.downolad_summary_pdf', $article->id) }}" class="btn btn-success btn-sm">Summary PDF<i class="fas fa-download"></i></a>
                                            </td>
                                            
                                            <td>
                                                <!-- Разгъната секция за ревюта -->
                                                @foreach ($preparedReviews as $preparedReview)
                                                    @if (isset($review['message']))
                                                        <span>{{ $review['message'] }}</span>
                                                    @else
                                                        @if ($preparedReview['article_id'] == $article->id)
                                                            <div class="review">
                                                                <span>1.{{ $preparedReview['reviewer1_name'] }} -
                                                                    <strong>{{ $preparedReview['rating_1'] ?: '' }}</strong></span><br>
                                                                <span>2.{{ $preparedReview['reviewer2_name'] }} -
                                                                    <strong>{{ $preparedReview['rating_2'] ?: '' }}</strong></span><br>
                                                                <span>3.{{ $preparedReview['reviewer3_name'] }} -
                                                                    <strong>{{ $preparedReview['rating_3'] ?: '' }}</strong></span><br>
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
