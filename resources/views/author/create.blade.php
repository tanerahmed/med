<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
    <meta name="author" content="NobleUI">
    <meta name="keywords"
        content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <title>Admin Panel - HTML Bootstrap 5 Admin Dashboard Template</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    <!-- core:css !!!!!!!!!!!!!!!! asset -- MEAN Public/Assets folder !!!!!!!!!!!!!!!!!!!!!!!!!! -->
    <link rel="stylesheet" href="{{ asset('../assets/vendors/core/core.css') }}">
    <!-- endinject -->

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('../assets/vendors/flatpickr/flatpickr.min.css') }}">
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('../assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('../assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <!-- endinject -->

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('../assets/css/demo1/style.css') }}">
    <!-- End layout styles -->

    <link rel="shortcut icon" href="{{ asset('../assets/images/favicon.png') }} " />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
</head>

<body>
    <div class="main-wrapper">

        <!-- partial:partials/_sidebar.html -->
        @include('layouts.admin_sidebar')
        <!-- partial -->

        <div class="page-wrapper">

            <!-- partial:partials/_navbar.html -->
            @include('layouts.admin_header')
            <!-- partial -->
            <div class="page-content">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h4 class="mb-3 mb-md-0">Create Article</h4>
                    </div>
                </div>


                <div class="container">
                    <form action="{{ route('article.store') }}" method="POST" enctype="multipart/form-data"
                        id="articleForm">
                        @csrf
                        <div class="row">

                            <!-- !!!!!!!!!!!! Първа колона !!!!!!!!!!!! -->
                            <div class="col-md-6">
                                <!-- Choice type of article -->
                                <div class="mb-3">
                                    <label for="field1" class="form-label"><strong>Choice type of
                                            article:</strong></label>
                                    <select class="form-select" name="type" aria-label="Default select example">
                                        <option value="original article" selected>original article</option>
                                        <option value="review">review</option>
                                        <option value="letter to the editor">letter to the editor</option>
                                        <option value="case of the month/how do I do it">case of the month/how do I do
                                            it
                                        </option>
                                    </select>
                                </div>
                                <!-- Speciality -->
                                <div class="mb-3">
                                    <label for="specialty" class="form-label"><strong>Choice
                                            Speciality:</strong></label>
                                    <select class="form-select" id="specialty" name="specialty"
                                        aria-label="Default select example">
                                        <option selected>Select Speciality</option>
                                        <option value="Урология">Урология</option>
                                        <option value="УНГ">УНГ</option>

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
                                    <label for="title_pages" class="form-label"><strong>Upload Title Page:</strong>
                                        <i>(doc,
                                            docx,
                                            LaTeX doc)</i></label>
                                    <ul id="title_pages_selected_files" class="list-group mb-3"></ul>
                                    <input type="file" name="title_pages[]" multiple class="form-control"
                                        id="title_pages" onchange="validateTitlePageFileType(); ">
                                    <div class="text-danger" id="title_page_error"></div>
                                </div>

                                <!-- Manuscript -->
                                <div class="mb-3">
                                    <label for="manuscript" class="form-label"><strong>Upload Manuscript:</strong>
                                        <i>(doc, docx,
                                            LaTeX doc)</i></label>
                                    <ul id="manuscript_selected_files" class="list-group mb-3"></ul>
                                    <input type="file" name="manuscript[]" multiple class="form-control"
                                        id="manuscript" onchange="validateManuscriptFileType(); ">
                                    <div class="text-danger" id="manuscript_error"></div>
                                </div>

                                <!-- Figures -->
                                <div class="mb-3">
                                    <label for="figures" class="form-label"><strong>Upload Figures:</strong>
                                        <i>(jpg)</i></label>
                                    <ul id="figures_selected_files" class="list-group mb-3"></ul>
                                    <input type="file" name="figures[]" multiple class="form-control"
                                        id="figures" onchange="validateFiguresFileType(); ">
                                    <div class="text-danger" id="figures_error"></div>
                                </div>

                                <!-- Tables -->
                                <div class="mb-3">
                                    <label for="tables" class="form-label"><strong>Upload Tables:</strong> <i>(doc,
                                            docx)</i></label>
                                    <ul id="tables_selected_files" class="list-group mb-3"></ul>
                                    <input type="file" name="tables[]" multiple class="form-control"
                                        id="tables" onchange="validateTablesFileType(); ">
                                    <div class="text-danger" id="tables_error"></div>
                                </div>

                                <!-- Supplementary -->
                                <div class="mb-3">
                                    <label for="supplementary" class="form-label"><strong>Upload
                                            Supplementary:</strong>
                                        <i>(doc,
                                            docx, xls, xlsx, pdf, png, jpg)</i></label>
                                    <ul id="supplementary_selected_files" class="list-group mb-3"></ul>
                                    <input type="file" name="supplementary[]" multiple class="form-control"
                                        id="supplementary" onchange="validateSupplementaryFileType(); ">
                                    <div class="text-danger" id="supplementary_error"></div>
                                </div>

                                <!-- Cover Letter -->
                                <div class="mb-3">
                                    <label for="cover_letter" class="form-label"><strong>Upload Cover Letter:</strong>
                                        <i>(doc,
                                            docx, LaTeX doc)</i></label>
                                    <ul id="cover_letter_selected_files" class="list-group mb-3"></ul>
                                    <input type="file" name="cover_letter[]" multiple class="form-control"
                                        id="cover_letter" onchange="validateCoverLaterFileType(); ">
                                    <div class="text-danger" id="cover_letter_error"></div>
                                </div>


                                <!-- Keywords -->
                                <div class="mb-3">
                                    <label for="Keywords" class="form-label"><strong>Type Keywords: </strong>
                                        <i>(separate
                                            with a
                                            comma)</i></label>
                                    <input type="text" class="form-control" name="keywords" id="keywords"
                                        placeholder="Add Keywords" required>
                                </div>

                                <!-- Funding name -->
                                <div class="mb-3">
                                    <label for="funding_name" class="form-label"><strong>Type Funding name:
                                        </strong></label>
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
                                <button type="button" class="btn btn-primary" id="addAuthorButton">Add
                                    Author</button>
                            </div>

                            <div class="mb-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-success" id="submitBtn">Create Article</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                // Функция за добавяне на файлове към даден списък
                function addFilesToList(fileInputId, fileListId) {
                    const fileInput = document.getElementById(fileInputId);
                    const fileList = document.getElementById(fileListId);

                    fileInput.addEventListener('change', function(event) {
                        const files = event.target.files;
                        for (const file of files) {
                            const listItem = document.createElement('li');
                            listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                            listItem.innerHTML = `
                        <span>${file.name}</span>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeFile(this, '${fileListId}')">&times;</button>
                    `;
                            fileList.appendChild(listItem);
                        }
                    });
                }

                // Функция за премахване на файлове от даден списък
                function removeFile(button, listId) {
                    const listItem = button.parentElement;
                    const list = document.getElementById(listId);
                    list.removeChild(listItem);
                }

                // Добавяне на файлове към всички input полета
                addFilesToList('title_pages', 'title_pages_selected_files');
                addFilesToList('manuscript', 'manuscript_selected_files');
                addFilesToList('figures', 'figures_selected_files');
                addFilesToList('tables', 'tables_selected_files');
                addFilesToList('supplementary', 'supplementary_selected_files');
                addFilesToList('cover_letter', 'cover_letter_selected_files');
            </script>

            <!-- partial:partials/_footer.html -->
            @include('layouts.admin_footer')
            <!-- partial -->

        </div>
    </div>

    <!-- core:js -->
    <script src="{{ asset('../assets/vendors/core/core.js') }}"></script>
    <!-- endinject -->

    <!-- Plugin js for this page -->
    <script src="{{ asset('../assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('../assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <!-- End plugin js for this page -->

    <!-- inject:js -->
    <script src="{{ asset('../assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('../assets/js/template.js') }}"></script>
    <!-- endinject -->

    <!-- https://www.facebook.com/http.huy -->
    <script src="{{ asset('../assets/js/dashboard-dark.js') }}"></script>
    <!-- https://www.facebook.com/taner.ahmed -->

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="{{ asset('../assets/js/article_form_validation.js') }}"></script>
    <script src="{{ asset('../assets/js/dynamicFields.js') }}"></script>
    <script src="{{ asset('../assets/js/dynamicAddAuthors.js') }}"></script>


    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>


    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif

        // Вашият jQuery код
        $(document).ready(function() {
            // Инициализация на DataTables
            $('.table').DataTable();
        });
    </script>

</body>

</html>
