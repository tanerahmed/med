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

            <form action="{{ route('articles.adminAcceptArticle', $article->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- !!!!!!!!!!!! Първа колона !!!!!!!!!!!! -->
                    <div class="col-md-6">
                       
                    </div>

                    <!-- !!!!!!!!!!!! Втора колона !!!!!!!!!!!! -->
                    <div class="col-md-6">
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="admin_accept" name="admin_accept"
                                    {{ $article->admin_accept ? 'checked' : '' }}>
                                <label class="form-check-label" for="admin_accept">Admin Accept</label>
                            </div>
                    </div>
                    <hr>


                    <div class="mb-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning">Accept Article</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

