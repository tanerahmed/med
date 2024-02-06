@extends('admin.dashboard')
@section('admin')

    <div class="page-content">
        <h4>Force add reviwer</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6"> <!-- Добавете класа col-md-6 за разпределение на половината екран -->
                <form action="{{ route('articles.update', $article->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Избор на рецензенти -->
                    <div class="form-group">
                        <label for="reviewer_id_1" class="form-label">Reviewer 1:</label>
                        <select name="reviewer_id_1" id="reviewer_id_1" class="form-select">
                            <option value="">Select Reviewer</option>
                            @foreach ($reviewers as $reviewer)
                                <option value="{{ $reviewer->id }}" @if ($review && $review->reviewer_id_1 == $reviewer->id) selected @endif>
                                    {{ $reviewer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="reviewer_id_2" class="form-label">Reviewer 2:</label>
                        <select name="reviewer_id_2" id="reviewer_id_2" class="form-select">
                            <option value="">Select Reviewer</option>
                            @foreach ($reviewers as $reviewer)
                                <option value="{{ $reviewer->id }}" @if ($review && $review->reviewer_id_2 == $reviewer->id) selected @endif>
                                    {{ $reviewer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="reviewer_id_3" class="form-label">Reviewer 3:</label>
                        <select name="reviewer_id_3" id="reviewer_id_3" class="form-select">
                            <option value="">Select Reviewer</option>
                            @foreach ($reviewers as $reviewer)
                                <option value="{{ $reviewer->id }}" @if ($review && $review->reviewer_id_3 == $reviewer->id) selected @endif>
                                    {{ $reviewer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Бутон за потвърждение -->
                    <button type="submit" class="btn btn-primary">Save Reviews</button>
                </form>
            </div>
        </div>


        <br />
        <br />
        <br />
        <br />
        <h4>Send email request to review</h4>
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('articles.sendEmailForReviewRequest', $article->id) }}" method="POST">
                    @csrf
                    <!-- Избор на рецензенти -->
                    <div class="form-group">
                        <label for="reviewer_id_1" class="form-label">Reviewer 1:</label>
                        <select name="reviewer_id_1" id="reviewer_id_1" class="form-select">
                            <option value="">Select Reviewer</option>
                            @foreach ($reviewers as $reviewer)
                                <option value="{{ $reviewer->id }}" @if ($review && $review->reviewer_id_1 == $reviewer->id) selected @endif>
                                    {{ $reviewer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="reviewer_id_2" class="form-label">Reviewer 2:</label>
                        <select name="reviewer_id_2" id="reviewer_id_2" class="form-select">
                            <option value="">Select Reviewer</option>
                            @foreach ($reviewers as $reviewer)
                                <option value="{{ $reviewer->id }}" @if ($review && $review->reviewer_id_2 == $reviewer->id) selected @endif>
                                    {{ $reviewer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="reviewer_id_3" class="form-label">Reviewer 3:</label>
                        <select name="reviewer_id_3" id="reviewer_id_3" class="form-select">
                            <option value="">Select Reviewer</option>
                            @foreach ($reviewers as $reviewer)
                                <option value="{{ $reviewer->id }}" @if ($review && $review->reviewer_id_3 == $reviewer->id) selected @endif>
                                    {{ $reviewer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Бутон за потвърждение -->
                    <button type="submit" class="btn btn-primary">Send Email</button>
                </form>
            </div>
            <div class="col-md-3">
                <h5>Invited reviewers:</h5>
                <ul>
                    @foreach ($invitedReviewers as $invitedReviewer)
                        <li>{{ $invitedReviewer->user->name }} 
                            @if ($invitedReviewer->rejected)
                            <span style="color: red"> - REJECTED</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>


@endsection
