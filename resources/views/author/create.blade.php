@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Create Article</h4>
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

            <form action="{{ route('article.store') }}" method="POST" enctype="multipart/form-data" id="articleForm" >
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
                                <option value="Anesthesiology & Intensive care">Anesthesiology & Intensive care</option>
                                <option value="Clinical anatomy">Clinical anatomy</option>
                                <option value="Clinical laboratory sciences">Clinical laboratory sciences</option>
                                <option value="Clinical biochemistry">Clinical biochemistry</option>
                                <option value="Cytogenetics">Cytogenetics</option>
                                <option value="Cytohematology">Cytohematology</option>
                                <option value="Cytology">Cytology</option>
                                <option value="Hemostaseology">Hemostaseology</option>
                                <option value="Histology">Histology</option>
                                <option value="Clinical immunology">Clinical immunology</option>
                                <option value="Clinical microbiology">Clinical microbiology</option>
                                <option value="Molecular genetics">Molecular genetics</option>
                                <option value="Clinical genetics">Clinical genetics</option>
                                <option value="Parasitology">Parasitology</option>
                                <option value="Clinical physiology">Clinical physiology</option>
                                <option value="Dentistry">Dentistry</option>
                                <option value="Dental surgery">Dental surgery</option>
                                <option value="Endodontics">Endodontics</option>
                                <option value="Orthodontics">Orthodontics</option>
                                <option value="Oral and maxillofacial surgery">Oral and maxillofacial surgery</option>
                                <option value="Dermatology">Dermatology</option>
                                <option value="Emergency medicine">Emergency medicine</option>
                                <option value="Health informatics/Clinical informatics">Health informatics/Clinical
                                    informatics</option>
                                <option value="Nursing">Nursing</option>
                                <option value="Nutrition and dietetics">Nutrition and dietetics</option>
                                <option value="Physiotherapy">Physiotherapy</option>
                                <option value="Speech and language pathology">Speech and language pathology</option>
                                <option value="Internal medicine">Internal medicine</option>
                                <option value="Preventive medicine">Preventive medicine</option>
                                <option value="Cardiology">Cardiology</option>
                                <option value="Cardiac electrophysiology">Cardiac electrophysiology</option>
                                <option value="Pulmonology">Pulmonology</option>
                                <option value="Medical toxicology">Medical toxicology</option>
                                <option value="Endocrinology">Endocrinology</option>
                                <option value="Gastroenterology">Gastroenterology</option>
                                <option value="Hepatology">Hepatology</option>
                                <option value="Oncology">Oncology</option>
                                <option value="Radiation therapy">Radiation therapy</option>
                                <option value="Geriatrics">Geriatrics</option>
                                <option value="Gynaecology">Gynaecology</option>
                                <option value="Hematology">Hematology</option>
                                <option value="Infectious disease">Infectious disease</option>
                                <option value="Nephrology">Nephrology</option>
                                <option value="Neurology">Neurology</option>
                                <option value="Neurosurgery">Neurosurgery</option>
                                <option value="Obstetrics">Obstetrics</option>
                                <option value="Ophthalmology">Ophthalmology</option>
                                <option value="Neuro-ophthalmology">Neuro-ophthalmology</option>
                                <option value="Orthopedic surgery">Orthopedic surgery</option>
                                <option value="Otorhinolaryngology">Otorhinolaryngology</option>
                                <option value="Pathology">Pathology</option>
                                <option value="Pediatrics">Pediatrics</option>
                                <option value="Pharmaceutical sciences">Pharmaceutical sciences</option>
                                <option value="Clinical pharmacology">Clinical pharmacology</option>
                                <option value="Physical therapy">Physical therapy</option>
                                <option value="General practice">General practice</option>
                                <option value="Psychiatry">Psychiatry</option>
                                <option value="Public health">Public health</option>
                                <option value="Radiology">Radiology</option>
                                <option value="Rehabilitation medicine">Rehabilitation medicine</option>
                                <option value="Respiratory medicine">Respiratory medicine</option>
                                <option value="Pulmonology">Pulmonology</option>
                                <option value="Sleep medicine">Sleep medicine</option>
                                <option value="Respiratory therapy">Respiratory therapy</option>
                                <option value="Rheumatology">Rheumatology</option>
                                <option value="Sports medicine">Sports medicine</option>
                                <option value="Surgery">Surgery</option>
                                <option value="Pediatric surgery">Pediatric surgery</option>
                                <option value="Colorectal surgery">Colorectal surgery</option>
                                <option value="Transplant surgery">Transplant surgery</option>
                                <option value="Trauma surgery">Trauma surgery</option>
                                <option value="Hepatobiliary and pancreatic surgery">Hepatobiliary and pancreatic surgery
                                </option>
                                <option value="Bariatric surgery">Bariatric surgery</option>
                                <option value="Cardiothoracic surgery">Cardiothoracic surgery</option>
                                <option value="Neurosurgery">Neurosurgery</option>
                                <option value="Plastic surgery">Plastic surgery</option>
                                <option value="Traumatology">Traumatology</option>
                                <option value="Urology">Urology</option>
                                <option value="Andrology">Andrology</option>
                                <option value="Epidemiology">Epidemiology</option>
                                <option value="Nuclear medicine">Nuclear medicine</option>
                                <option value="Allergology">Allergology</option>
                                <option value="Forensic medicine & deontology">Forensic medicine & deontology</option>
                                <option value="Vascular surgery">Vascular surgery</option>
                                <option value="Cardiovascular surgery">Cardiovascular surgery</option>
                                <option value="Interventional cardiology">Interventional cardiology</option>
                                <option value="Interventional neuroradiology">Interventional neuroradiology</option>
                            </select>
                        </div>
                        <!-- Scientific Area -->
                        <div class="mb-3">
                            <label for="scientific_area" class="form-label"><strong>Choice Scientific
                                    Area:</strong></label>
                            <select class="form-select" id="scientific_area" name="scientific_area"
                                aria-label="Default select example">
                            </select>
                        </div>
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label"><strong>Type Title:</strong></label>
                            <textarea class="form-control" id="title" name="title" rows="8" required></textarea>
                        </div>
                        <!-- Abstract -->
                        <div class="mb-3">
                            <label for="abstract" class="form-label"><strong>Type Abstract:</strong></label>
                            <textarea class="form-control" id="abstract" name="abstract" rows="8" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-check-label" for="declarations">
                                <input class="form-check-input" type="checkbox" id="declarations" required>
                                I hereby declare that...
                            </label>
                        </div>
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
                            <label for="figures" class="form-label"><strong>Upload Figures: </strong> <i>(jpg)</i> <a
                                    href="https://www.iloveimg.com/convert-to-jpg/tiff-to-jpg" target="_blank"><span
                                        style="color: red;" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Please click and visit online convertet to convert Tiff file to JPG">tiff
                                        ?</span></a>
                            </label>
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
                                    docx, xls, xlsx, pdf, png, jpg) </i><a
                                    href="https://www.iloveimg.com/convert-to-jpg/tiff-to-jpg" target="_blank"><span
                                        style="color: red;" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Please click and visit online convertet to convert Tiff file to JPG">tiff
                                        ?</span></a>
                            </label>
                            <div id="supplementary_selected_files"></div>
                            <input type="file" name="supplementary[]" multiple class="form-control"
                                id="supplementary"
                                onchange="validateSupplementaryFileType(); displaySelectedFiles('supplementary')">
                            <div class="text-danger" id="supplementary_error"></div>
                        </div>


                        <!-- Cover Later -->
                        <div class="mb-3">
                            <label for="cover_letter" class="form-label"><strong>Upload Cover Later:</strong><i>(doc, docx,
                                LaTeX doc)</i></label>
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
                                placeholder="Add Keywords" required>
                        </div>

                        <!-- Funding name -->
                        <div class="mb-3">
                            <label for="funding_name" class="form-label"><strong>Type Funding name: </strong></label>
                            <input type="text" class="form-control" name="funding_name" id="funding_name"
                                placeholder="Add Funding name (Optional)">
                        </div>

                        <!-- Grand ID -->
                        <div class="mb-3">
                            <label for="grant_id" class="form-label"><strong>Type Grand ID: </strong></label>
                            <input type="text" class="form-control" name="grant_id" id="grant_id"
                                placeholder="Add Grand ID (Optional)">
                        </div>
                    </div>
                    <hr>
                    <div class="col-md-12">
                        <!-- Контейнер за полетата на авторите -->
                        <div id="authorsContainer" class="row g-3"></div>
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" id="addAuthorButton">Add Author</button>
                    </div>

                    <div class="mb-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success" id="submitBtn">Create Article</button>
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

    // document.getElementById('articleForm').addEventListener('submit', function() {
    //     // Деактивиране на бутона за изпращане
    //     document.getElementById('submitBtn').disabled = true;
    // });





</script>
