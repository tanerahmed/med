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
    <style>
      /* * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
         }

         .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
            width: 100%;
            min-height: 100vh;
            background: #5691d5;
            background: linear-gradient(282deg, #009dff 0%, #54bddf);
         } */

      .box {
         max-width: 500px;
         background: #F9FAFB;
         padding: 12px;
         width: 100%;
         border-radius: 4px;
         border-bottom: 2px solid #6583FF;
      }

      .upload-area-title {
         font-size: 16px;
         text-align: center;
         margin-bottom: 8px;
         font-weight: 600;
      }

      .upload-area-title i {
         font-size: 14px;
         font-weight: normal;
      }

      .uploadLabel {
         width: 100%;
         min-height: 100px;
         background: #6583FF0d;
         display: flex;
         flex-direction: column;
         justify-content: center;
         align-items: center;
         border: 1px dashed #6583FF82;
         cursor: pointer;
      }

      .uploadLabel span {
         font-size: 40px;
         color: #6583FF;
      }

      .uploadLabel p {
         color: #6583FF;
         font-weight: 700;
         /* font-family: cursive; */
      }

      .uploaded {
         margin: 8px 0;
         font-size: 14px;
         color: #a5a5a5;
      }

      .showfilebox {
         display: flex;
         align-items: center;
         justify-content: space-between;
         margin: 4px 0;
         padding: 2px 8px;
         box-shadow: #0000000d 0px 0px 0px 1px, #d1d5db3d 0px 0px 0px 1px inset;
      }

      .showfilebox .left {
         display: flex;
         align-items: center;
         flex-wrap: wrap;
         gap: 10px;
      }

      .filetype {
         background: #6583FF;
         color: #fff;
         padding: 2px 8px;
         font-size: 14px;
         text-transform: capitalize;
         font-weight: 700;
         border-radius: 3px;
      }

      .left h3 {
         /* font-weight: 600; */
         font-size: 14px;
         color: #292f42;
         margin: 0;
      }

      .right span {
         background: #6583FF;
         color: #fff;
         width: 20px;
         height: 20px;
         font-size: 20px;
         line-height: 20px;
         display: inline-block;
         text-align: center;
         font-weight: 700;
         cursor: pointer;
         border-radius: 50%;
      }
   </style>
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
                        @if (Auth::user()->role === 'author' || Auth::user()->role === 'reviewer')
                            <!-- Choice type of article -->
                            <div class="mb-3">
                                <label for="funding_name" class="form-label"><strong>Type: </strong></label>

                                <select class="form-select"  id="article_type" name="type" aria-label="Default select example">
                                    <option value="{{ $article->type }}" selected>{{ $article->type }}</option>
                                    <option value="review">review</option>
                                    <option value="letter to the editor">letter to the editor</option>
                                    <option value="case of the month/how do I do it">case of the month/how do I do it
                                    </option>
                                </select>

                            </div>
                            <!-- Speciality -->
                            <div class="mb-3">                                    
                                <label for="specialty" class="form-label"><strong>Choice Speciality:</strong></label>
                                <select class="form-select" id="specialty" name="specialty"
                                    aria-label="Default select example">
                                    <option selected  value="{{ $article->specialty }}">{{ $article->specialty }}</option>
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
                                    <option value="Hepatobiliary and pancreatic surgery">Hepatobiliary and pancreatic
                                        surgery
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
                                <option selected  value="{{ $article->scientific_area }}">{{ $article->scientific_area }}</option>
                            </select>
                            </div>
                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label"><strong>Type Title:</strong></label>
                                <textarea class="form-control" id="title" name="title" rows="8">{{ $article->title }}</textarea>
                            </div>
                            <!-- Abstract -->
                            <div class="mb-3">
                                <label for="abstract" class="form-label"><strong>Type Abstract:</strong></label>
                                <textarea class="form-control" id="abstract" name="abstract" rows="8">{{ $article->abstract }}</textarea>
                            </div>
                            <!-- Keywords -->
                            <div class="mb-3">
                                <label for="Keywords" class="form-label"><strong>Type Keywords: </strong> <i>(separate
                                        with a
                                        comma)</i></label>
                                <input type="text" class="form-control" name="keywords" id="keywords"
                                    placeholder="Add Keywords" value="{{ $article->keywords }}">
                            </div>

                            <!-- Funding name -->
                            <div class="mb-3">
                                <label for="funding_name" class="form-label"><strong>Type Funding name: </strong></label>
                                <input type="text" class="form-control" name="funding_name" id="funding_name"
                                    placeholder="Add Funding name (Optional)" value="{{ $article->funding_name }}">
                            </div>

                            <!-- Grand ID -->
                            <div class="mb-3">
                                <label for="grant_id" class="form-label"><strong>Type Grand ID: </strong></label>
                                <input type="text" class="form-control" name="grant_id" id="grant_id"
                                    placeholder="Add Grand ID (Optional)" value="{{ $article->grant_id }}">
                            </div>
                        @elseif (Auth::user()->role === 'admin' && $article->status === 'accepted')
                        @endif
                        {{-- <div class="mb-3">
                            <label class="form-check-label" for="declarations">
                                <input class="form-check-input" type="checkbox" id="declarations" required>
                                I hereby declare that...
                            </label>
                        </div> --}}
                    </div>

                    <!-- !!!!!!!!!!!! Втора колона !!!!!!!!!!!! -->
                    <div class="col-md-6">

                        @if (Auth::user()->role === 'author' || Auth::user()->role === 'reviewer')
                           <!-- Upload Title Page -->
