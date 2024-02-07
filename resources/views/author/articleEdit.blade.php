@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Edit Article</h4>
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

            <form action="{{ route('articles.articleUpdate', $article->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')   

                <div class="row">
                    <!-- !!!!!!!!!!!! Първа колона !!!!!!!!!!!! -->
                    <div class="col-md-6">
                        <!-- Choice type of article -->
                        <div class="mb-3">
                            <label for="funding_name" class="form-label"><strong>Type: </strong></label>
                            <input type="text" class="form-control" name="" id="" disabled value="{{$article->type}}">
                        </div>
                        <!-- Speciality -->
                        <div class="mb-3">
                            <label for="funding_name" class="form-label"><strong>Speciality: </strong></label>
                            <input type="text" class="form-control" name="specialty" id="specialty" disabled value="{{$article->specialty}}">
                        </div>
                        <!-- Scientific Area -->
                        <div class="mb-3">
                            <label for="scientific_area" class="form-label"><strong>Scientific Area:</strong></label>
                            <input type="text" class="form-control" name="scientific_area" id="scientific_area" disabled value="{{$article->scientific_area}}">
                        </div>
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label"><strong>Type Title:</strong></label>
                            <textarea class="form-control" id="title" name="title" rows="8">{{$article->title}}</textarea>
                        </div>
                        <!-- Abstract -->
                        <div class="mb-3">
                            <label for="abstract" class="form-label"><strong>Type Abstract:</strong></label>
                            <textarea class="form-control" id="abstract" name="abstract" rows="8">{{$article->title}}</textarea>
                        </div>
                        {{-- <div class="mb-3">
                            <label class="form-check-label" for="declarations">
                                <input class="form-check-input" type="checkbox" id="declarations" required>
                                I hereby declare that...
                            </label>
                        </div> --}}
                    </div>

                    <!-- !!!!!!!!!!!! Втора колона !!!!!!!!!!!! -->
                    <div class="col-md-6">
                        <!-- Upload Title Page -->
                        <div class="mb-3">
                            <label for="title_pages" class="form-label"><strong>Upload Title Page: </strong><i>(doc, docx,
                                    LaTeX doc)</i></label>
                            <div id="title_pages_selected_files"></div>
                            <input type="file" name="title_pages[]" multiple class="form-control" id="title_pages"
                                onchange="validateTitlePageFileType(); displaySelectedFiles('title_pages')">
                            <div class="text-danger" id="title_page_error"></div>
                        </div>


                        <!-- Manuscript -->
                        <div class="mb-3">
                            <label for="manuscript" class="form-label"><strong>Upload Manuscript: </strong><i>(doc, docx,
                                    LaTeX doc)</i></label>
                            <div id="manuscript_selected_files"></div>
                            <input type="file" name="manuscript[]" multiple class="form-control" id="manuscript"
                                onchange="validateManuscriptFileType(); displaySelectedFiles('manuscript')">
                            <div class="text-danger" id="manuscript_error"></div>
                        </div>


                        <!-- Figures -->
                        <div class="mb-3">
                            <label for="figures" class="form-label"><strong>Upload Figures: </strong> <i>(jpg,
                                    tiff)</i></label>
                            <div id="figures_selected_files"></div>
                            <input type="file" name="figures[]" multiple class="form-control" id="figures"
                                onchange="validateFiguresFileType(); displaySelectedFiles('figures')">
                            <div class="text-danger" id="figures_error"></div>
                        </div>


                        <!-- Tables -->
                        <div class="mb-3">
                            <label for="tables" class="form-label"><strong>Upload Tables: </strong><i>(doc,
                                    docx)</i></label>
                            <div id="tables_selected_files"></div>
                            <input type="file" name="tables[]" multiple class="form-control" id="tables"
                                onchange="validateTablesFileType(); displaySelectedFiles('tables')">
                            <div class="text-danger" id="tables_error"></div>
                        </div>


                        <!-- Supplementary -->
                        <div class="mb-3">
                            <label for="supplementary" class="form-label"><strong>Upload Supplementary: </strong><i>(doc,
                                    docx, xls, xlsx, pdf, jpg, tiff)</i></label>
                            <div id="supplementary_selected_files"></div>
                            <input type="file" name="supplementary[]" multiple class="form-control"
                                id="supplementary"
                                onchange="validateSupplementaryFileType(); displaySelectedFiles('supplementary')">
                            <div class="text-danger" id="supplementary_error"></div>
                        </div>


                        <!-- Cover Later -->
                        <div class="mb-3">
                            <label for="cover_letter" class="form-label"><strong>Upload Cover Later:</strong></label>
                            <div id="cover_letter_selected_files"></div>
                            <input type="file" name="cover_letter[]" multiple class="form-control" id="cover_letter"
                                onchange="validateCoverLaterFileType(); displaySelectedFiles('cover_letter')">
                            <div class="text-danger" id="cover_letter_error"></div>
                        </div>


                        <!-- Keywords -->
                        <div class="mb-3">
                            <label for="Keywords" class="form-label"><strong>Type Keywords: </strong> <i>(separate with a
                                    comma)</i></label>
                            <input type="text" class="form-control" name="keywords" id="keywords"
                                placeholder="Add Keywords" value="{{$article->keywords}}">
                        </div>

                        <!-- Funding name -->
                        <div class="mb-3">
                            <label for="funding_name" class="form-label"><strong>Type Funding name: </strong></label>
                            <input type="text" class="form-control" name="funding_name" id="funding_name"
                                placeholder="Add Funding name (Optional)" value="{{$article->funding_name}}">
                        </div>

                        <!-- Grand ID -->
                        <div class="mb-3">
                            <label for="grant_id" class="form-label"><strong>Type Grand ID: </strong></label>
                            <input type="text" class="form-control" name="grant_id" id="grant_id"
                                placeholder="Add Grand ID (Optional)" value="{{$article->grant_id}}">
                        </div>
                    </div>
                    <hr>
                    {{-- <div class="col-md-12">
                        <!-- Контейнер за полетата на авторите -->
                        <div id="authorsContainer" class="row g-3"></div>
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" id="addAuthorButton">Add Author</button>
                    </div> --}}

                    <div class="mb-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning">Edit Article</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    function displaySelectedFiles(inputId) {
        var input = document.getElementById(inputId);
        var fileList = input.files;
        var fileNames = "";
        for (var i = 0; i < fileList.length; i++) {
            fileNames += "<span style='font-weight: bold; font-style: italic;'>" + fileList[i].name + "</span>, ";
        }
        fileNames = fileNames.slice(0, -2); // Изтриване на последната запетая и интервал
        var selectedFilesDiv = document.getElementById(inputId + '_selected_files');
        selectedFilesDiv.innerHTML = fileNames;
    }
</script>
