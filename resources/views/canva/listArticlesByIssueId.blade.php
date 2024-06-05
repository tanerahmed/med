@extends('canva.home')
@section('content')
    <!-- Page Title
              ============================================= -->
    <section class="page-title bg-transparent">
        <div class="container">
            <div class="page-title-row">

                <div class="page-title-content">
                    <h1>Articles - Issue # {{ $issueId }}</h1>
                </div>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Articles</li>
                    </ol>
                </nav>

            </div>
        </div>
    </section><!-- .page-title end -->

    <!-- Content
              ============================================= -->
    <section id="content">
        <div class="content-wrap">
            <div class="container">

                <div class="row gx-5 col-mb-80">
                    <!-- Post Content
                  ============================================= -->
                    <main class="postcontent col-lg-9 order-lg-last">

                        <!-- Posts
                   ============================================= -->
                        <div id="posts" class="row gutter-40">
                            @if ($articles->count())
                                @foreach ($articles as $article)
                                    <div class="entry col-12">
                                        <div class="grid-inner row g-0">
                                            <div class="col-md-4">
                                                <div class="entry-image">
                                                    <a href={{ route('canva.showArticle', $article->id) }}>
                                                        @if ($article->figures->count() > 0)
                                                            <img src="{{ asset('storage/' . $article->figures[0]->file_path) }}"
                                                                alt="" style="width: 200px !important; ">
                                                        @else
                                                            <img src="{{ asset('storage/no-img.jpg') }}" alt="Default Image"
                                                                style="width: 200px !important;">
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-8 ps-md-4">
                                                <div class="entry-title title-sm">
                                                    <h2><a
                                                            href={{ route('canva.showArticle', $article->id) }}>{{ $article->title }}</a>
                                                    </h2>
                                                </div>
                                                <div class="entry-meta">
                                                    <ul>
                                                        <li><i
                                                                class="uil uil-schedule"></i>{{ $article->updated_at->format('Y-m-d') }}
                                                        </li>
                                                        <li><i class="uil uil-folder-open"></i>{{ $article->specialty }}
                                                        </li>
                                                        <li><i
                                                                class="uil uil-folder-open"></i>{{ $article->scientific_area }}
                                                        </li>
                                                    </ul>
                                                        <br>
                                                        <ul>
                                                            <li><i class="uil uil-user"></i>{{ $article->user->name }}</li>

                                                            @foreach ($article->authors as $author)
                                                                @if ($author)
                                                                    <li><i
                                                                            class="uil uil-user"></i>{{ $author->first_name }}
                                                                        {{ $author->family_name }}</li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                        <br>
                                                        <ul>
                                                            @if ($article->final_article_path)
                                                                <li>
                                                                    <a href="https://blmprime.com/storage/{{ $article->final_article_path }}"
                                                                        download>
                                                                        <button type="button"
                                                                            class="btn btn-success btn-sm">Download</button>
                                                                    </a>
                                                                    {{-- <a href="{{ route('admin.downolad_summary_pdf', $article->id) }}"><button type="button" class="btn btn-success btn-sm">PDF</button></a> --}}
                                                                </li>
                                                            @endif
                                                        </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-8 ps-md-4">
                                                <div class="entry-meta">
                                                    <ul>


                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h3>There are no search results.</h3>
                            @endif
                        </div><!-- #posts end -->

                    </main><!-- .postcontent end -->

                    <!-- Sidebar
                  ============================================= -->

                </div>

            </div>
        </div>
    </section><!-- #content end -->
@endsection


<script></script>
