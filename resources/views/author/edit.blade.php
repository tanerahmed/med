@extends('admin.dashboard')
@section('admin')

    <div class="page-content">
        <h4>Edit Article Reviews</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('articles.update', $article->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Избор на рецензенти -->
            <div class="form-group">
                <label>Reviewer 1:
                    <select name="reviewer_id_1">
                        <option value="">Select Reviewer</option>
                        @foreach ($reviewers as $reviewer)
                            <option value="{{ $reviewer->id }}" @if ($review && $review->reviewer_id_1 == $reviewer->id) selected @endif>{{ $reviewer->name }}</option>
                        @endforeach
                    </select>
                </label>
                <br>
                <label>Reviewer 2:
                    <select name="reviewer_id_2">
                        <option value="">Select Reviewer</option>
                        @foreach ($reviewers as $reviewer)
                            <option value="{{ $reviewer->id }}" @if ($review && $review->reviewer_id_2 == $reviewer->id) selected @endif>{{ $reviewer->name }}</option>
                        @endforeach
                    </select>
                </label>
                <br>
                <label>Reviewer 3:
                    <select name="reviewer_id_3">
                        <option value="">Select Reviewer</option>
                        @foreach ($reviewers as $reviewer)
                            <option value="{{ $reviewer->id }}" @if ($review && $review->reviewer_id_3 == $reviewer->id) selected @endif>{{ $reviewer->name }}</option>
                        @endforeach
                    </select>
                </label>

            </div>

            <!-- Бутон за потвърждение -->
            <button type="submit" class="btn btn-primary">Save Reviews</button>
        </form>
    </div>

@endsection
