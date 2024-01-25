@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Create Article</h4>
            </div>
        </div>

        <div class="container">
            <form action="{{ route('article.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <!-- !!!!!!!!!!!! Първа колона !!!!!!!!!!!! -->
                    <div class="col-md-6">

                        <!-- Choice type of article -->
                        <div class="mb-3">
                            <label for="field1" class="form-label"><strong>Choice type of article:</strong></label>
                            <select class="form-select" name="type" aria-label="Default select example">
                                <option value="original article" selected>original article</option>
                                <option value="review">review</option>
                                <option value="letter to the editor">letter to the editor</option>
                                <option value="case of the month/how do I do it">case of the month/how do I do it</option>
                            </select>
                        </div>

                        <!-- Speciality -->
                        <div class="mb-3">
                            <label for="specialty" class="form-label"><strong>Choice Speciality:</strong></label>
                            <select class="form-select" id="specialty" name="specialty" aria-label="Default select example">
                                <option selected>Select Speciality</option>
                                <option value="Урология">Урология</option>
                                <option value="УНГ">УНГ</option>
                            </select>
                        </div>

                        <!-- Scientific Area -->
                        <div class="mb-3">
                            <label for="scientific_area" class="form-label"><strong>Choice Scientific Area:</strong></label>
                            <select class="form-select" id="scientific_area" name="scientific_area"
                                aria-label="Default select example">

                            </select>
                        </div>

                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label"><strong>Type Title:</strong></label>
                            <textarea class="form-control" id="title" name="title" rows="3" required></textarea>
                        </div>

                        <!-- Abstract -->
                        <div class="mb-3">
                            <label for="abstract" class="form-label"><strong>Type Abstract:</strong></label>
                            <textarea class="form-control" id="abstract" name="abstract" rows="3" required></textarea>
                        </div>

                        <!-- Keywords -->
                        <div class="mb-3">
                            <label for="Keywords" class="form-label">Type Keywords</label>
                            <input type="text" class="form-control" name="keywords" id="keywords"
                                placeholder="Add Keywords" required>
                        </div>

                        <!-- Funding name -->
                        <div class="mb-3">
                            <label for="funding_name" class="form-label">Type Funding name</label>
                            <input type="text" class="form-control" name="funding_name" id="funding_name"
                                placeholder="Add Funding name (Optional)">
                        </div>

                        <!-- Grand ID -->
                        <div class="mb-3">
                            <label for="grant_id" class="form-label">Type Grand ID</label>
                            <input type="text" class="form-control" name="grant_id" id="grant_id"
                                placeholder="Add Grand ID (Optional)">
                        </div>
                    </div>



                    <!-- !!!!!!!!!!!! Втора колона !!!!!!!!!!!! -->
                    <div class="col-md-6">
                        <!-- Upload Title Page -->
                        <div class="mb-3">
                            <label for="title_pages" class="form-label"><strong>Upload Title Page:</strong></label>
                            <input type="file" name="title_pages[]" multiple class="form-control" id="title_pages"
                                onchange="validateTitlePageFileType()">
                            <div class="text-danger" id="title_page_error"></div>
                        </div>
                        <!-- Manuscript -->
                        <div class="mb-3">
                            <label for="manuscript" class="form-label"><strong>Upload Manuscript:</strong></label>
                            <input type="file" name="manuscript[]" multiple class="form-control" id="manuscript"
                                onchange="validateManuscriptFileType()">
                            <div class="text-danger" id="manuscript_error"></div>
                        </div>
                        <!-- Figures -->
                        <div class="mb-3">
                            <label for="figures" class="form-label"><strong>Upload Figures:</strong></label>
                            <input type="file" name="figures[]" multiple class="form-control" id="figures"
                                onchange="validateFiguresFileType()">
                            <div class="text-danger" id="figures_error"></div>
                        </div>
                        <!-- Tables -->
                        <div class="mb-3">
                            <label for="tables" class="form-label"><strong>Upload Tables:</strong></label>
                            <input type="file" name="tables[]" multiple class="form-control" id="tables"
                                onchange="validateTablesFileType()">
                            <div class="text-danger" id="tables_error"></div>
                        </div>
                        <!-- Supplementary -->
                        <div class="mb-3">
                            <label for="supplementary" class="form-label"><strong>Upload Supplementary:</strong></label>
                            <input type="file" name="supplementary[]" multiple class="form-control"
                                id="supplementary" onchange="validateSupplementaryFileType()">
                            <div class="text-danger" id="supplementary_error"></div>
                        </div>
                        <!-- Cover Later -->
                        <div class="mb-3">
                            <label for="cover_letter" class="form-label"><strong>Upload Cover Later:</strong></label>
                            <input type="file" name="cover_letter[]" multiple class="form-control" id="cover_letter"
                                onchange="validateCoverLaterFileType()">
                            <div class="text-danger" id="cover_letter_error"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-md-6">
                        <!-- Контейнер за полетата на авторите -->
                        <div id="authorsContainer" class="row g-3"></div>
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" id="addAuthorButton">Add Author</button>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Create Article</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
   
</script>
