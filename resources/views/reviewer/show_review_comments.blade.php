@extends('admin.dashboard')
@section('admin')

<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Article: "{{ $review->article->title }}" reviewed by {{ $review->user->name }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-xl-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Review Questions</h5>
                    <div class="review-section mb-4">
                        <div class="p-3 bg-light border rounded">
                            {!! $review->review_questions !!}
                        </div>
                    </div>

                    <h5 class="card-title">Review Comments</h5>
                    <div class="review-section">
                        <div class="p-3 bg-light border rounded">
                            {!! $review->review_comments !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .review-section h5 {
        font-weight: bold;
    }

    .review-section .p-3 {
        background-color: #f8f9fa;
    }
</style>

@endsection
