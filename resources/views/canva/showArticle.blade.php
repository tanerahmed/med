@extends('canva.home')
@section('content')
    <!-- Document Wrapper ============================================= -->
    <div id="wrapper">
        <section id="content">
            <div class="content-wrap">
                <div class="container">
                    <div class="row gx-5 col-mb-80">
                        <!-- Post Content ============================================= -->
                        <main class="postcontent col-lg-9">
                            <div class="single-post mb-0">
                                <!-- Single Post Content Here -->
                                {!! $content !!}
                            </div>
                        </main><!-- .postcontent end -->

                        <!-- Sidebar ============================================= -->
                        <aside class="sidebar col-lg-3 custom-sidebar">
                            <div class="sidebar-widgets-wrap">
                                <div class="widget tagcloud-widget custom-tagcloud-widget" id="tagcloud-widget">
                                    <h4>Contents</h4>
                                    <div class="tagcloud custom-tagcloud" id="tagcloud">
                                        <a href="#article-title">Article title</a>
                                        <a href="#abstract">Abstract</a>
                                        <a href="#keywords">Keywords</a>
                                        <a href="#title_page">Title Page</a>
                                        <a href="#manuscript">Manuscript</a>
                                        <a href="#supplementary">Supplementary Files</a>
                                        @if ($article->final_article_path)
                                            <a href="https://blmprime.com/storage/{{ $article->final_article_path }}" download class="btn btn-success btn-sm custom-button">
                                                Download
                                            </a>
                                        @endif

                                        @if ($article->xmlFiles->isNotEmpty())
                                            <a href="{{ route('download.latest.xml.for.article', ['articleId' => $article->id]) }}" class="btn btn-primary btn-sm custom-button">
                                                Download XML
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                @if (isset($article->figures))
                                    <div class="widget custom-gallery-widget">
                                        <h4>Gallery</h4>
                                        <div class="row">
                                            @foreach ($article->figures as $file)
                                                <div class="col-6 col-sm-6 mb-3">
                                                    <a href="{{ 'https://blmprime.com/storage/' . $file->file_path }}"
                                                        data-lightbox="gallery" data-title="Image 1">
                                                        <img src="{{ 'https://blmprime.com/storage/' . $file->file_path }}"
                                                            class="img-fluid rounded" alt="Image 1">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </aside><!-- .sidebar end -->
                    </div>
                </div>
            </div>
        </section><!-- #content end -->
    </div><!-- #wrapper end -->

    <style>
        /* Стилове за котвите */
        :target {
            scroll-margin-top: 100px;
        }

        /* Стилове за tagcloud-widget */
        .custom-tagcloud-widget.fixed {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            border: 1px solid #ddd;
            padding: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .sidebar-widgets-wrap.widget:first-child{
            z-index: 10000;
        }
        
        /* Подреждане на елементите в tagcloud на един ред */
        .custom-tagcloud {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .custom-tagcloud.fixed-layout {
            flex-direction: row;
        }

        .custom-tagcloud a, 
        .custom-tagcloud button {
            /* background-color: #198754; */
            white-space: nowrap;
            color: black;
            /* color: #fff; */
            text-decoration: none;
        }

        .custom-tagcloud a:hover,
        .custom-tagcloud button:hover {
            text-decoration: underline;
        }

        .custom-tagcloud .custom-button {
            margin-top: 10px;
        }

        /* Стилове за sidebar */
        .custom-sidebar {
            /* Можете да добавите специфични стилове за сайдбара тук */
        }

        /* Стилове за gallery-widget */
        .custom-gallery-widget {
            /* Можете да добавите специфични стилове за галерията тук */
        }
 /* Медийна заявка за мобилни устройства */
 @media (max-width: 767px) {
            .custom-tagcloud-widget.fixed {
                position: static;
                transform: none;
                box-shadow: none;
                border: none;
                padding: 0;
            }

            .custom-tagcloud.fixed-layout {
                flex-direction: column;
            }

            .custom-tagcloud .custom-button {
                margin-top: 10px;
            }
        }

    </style> 

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tagcloudWidget = document.getElementById('tagcloud-widget');
            const tagcloud = document.getElementById('tagcloud');
            const offsetTop = tagcloudWidget.offsetTop;

            window.addEventListener('scroll', function() {
                if (window.pageYOffset > offsetTop) {
                    tagcloudWidget.classList.add('fixed');
                    tagcloud.classList.add('fixed-layout');
                } else {
                    tagcloudWidget.classList.remove('fixed');
                    tagcloud.classList.remove('fixed-layout');
                }
            });
        });
    </script>
@endsection

