@extends('admin.dashboard')
@section('admin')


<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Articles</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 col-xl-8 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    @if (Auth::check() &&  Auth::user()->role === 'admin')
                                    <th class="pt-0">User</th>
                                    @endif
                                    <th class="pt-0">Type</th>
                                    <th class="pt-0">Specialty</th>
                                    <th class="pt-0">Scientific area</th>
                                    <th class="pt-0">Status</th>
                                    <th class="pt-0">Date</th>
                                    <th class="pt-0">Review</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $review)
                                    <tr>
                                        @if (Auth::check() &&  Auth::user()->role === 'admin')
                                        <td>{{Auth::user()->name}} </td>
                                        @endif
                                        <td>{{ $review->article->type }}</td>
                                        <td>{{ $review->article->specialty }}</td>
                                        <td>{{ $review->article->scientific_area }}</td>
                                        <td><span class="badge bg-{{ $review->status_color }}">{{ $review->status_text }}</span></td>
                                        <td>{{ $review->article->updated_at }}</td>
                                        <td>
                                            <button>Review</button>
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