@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Article: {{$article->title}}</h4>
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

            <form action="{{ route('articles.addIssueId', $article->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- !!!!!!!!!!!! Първа колона !!!!!!!!!!!! -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="final_article" class="form-label"><strong>Upload Final Article View (html file): </strong></label>
                            
                            <input type="file" name="final_article" multiple class="form-control" id="final_article">
                            <p style="color:blue">{{ $article->final_article_path  }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="pdf_file" class="form-label"><strong>Upload PDF file (download in frontend): </strong></label>
                            
                            <input type="file" name="pdf_file" multiple class="form-control" id="pdf_file">
                            <p style="color:blue">{{  $article->pdfs->last()->file_path  }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if (Auth::user()->role === 'author')
                        @elseif (Auth::user()->role === 'admin' && $article->status === 'accepted')
                        
                            <div class="mb-3">
                                <label for="issue_id" class="form-label"><strong>Issue ID: </strong></label>
                                <input type="number" class="form-control" name="issue_id" id="issue_id" placeholder=""
                                value="{{ $article->issue_id }}" min="1">
                                <span style="color: red">Max issue id is {{$maxIssueId}}<span>
                            </div>
                        @endif
                        {{-- <div class="mb-3">
                            <label class="form-check-label" for="declarations">
                                <input class="form-check-input" type="checkbox" id="declarations" required>
                                I hereby declare that...
                            </label>
                        </div> --}}
                    </div>


                    <hr>


                    <div class="mb-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


