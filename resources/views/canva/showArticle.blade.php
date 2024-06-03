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
                        <aside class="sidebar col-lg-3">
                            <div class="sidebar-widgets-wrap">
                                <div class="widget tagcloud-widget" id="tagcloud-widget">
                                    <h4>Contents</h4>
                                    <div class="tagcloud">
                                        <a href="#article-title">Article title</a>
                                        <a href="#abstract">Abstract</a>
                                        <a href="#keywords">Keywords</a>
                                        <a href="#title_page">Title Page</a>
                                        <a href="#manuscript">Manuscript</a>
                                        <a href="#supplementary">Supplementary Files</a>
                                        @if ($article->final_article_path)
                                        <a href="https://blmprime.com/storage/{{ $article->final_article_path }}" download>
                                            <button type="button" class="btn btn-success btn-sm">Download</button>
                                        </a>
                                        @endif
                                    </div>
                                </div>

                                @if (isset($article->figures))
                                    <div class="widget">
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

    {{-- <style>
        /* Стилове за котвите */
        :target {
            scroll-margin-top: 100px;
        }


        /* Предварителен стил за позицията */
        .tagcloud-widget.fixed {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            /* Бял фон за по-голяма видимост */
            border: 1px solid #ddd;
            /* Светла рамка */
            padding: 10px;
            /* Отстояние вътре в контейнера */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Лека сянка за по-голяма видимост */
        }

        /* Подреждане на елементите в tagcloud на един ред */
        .tagcloud {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            /* разстояние между елементите */
            justify-content: center;
            /* Центриране на елементите вътре в tagcloud */
        }

        .tagcloud a,
        .tagcloud button {
            background-color: #198754;
            white-space: nowrap;
            color: #fff;
            /* Тъмен цвят за текста за по-голяма видимост */
            text-decoration: none;
            /* Премахване на подчертаването на линковете */
        }

        .tagcloud a:hover,
        .tagcloud button:hover {
            text-decoration: underline;
            /* Подчертаване на линковете при hover за по-голяма видимост */
        }
    </style> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tagcloudWidget = document.getElementById('tagcloud-widget');
            const offsetTop = tagcloudWidget.offsetTop;

            window.addEventListener('scroll', function() {
                if (window.pageYOffset > offsetTop) {
                    tagcloudWidget.classList.add('fixed');
                } else {
                    tagcloudWidget.classList.remove('fixed');
                }
            });
        });
    </script>
@endsection
