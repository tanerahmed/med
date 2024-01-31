@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">title: {{ $article->title }}</h4>
                <h5 class="mb-3 mb-md-0">type: {{ $article->type }}</h5>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-xl-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('review.store') }}">
                            @csrf
                            <div class="step" id="step1">
                                <h2>Titpe Page</h2>
                                <!-- Входни полета и елементи за стъпка 1 -->
                                <img src="{{  asset("storage/".  $article->figures[0]->file_path) }}" alt="" />





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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script>
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
    </script>
@endsection