<div class="mb-3">
    @foreach ($fileNames['titlePage'] as $fileName)
    <p style="color:burlywood">{{ $fileName }}</p>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" name="delete_title_pages[]" value="{{ $fileName }}" id="delete_title_page_{{ $loop->index }}">
        <label class="form-check-label" for="delete_title_page_{{ $loop->index }}">Delete file</label>
    </div>
    @endforeach
    <div class="box">
       <div class="input-box">
          <h2 class="upload-area-title">Upload Title Page <i>(docx,
                LaTeX doc)</i></h2>                                 
             <input type="file" id="upload1" data-id="title_pages" hidden multiple onchange="validateTitlePageFileType()" />
             <div class="text-danger" id="title_page_error"></div>
             <label for="upload1" class="uploadLabel">
                <span><i class="fa fa-cloud-upload"></i></span>
                <p>Click to Upload</p>
             </label>
       </div>

       <div id="filewrapper1">
          <h3 class="uploaded">Uploaded Documents</h3>
       </div>
    </div>
</div>
<hr>
<!-- Manuscript -->
<div class="mb-3">
    @foreach ($fileNames['manuscript'] as $fileName)
    <p style="color:burlywood">{{ $fileName }}</p>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" name="delete_manuscripts[]" value="{{ $fileName }}" id="delete_manuscript_{{ $loop->index }}">
        <label class="form-check-label" for="delete_manuscript_{{ $loop->index }}">Delete file</label>
    </div>
    @endforeach
    <div class="box">
       <div class="input-box">
          <h2 class="upload-area-title">Upload Manuscript <i>(docx, LaTeX doc)</i></h2>
             <input type="file" id="upload2" data-id="manuscript" hidden multiple onchange="validateManuscriptFileType()"/>
             <div class="text-danger" id="manuscript_error"></div>
             <label for="upload2" class="uploadLabel">
                <span><i class="fa fa-cloud-upload"></i></span>
                <p>Click to Upload</p>
             </label>
       </div>
       <div id="filewrapper2">
          <h3 class="uploaded">Uploaded Documents</h3>
       </div>
    </div>                         
</div>
<hr>
<!-- Figures -->
<div class="mb-3">
    @foreach ($fileNames['figures'] as $fileName)
    <p style="color:burlywood">{{ $fileName }}</p>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" name="delete_figures[]" value="{{ $fileName }}" id="delete_figure_{{ $loop->index }}">
        <label class="form-check-label" for="delete_figure_{{ $loop->index }}">Delete file</label>
    </div>
    @endforeach
    <div class="box">
       <div class="input-box">
          <h2 class="upload-area-title">Upload Figures <i>(jpg)</i></h2>
             <input type="file" id="upload3" data-id="figures" hidden multiple onchange="validateFiguresFileType()"/>
             <div class="text-danger" id="figures_error"></div>
             <label for="upload3" class="uploadLabel">
                <span><i class="fa fa-cloud-upload"></i></span>
                <p>Click to Upload</p>
             </label>
       </div>
       <div id="filewrapper3">
          <h3 class="uploaded">Uploaded Documents</h3>
       </div>
    </div>
</div>
<hr>
<!-- Tables -->
<div class="mb-3">
    @foreach ($fileNames['tables'] as $fileName)
    <p style="color:burlywood">{{ $fileName }}</p>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" name="delete_tables[]" value="{{ $fileName }}" id="delete_table_{{ $loop->index }}">
        <label class="form-check-label" for="delete_table_{{ $loop->index }}">Delete file</label>
    </div>
    @endforeach
    <div class="box">
       <div class="input-box">
          <h2 class="upload-area-title">Upload Tables <i>(docx)</i></h2>
             <input type="file" id="upload4" data-id="tables" hidden multiple onchange="validateTablesFileType()"/>
             <div class="text-danger" id="tables_error"></div>
             <label for="upload4" class="uploadLabel">
                <span><i class="fa fa-cloud-upload"></i></span>
                <p>Click to Upload</p>
             </label>
       </div>
       <div id="filewrapper4">
          <h3 class="uploaded">Uploaded Documents</h3>
       </div>
    </div>
