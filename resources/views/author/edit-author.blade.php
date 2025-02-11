@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">reject reason</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-xl-12 stretch-card">
                <div class="card">
                    <div class="container">
                        
                        <form action="{{ route('article.updateAuthorCanEdit', $article->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                    
                            <div class="mb-3">
                                <textarea name="reason" id="reason" class="form-control" rows="4"></textarea>
                            </div>
                    
                            <input type="hidden" name="author_can_edit" value="1">
                    
                            <button type="submit" class="btn btn-primary">Send Email</button>
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
