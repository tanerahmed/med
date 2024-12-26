
@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Upload PDF {{ $article->title }}</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-xl-6 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('pdfs.store', $article->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <div class="box">
                                   <div class="input-box">
                                        <div id="supplementary_selected_files"></div>
                                        <input type="file" name="pdf_file" required multiple class="form-control" id="file" onchange="validateSupplementaryFileType(); displaySelectedFiles('supplementary')">
                                        <div class="text-danger" id="supplementary_error"></div>

                                   </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "order": [
                    [5, "desc"]
                ] // Сортиране по втората колона (индекс 1) във възходящ ред
            });
        });
    </script>
@endsection