</div>
<hr>
<!-- Supplementary -->
<div class="mb-3">
    @foreach ($fileNames['supplementaryFiles'] as $fileName)
    <p style="color:burlywood">{{ $fileName }}</p>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" name="delete_supplementary[]" value="{{ $fileName }}" id="delete_supplementary_{{ $loop->index }}">
        <label class="form-check-label" for="delete_supplementary_{{ $loop->index }}">Delete file</label>
    </div>
    @endforeach
    <div class="box">
       <div class="input-box">
          <h2 class="upload-area-title">Upload Supplementary <i>(docx, xls, xlsx, pdf, png, jpg)</i></h2>
             <input type="file" id="upload5" data-id="supplementary" hidden multiple onchange="validateSupplementaryFileType()"/>
             <div class="text-danger" id="supplementary_error"></div>
             <label for="upload5" class="uploadLabel">
                <span><i class="fa fa-cloud-upload"></i></span>
                <p>Click to Upload</p>
             </label>
       </div>
       <div id="filewrapper5">
          <h3 class="uploaded">Uploaded Documents</h3>
       </div>
    </div>
</div>
<hr>
<!-- Cover Letter -->
<div class="mb-3">
    @foreach ($fileNames['coverLetter'] as $fileName)
    <p style="color:burlywood">{{ $fileName }}</p>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" name="delete_cover_letter[]" value="{{ $fileName }}" id="delete_cover_letter_{{ $loop->index }}">
        <label class="form-check-label" for="delete_cover_letter_{{ $loop->index }}">Delete file</label>
    </div>
    @endforeach
    <div class="box">
        <div class="input-box">
           <h2 class="upload-area-title">Upload Cover Letter  <i>(docx, LaTeX doc)</i></h2>
              <input type="file" id="upload6" data-id="cover_letter" hidden multiple onchange="validateCoverLaterFileType()"/>
              <div class="text-danger" id="cover_letter_error"></div>
              <label for="upload6" class="uploadLabel">
                 <span><i class="fa fa-cloud-upload"></i></span>
                 <p>Click to Upload</p>
              </label>
        </div>
        <div id="filewrapper6">
           <h3 class="uploaded">Uploaded Documents</h3>
        </div>
     </div>
</div>
<hr>
                            
                        @else
                            <!-- Admin Accept -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="admin_accept" name="admin_accept"
                                    {{ $article->admin_accept ? 'checked' : '' }}>
                                <label class="form-check-label" for="admin_accept">Admin Accept</label>
                            </div>
                        @endif
                    </div>
                    <hr>
    {{-- ТАНЕР START --}}
    @foreach ($authors as $index => $author)
    <div class="author-row">
        <h3>Co Author</h3>
        <div class="row">
            <div class="col-md-6">
                <label for="author_{{ $index }}" class="form-label">* Name:</label>
                <input type="text" class="form-control" name="authors[{{ $index }}][first_name]" value="{{ $author->first_name }}" placeholder="First Name - required" required>
            </div>
            <div class="col-md-6">
                <label for="middle_name_{{ $index }}" class="form-label">Middle Name/Initial:</label>
                <input type="text" class="form-control" name="authors[{{ $index }}][middle_name]" value="{{ $author->middle_name }}" placeholder="Middle Name/Initial">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="family_name_{{ $index }}" class="form-label">* Family Name:</label>
                <input type="text" class="form-control" name="authors[{{ $index }}][family_name]" value="{{ $author->family_name }}" placeholder="Family Name - required" required>
            </div>
            <div class="col-md-6">
                <label for="primary_affiliation_{{ $index }}" class="form-label">* Primary Affiliation:</label>
                <input type="text" class="form-control" name="authors[{{ $index }}][primary_affiliation]" value="{{ $author->primary_affiliation }}" placeholder="Primary Affiliation - required" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="contact_{{ $index }}" class="form-label">* Contact (E-mail):</label>
                <input type="email" class="form-control" name="authors[{{ $index }}][contact_email]" value="{{ $author->contact_email }}" placeholder="E-mail - required" required>
            </div>

            <div>
                <label for="position">Position</label>
                <input type="number" name="authors[{{ $index }}][position]" value="{{ $author->position }}" class="form-control">
            </div>

            <div>
                <label for="is_corresponding_author_{{ $index }}">
                    <input type="checkbox" name="authors[{{ $index }}][is_corresponding_author]" value="1" {{ $author->is_corresponding_author ? 'checked' : '' }}>
                    Corresponding Author
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <label for="author_contributions_{{ $index }}" class="form-label">Author Contributions Statement:</label>
            <textarea class="form-control" name="authors[{{ $index }}][author_contributions]" placeholder="Author Contributions Statement" rows="3">{{ $author->author_contributions }}</textarea>
        </div>
        <div class="row">
            <div class="col-md-12 text-end">
                <button type="button" class="btn btn-danger" onclick="removeAuthor(this)">Remove Author</button>
            </div>
        </div>
    </div>
