@extends('canva.home')
@section('content')
    <!-- Document Wrapper
                                                    ============================================= -->
    <div id="wrapper">
        {{-- <section id="content">
			<div class="content-wrap">
		<!-- Page Title
		============================================= -->
		<section class="page-title bg-transparent">
			<div class="container">
				<div class="page-title-row">

					<div class="page-title-content">
						<h1>Article #{{$article->id}} </h1>
					</div>

					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="/">Home</a></li>
							<li class="breadcrumb-item"><a href="/articles">Articles</a></li>
							<li class="breadcrumb-item active" aria-current="page">Article #{{$article->id}}</li>
						</ol>
					</nav>

				</div>
			</div>
		</section><!-- .page-title end --> --}}

        <!-- Content
                                              ============================================= -->
        <section id="content">
            <div class="content-wrap">
                <div class="container">

                    <div class="row gx-5 col-mb-80">
                        <!-- Post Content
                                                  ============================================= -->
                        <main class="postcontent col-lg-9">

                            <div class="single-post mb-0">

                                <!-- Single Post
                                                    ============================================= -->
                                <div class="entry article-scroll">
                                    <p id='article-title' style="margin-bottom: 70px;"></p>
                                    <!-- Entry Title
                                                     ============================================= -->
                                    <div class="entry-title">
                                        <h2>{{ $article->title }}</h2>
                                    </div><!-- .entry-title end -->

                                    <!-- Entry Meta
                                                     ============================================= -->
                                    <div class="entry-meta">
                                        <ul>
                                            <li><i class="uil uil-schedule"></i>{{ $article->updated_at->format('Y-m-d') }}
                                            </li>
                                            <li><i class="uil uil-user"></i>{{ $article->user->name }}</li>
                                            <li><i class="uil uil-folder-open"></i>{{ $article->specialty }}</li>
                                            <li><i class="uil uil-folder-open"></i>{{ $article->scientific_area }}</li>
                                        </ul>
                                    </div><!-- .entry-meta end -->

                                    <!-- Entry Image
                                                     ============================================= -->
                                    {{-- <div class="entry-image">
										<a href="#"><img src="images/blog/full/1.jpg" alt="Blog Single"></a>
									</div><!-- .entry-image end --> --}}

                                    <!-- Entry Content
                                                     ============================================= -->
                                    <div class="entry-content mt-0">


                                        <p id='abstract' style="margin-bottom: 70px;"></p>
                                        <h3>Abstract</h3>
                                        <p>{{ $article->abstract }}</p>

                                        <p id='keywords' style="margin-bottom: 90px;"></p>
                                        <h3 id="keywords">Keywords</h3>
                                        <p>{{ $article->keywords }}</p>

                                        {{-- titlePage --}}
                                        @if (isset($article->titlePage))
                                            <p id='titlePage' style="margin-bottom: 90px;"></p>
                                            <h3 id="titlePage">Title Page</h3>
                                            <div class="row justify-content-center">
                                                @foreach ($article->titlePage as $file)
                                                    <iframe style="width: 100%; height: 1000px"
                                                        src="https://view.officeapps.live.com/op/embed.aspx?src=https://blmprime.com/storage/{{ $file->file_path }}"
                                                        frameborder="0"></iframe>
                                                    {{-- <iframe style="width: 100%; height: 1000px" src="https://view.officeapps.live.com/op/embed.aspx?src=https://calibre-ebook.com/downloads/demos/demo.docx" frameborder="0"></iframe> --}}
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Tables --}}
                                        @if (isset($article->tables))
                                            <p id='table' style="margin-bottom: 90px;"></p>
                                            <h3 id="table">Tables</h3>
                                            <div class="row justify-content-center">
                                                {{-- Дали не трябва да е DOWNLOADable file? --}}
                                                @foreach ($article->tables as $file)
                                                    <iframe style="width: 100%; height: 1000px"
                                                        src="https://view.officeapps.live.com/op/embed.aspx?src=https://blmprime.com/storage/{{ $file->file_path }}"
                                                        frameborder="0"></iframe>
                                                    {{-- <iframe style="width: 100%; height: 1000px" src="https://view.officeapps.live.com/op/embed.aspx?src=https://calibre-ebook.com/downloads/demos/demo.docx" frameborder="0"></iframe> --}}
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Supplementary Files --}}
                                        @if (isset($article->supplementaryFiles))
                                            <p id='supplementaryFiles' style="margin-bottom: 90px;"></p>
                                            <h3 id="supplementaryFiles">Supllementary Files</h3>
                                            @foreach ($article->supplementaryFiles as $file)
                                                @if (str_ends_with($file->file_path, '.pdf'))
                                                    <iframe src="{{ asset('storage/' . $file->file_path) }}" width="50%"
                                                        height="900">
                                                        This browser does not support PDFs. Please download the PDF to view
                                                        it: <a href="{{ asset('storage/' . $file->file_path) }}">Download
                                                            PDF</a>
                                                    </iframe>
                                                @elseif (str_ends_with($file->file_path, '.doc'))
                                                    <iframe style="width: 100%; height: 1000px"
                                                        src="https://view.officeapps.live.com/op/embed.aspx?src=https://blmprime.com/storage/{{ $file->file_path }}"
                                                        frameborder="0"></iframe>
                                                @elseif (str_ends_with($file->file_path, '.docx'))
                                                    <iframe style="width: 100%; height: 1000px"
                                                        src="https://view.officeapps.live.com/op/embed.aspx?src=https://blmprime.com/storage/{{ $file->file_path }}"
                                                        frameborder="0"></iframe>
                                                    {{-- xlxs --}}
                                                @elseif (str_ends_with($file->file_path, '.xlsx'))
                                                    <iframe style="width: 100%; height: 1000px"
                                                        src="https://view.officeapps.live.com/op/embed.aspx?src=https://blmprime.com/storage/{{ $file->file_path }}"
                                                        frameborder="0"></iframe>
                                                @elseif (str_ends_with($file->file_path, '.xls'))
                                                    <iframe style="width: 100%; height: 1000px"
                                                        src="https://view.officeapps.live.com/op/embed.aspx?src=https://blmprime.com/storage/{{ $file->file_path }}"
                                                        frameborder="0"></iframe>
                                                @elseif (str_ends_with($file->file_path, '.jpg'))
                                                    <img src="{{ 'https://blmprime.com/storage/' . $file->file_path }}"
                                                        alt="" />
                                                @endif
                                            @endforeach
                                        @endif

                                        {{-- Manuscripts --}}
                                        @if (isset($article->manuscript))
                                            <p id='manuscript' style="margin-bottom: 90px;"></p>
                                            <h3 id="manuscript">Manuscripts</h3>
                                            <div class="row justify-content-center">
                                                @foreach ($article->manuscript as $file)
                                                    <iframe style="width: 100%; height: 1000px"
                                                        src="https://view.officeapps.live.com/op/embed.aspx?src=https://blmprime.com/storage/{{ $file->file_path }}"
                                                        frameborder="0"></iframe>
                                                    {{-- <iframe style="width: 100%; height: 1000px" src="https://view.officeapps.live.com/op/embed.aspx?src=https://calibre-ebook.com/downloads/demos/demo.docx" frameborder="0"></iframe> --}}
                                                @endforeach
                                            </div>
                                        @endif
                                        {{-- figures --}}
                                        @if (isset($article->figures))
                                            <p id='figures' style="margin-bottom: 90px;"></p>
                                            <h3 id="figures">Figures</h3>
                                            <div class="row justify-content-center">
                                                @foreach ($article->figures as $file)
                                                    <img src="{{ 'https://blmprime.com/storage/' . $file->file_path }}"
                                                        alt="" />
                                                @endforeach
                                            </div>
                                        @endif
                                        {{-- coverLetter --}}
                                        @if (isset($article->coverLetter))
                                            <p id='coverLetter' style="margin-bottom: 90px;"></p>
                                            <h3 id="coverLetter">Cover letter</h3>
                                            <div class="row justify-content-center">
                                                @foreach ($article->manuscript as $file)
                                                    <iframe style="width: 100%; height: 1000px"
                                                        src="https://view.officeapps.live.com/op/embed.aspx?src=https://blmprime.com/storage/{{ $file->file_path }}"
                                                        frameborder="0"></iframe>
                                                    {{-- <iframe style="width: 100%; height: 1000px" src="https://view.officeapps.live.com/op/embed.aspx?src=https://calibre-ebook.com/downloads/demos/demo.docx" frameborder="0"></iframe> --}}
                                                @endforeach
                                            </div>
                                        @endif




                                    </div>
                                </div><!-- .entry end -->

                                <!-- Post Single - Share
                                                      ============================================= -->

                                {{-- <h4 class="fs-4 fw-medium">Recommended for you - Тука можем да сложим </h4>

								<div class="related-posts row posts-md g-4">
									<div class="entry col-12 col-md-6">
										<div class="grid-inner row gx-4">
											<div class="col-auto">
												<div class="entry-image">
													<a href="#"><img src="images/blog/small/10.jpg" alt="Blog Single" class="square square-lg" style="object-fit: cover; object-position: center;"></a>
												</div>
											</div>
											<div class="col">
												<div class="entry-meta font-secondary fst-italic mt-0">
													<ul>
														<li><a href="#">Entertainment</a></li>
													</ul>
												</div>
												<div class="entry-title title-sm text-transform-none">
													<h3><a href="#">Best Ways to be more Creative</a></h3>
												</div>
												<div class="entry-meta font-secondary mt-2">
													<ul>
														<li>Posted 4 Days ago</li>
														<li><a href="#"><i class="uil uil-comments-alt"></i> 12</a></li>
													</ul>
												</div>
											</div>
										</div>
									</div>

									<div class="entry col-12 col-md-6">
										<div class="grid-inner row gx-4">
											<div class="col-auto">
												<div class="entry-image">
													<a href="#"><img src="images/blog/small/20.jpg" alt="Blog Single" class="square square-lg" style="object-fit: cover; object-position: center;"></a>
												</div>
											</div>
											<div class="col">
												<div class="entry-meta font-secondary fst-italic mt-0">
													<ul>
														<li><a href="#">Viral</a></li>
													</ul>
												</div>
												<div class="entry-title title-sm text-transform-none">
													<h3><a href="#">5 Interesting Viral Videos</a></h3>
												</div>
												<div class="entry-meta font-secondary mt-2">
													<ul>
														<li>Posted 2 weeks ago</li>
														<li><a href="#"><i class="uil uil-comments-alt"></i> 422</a></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div> --}}



                            </div>

                        </main><!-- .postcontent end -->

                        <!-- Sidebar
                                                  ============================================= -->
                        <aside class="sidebar col-lg-3">
                            <div class="sidebar-widgets-wrap">

                                <div class="widget">
                                    <h4>Contnts</h4>
                                    <a href="{{ route('admin.downolad_summary_pdf', $article->id) }}"><button
                                            type="button" class="btn btn-success btn-sm">PDF</button></a>
                                    <div class="tagcloud">
                                        <a href="#article-title">Article title</a>
                                        <a href="#abstract">Abstract</a>
                                        <a href="#keywords">Keywords</a>
                                        <a href="#">Manoscript</a>
                                        <a href="#supplementaryFiles">Supllementary Files</a>
                                    </div>
                                </div>
                           

                                @if (isset($article->figures))
                                <div class="widget">
                                    <h4>Gallery</h4>
                                    <div class="row">
                                        @foreach ($article->figures as $file)

                                        <div class="col-6 col-sm-6 mb-3">
                                            <a href="{{ '//storage/' . $file->file_path }}" data-lightbox="gallery"
                                                data-title="Image 1">
                                                <img src="{{ '//storage/' . $file->file_path }}" class="img-fluid rounded"
                                                    alt="Image 1">
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

    </div>
    </section><!-- #content end -->

    </div><!-- #wrapper end -->
@endsection
