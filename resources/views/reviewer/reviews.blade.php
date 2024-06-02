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
                                    @if (Auth::check() &&  Auth::user()->role === 'admin')
                                    <th class="pt-0">User</th>
                                    @endif
                                    <th class="pt-0">#ID</th>
                                    <th class="pt-0">Type</th>
                                    <th class="pt-0">Specialty</th>
                                    <th class="pt-0">Scientific area</th>
                                    <th class="pt-0">Status</th>
                                    <th class="pt-0">Date</th>
                                    <th class="pt-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $review)
                                    <tr>
                                        @if (Auth::check() &&  Auth::user()->role === 'admin')
                                        <td>{{Auth::user()->name}} </td>
                                        @endif
                                        <td>{{ $review->article->id }}</td>
                                        <td>{{ $review->article->type }}</td>
                                        <td>{{ $review->article->specialty }}</td>
                                        <td>{{ $review->article->scientific_area }}</td>
                                        <td><span class="badge bg-{{ $review->status_color }}">{{ $review->status_text }}</span></td>
                                        <td>{{ $review->article->created_at }}</td>
                                        <td>
                                            <a href="{{ route('review.downolad_files', $review->article->id) }}"><button type="button" class="btn btn-warning btn-sm">Dowload files</button></a>
                                            <a href="{{ route('review.summary_pdf', $review->article->id) }}"><button type="button" class="btn btn-success btn-sm">Summary PDF files</button></a>
                                            
                                            @if ( $review->status_text !== 'Declined')
                                            <a href="{{ route('review', $review->article->id) }}"><button type="button" class="btn btn-primary btn-sm">Review</button></a>
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