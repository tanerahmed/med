@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Article #{{ $article->id }} - {{ $article->title }} - {{ $article->type }}</h4>
            </div>
        </div>

        <div class="container">
            {{-- @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif --}}
            @if (session('errors'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach (session('errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('review.store') }}"  enctype="multipart/form-data">
                @csrf
                <input name="articleId" type="hidden" value="{{ $article->id }}">
                <div class="row">
                    <!-- !!!!!!!!!!!! Първа колона !!!!!!!!!!!! -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="question1" class="form-label">Question 1: Are you satisfied with our
                                service?</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="question1Yes" name="question1"
                                        value="yes">
                                    <label class="form-check-label" for="question1Yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="question1No" name="question1"
                                        value="no">
                                    <label class="form-check-label" for="question1No">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="question2" class="form-label">Question 2: Do you find the website
                                user-friendly?</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="question2Yes" name="question2"
                                        value="yes">
                                    <label class="form-check-label" for="question2Yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="question2No" name="question2"
                                        value="no">
                                    <label class="form-check-label" for="question2No">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="question3" class="form-label">Question 3: Would you recommend us to your
                                friends?</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="question3Yes" name="question3"
                                        value="yes">
                                    <label class="form-check-label" for="question3Yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="question3No" name="question3"
                                        value="no">
                                    <label class="form-check-label" for="question3No">No</label>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="mb-3">
                            <label for="zip_file" class="form-label"><strong>Upload ZIP Files: </strong><i>(zip)</i></label>
                            <input type="file" name="zip_file[]" multiple class="form-control" id="zip_file"
                                onchange="validateZIPFileType()">
                            <div class="text-danger" id="zip_file_error"></div>
                        </div> --}}
                        <div class="mb-3">
                            <label for="zip_file" class="form-label"><strong>Upload ZIP File: </strong><i>(zip)</i></label>
                            <input type="file" name="zip_file[]" class="form-control" id="zip_file"
                                onchange="validateZIPFileType()">
                            <div class="text-danger" id="zip_file_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="field1" class="form-label"><strong>Select Rating:</strong></label>
                            <select class="form-select" name="rating" aria-label="Default select example">
                                <option value="" ></option>
                                <option value="accepted">Accept</option>
                                <option value="accepted with revision">Accepted with revision</option>
                                <option value="declined">Declined</option>
                            </select>
                        </div>

                        {{-- Първа колона КРАЙ --}}
                    </div>

                    <!-- !!!!!!!!!!!! Втора колона !!!!!!!!!!!! -->
                    <div class="col-md-6">

                        <div class="mb-3">
                            <label for="title_pages" class="form-label"><strong>Comment Title Page:</strong></label>
                            <textarea class="form-control" id="title_pages" name="title_pages" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="manuscript" class="form-label"><strong>Comment Manuscript:</strong></label>
                            <textarea class="form-control" id="manuscript" name="manuscript" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="figures" class="form-label"><strong>Comment Figures:</strong></label>
                            <textarea class="form-control" id="figures" name="figures" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="tables" class="form-label"><strong>Comment Tables:</strong></label>
                            <textarea class="form-control" id="tables" name="tables" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="supplementary" class="form-label"><strong>Comment Supplementary:</strong></label>
                            <textarea class="form-control" id="supplementary" name="supplementary" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="cover_letter" class="form-label"><strong>Comment Cover Letter:</strong></label>
                            <textarea class="form-control" id="cover_letter" name="cover_letter" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="keywords" class="form-label"><strong>Comment Keywords:</strong></label>
                            <textarea class="form-control" id="keywords" name="keywords" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label"><strong>Comment Title:</strong></label>
                            <textarea class="form-control" id="title" name="title" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="abstract" class="form-label"><strong>Comment Abstract:</strong></label>
                            <textarea class="form-control" id="abstract" name="abstract" rows="3"></textarea>
                        </div>
                        {{-- Втора колона КРАЙ --}}
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </div>
            </form>
        </div>
    </div>














    {{-- <div class="step" id="step1">
<h2>Titpe Page</h2>
<!-- Входни полета и елементи за стъпка 1 -->

!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
<img src="{{  asset("storage/".  $article->figures[0]->file_path) }}" alt="" />
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!


<!-- title page -->
<div class="mb-3">
<label for="title" class="form-label"><strong>Comments:</strong></label>
<textarea class="form-control" id="title_page" name="title_page" rows="8"></textarea>
</div>

<button type="button" class="btn btn-light" onclick="nextStep(2)">Next</button>
</div>

<div class="step" id="step2">
<h2>Step 2</h2>
<!-- Входни полета и елементи за стъпка 2 -->
<button type="button" class="btn btn-dark" onclick="prevStep(1)">Previous</button>
<button type="button" class="btn btn-light" onclick="nextStep(3)">Next</button>
</div>


<div class="step" id="step3">
<h2>Step 3</h2>
<!-- Входни полета и елементи за стъпка 2 -->
<button type="button" class="btn btn-dark" onclick="prevStep(2)">Previous</button>
<button type="button" class="btn btn-light" onclick="nextStep(4)">Next</button>
</div>

<div class="step" id="step4">
<h2>Step 4</h2>
<!-- Входни полета и елементи за стъпка 2 -->
<button type="button" class="btn btn-dark" onclick="prevStep(3)">Previous</button>
<button type="button" class="btn btn-light" onclick="nextStep(5)">Next</button>
</div>

<div class="step" id="step5">
<h2>Step 5</h2>
<!-- Входни полета и елементи за стъпка 2 -->
<button type="button" class="btn btn-dark" onclick="prevStep(4)">Previous</button>
<button type="button" class="btn btn-light" onclick="nextStep(6)">Next</button>
</div>

<div class="step" id="step6">
<h2>Step 6</h2>
<!-- Входни полета и елементи за стъпка 2 -->
<button type="button" class="btn btn-dark" onclick="prevStep(5)">Previous</button>
<button type="button" class="btn btn-light" onclick="nextStep(7)">Next</button>
</div>

<div class="step" id="step7">
<h2>Step 7</h2>
<!-- Входни полета и елементи за стъпка 2 -->
<button type="button" class="btn btn-dark" onclick="prevStep(6)">Previous</button>
<button type="button" class="btn btn-light" onclick="nextStep(8)">Next</button>
</div>

<div class="step" id="step8">
<h2>Step 8</h2>
<!-- Входни полета и елементи за стъпка 2 -->
<button type="button" class="btn btn-dark" onclick="prevStep(7)">Previous</button>
<button type="button" class="btn btn-light" onclick="nextStep(9)">Next</button>
</div>

<div class="step" id="step9">
<h2>Step 9</h2>
<!-- Входни полета и елементи за стъпка 2 -->
<button type="button" class="btn btn-dark" onclick="prevStep(8)">Previous</button>
<button type="button" class="btn btn-light" onclick="nextStep(10)">Next</button>
</div>

<div class="step" id="step10">
<h2>Step 10</h2>
<!-- Входни полета и елементи за стъпка 3 -->
<button type="button" class="btn btn-dark" onclick="prevStep(9)">Previous</button>
<button class="btn btn-primary" onclick="submitForm()">Submit</button>
</div> --}}




    {{-- <script>
                var currentStep = 1;

                function showStep(step) {
                    $('.step').hide();
                    $('#step' + step).show();
                    currentStep = step;
                }

                function nextStep(step) {
                    showStep(step);
                }

                function prevStep(step) {
                    showStep(step);
                }

                function submitForm() {
                    // Изпратете формата с AJAX или изпълнете друга логика
                }

                $(document).ready(function() {
                    showStep(1);
                });
            </script> --}}
@endsection