@endforeach


    {{-- ТАНЕР END --}}
                

                    <div class="mb-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning" id="submitBtn">Edit Article</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

 
    <script>
        window.addEventListener("load", () => {
               const fileInputs = document.querySelectorAll("input[type='file']")
               const submitBtn = document.getElementById("submitBtn");

               let filesByInput = {};

               fileInputs.forEach((input) => {
                  const filewrapper = document.getElementById(`filewrapper${input.id.slice(-1)}`);
                  filesByInput[input.dataset.id] = [];

                  input.addEventListener("change", (e) => {
                     Array.from(e.target.files).forEach((file) => {
                        let filetype = file.name.split(".").pop().toLowerCase();
                        
                        filesByInput[input.dataset.id].push(file); // filesToUpload[titlePage].push(file)
                        fileshow(file.name, filetype, filewrapper, filesByInput[input.dataset.id]);
                     });
                     // {titlePage:[file1, fiel2], manuscript: [file1], figures: [1,2,3,4,...]};
                  });
               });



               function fileshow(fileName, fileType, filewrapper, fileArray) {
                  const showfileboxEl = document.createElement("div");
                  const leftEl = document.createElement("div");
                  const rightEl = document.createElement("div");
                  const fileTypeEl = document.createElement("span");
                  const fileNameEl = document.createElement("h3");
                  const crossEl = document.createElement("span");

                  showfileboxEl.classList.add("showfilebox");
                  leftEl.classList.add("left");
                  rightEl.classList.add("right");
                  fileTypeEl.classList.add("filetype");

                  fileTypeEl.innerHTML = fileType;
                  fileNameEl.innerHTML = fileName;
                  crossEl.innerHTML = "&#215;";

                  leftEl.append(fileTypeEl);
                  leftEl.append(fileNameEl);
                  showfileboxEl.append(leftEl);
                  showfileboxEl.append(rightEl);
                  rightEl.append(crossEl);
                  filewrapper.append(showfileboxEl);

                  crossEl.addEventListener("click", () => {
                     filewrapper.removeChild(showfileboxEl);
                     const index = fileArray.findIndex((file) => file.name === fileName);

                     if (index > -1) fileArray.splice(index, 1);
                  });
               }

               submitBtn.addEventListener("click", (e) => {
                  
                e.preventDefault();
                  
                  submitBtn.disabled = true; // Деактивирайте бутона след изпращане на формата
                  
                  const formData = new FormData();
                  const articleId = "75";

                  // Append files grouped by input type
                  Object.keys(filesByInput).forEach((inputType) => {
                     filesByInput[inputType].forEach((file) => {
                        formData.append(`${inputType}[]`, file); // Group files under their respective input type                        
                     });
                  });
                  
                  const typeSelect = document.getElementById("article_type");
                  const specialtySelect = document.getElementById("specialty");
                  const scientificArea = document.getElementById("scientific_area");
                  const fundingInput = document.getElementById("funding_name");
                  const titleInput = document.getElementById("title");
                  const abstractInput = document.getElementById("abstract");
                  const grantInput = document.getElementById("grant_id");
                  const keywordsInput = document.getElementById("keywords");

                  formData.append("article_type", typeSelect.value);
                  formData.append("specialty", specialtySelect.value);
                  formData.append("scientific_area", scientificArea.value);
                  formData.append("funding_name", fundingInput.value);
                  formData.append("title", titleInput.value);
                  formData.append("abstract", abstractInput.value);
                  formData.append("grant_id", grantInput.value);
                  formData.append("keywords", keywordsInput.value); 

                  console.log([...formData.entries()]);
                  console.log(formData);   

                  // fetch("{{ url('/articles_/article-edit/') }}/" + articleId, {  
                  //       method: "PUT",
                  //       headers: {
                  //          "X-CSRF-TOKEN": "{{ csrf_token() }}" // Include CSRF token
                  //       },
                  //       body: formData,
                  //    })
                  fetch(`url(/articles_/article-edit/75`), {  
                    method: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: formData
                    })
                     .then((response) => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then((data) => {
                        if (data.success) {
                            alert(data.message);
                            window.location.href = data.redirect_url; // Redirect to article.list
                        } else {
                            alert("An error occurred: " + (data.message || "Unknown error"));
                        }
                    })
                    .catch((error) => {
                        console.error("There was a problem with the fetch operation:", error);
                        alert("An unexpected error occurred. Please try again.");
                    });
               });
            });
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
