@extends('canva.home')
@section('content')
    <!-- Page Title
                      ============================================= -->
    <section class="page-title bg-transparent">
        <div class="container">
            <div class="page-title-row">

                <div class="page-title-content">
                    <h1>Articles</h1>
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
                                            <div class="col-md-2">
                                                <div class="entry-image">
                                                    <a href={{ route('canva.showArticle', $article->id) }}>
                                                        @if ($article->figures->count() > 0)
                                                            <img src="{{ asset('storage/' . $article->figures[0]->file_path) }}"
                                                                alt="" style="width: 200px !important;">
                                                        @else
                                                            <img src="{{ asset('storage/no-img.jpg') }}" alt="Default Image"
                                                                style="width: 200px !important;">
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-10 ps-md-4">
                                                <div class="entry-title title-sm">
                                                    <h2><a
                                                            href={{ route('canva.showArticle', $article->id) }}>{{ $article->title }}</a>
                                                    </h2>
                                                </div>
                                                <div class="entry-meta">
                                                    <ul>
                                                        <li><i
                                                                class="uil uil-schedule"></i>{{ $article->created_at->format('Y-m-d') }}
                                                        </li>
                                                       
                                                        <li><i class="uil uil-folder-open"></i>{{ $article->specialty }}
                                                        </li>
                                                        <li><i
                                                                class="uil uil-folder-open"></i>{{ $article->scientific_area }}
                                                        </li>
                                                    </ul>
                                                    <br>
                                                    <ul>
                                                        @foreach ($article->authors as $author)
                                                            @if ($author)
                                                                <li><i class="uil uil-user"></i>{{ $author->first_name }} {{ $author->family_name }}</li>
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
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-8 ps-md-4">
                                                <div class="entry-meta">
                                                    <ul>


                                                    </ul>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h3>There are no search results.</h3>
                            @endif

                            <div class="pagination">
                                {{ $articles->links() }} <!-- Генерира бутоните за навигация -->
                            </div>

                        </div><!-- #posts end -->

                    </main><!-- .postcontent end -->
                    @if ($articles->count())
                        <!-- Sidebar
                          ============================================= -->
                          <aside class="sidebar col-lg-3">
                            <div class="sidebar-widgets-wrap">
                                <div class="widget">
                                    <h4>Specialty Filtre</h4>
                                    <div class="tagcloud">
                                        @foreach ($specialties as $speciality)
                                        <a href="{{ route('canva.listArticlesBySpecialty', "$speciality") }}" class="{{ $activeSpecialty === "$speciality" ? 'active' : '' }}">{{ $speciality}}</a>
                                        @endforeach

                                        {{-- <a href="{{ route('canva.listArticlesBySpecialty', 'УНГ') }}" class="{{ $activeSpecialty === 'УНГ' ? 'active' : '' }}">УНГ</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Урология') }}" class="{{ $activeSpecialty === 'Урология' ? 'active' : '' }}">Урология</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Anesthesiology & Intensive care') }}" class="{{ $activeSpecialty === 'Anesthesiology & Intensive care' ? 'active' : '' }}">Anesthesiology & Intensive care</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Clinical anatomy') }}" class="{{ $activeSpecialty === 'Clinical anatomy' ? 'active' : '' }}">Clinical anatomy</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Clinical laboratory sciences') }}" class="{{ $activeSpecialty === 'Clinical laboratory sciences' ? 'active' : '' }}">Clinical laboratory sciences</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Clinical biochemistry') }}" class="{{ $activeSpecialty === 'Clinical biochemistry' ? 'active' : '' }}">Clinical biochemistry</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Cytogenetics') }}" class="{{ $activeSpecialty === 'Cytogenetics' ? 'active' : '' }}">Cytogenetics</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Cytohematology') }}" class="{{ $activeSpecialty === 'Cytohematology' ? 'active' : '' }}">Cytohematology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Cytology') }}" class="{{ $activeSpecialty === 'Cytology' ? 'active' : '' }}">Cytology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Hemostaseology') }}" class="{{ $activeSpecialty === 'Hemostaseology' ? 'active' : '' }}">Hemostaseology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Histology') }}" class="{{ $activeSpecialty === 'Histology' ? 'active' : '' }}">Histology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Clinical immunology') }}" class="{{ $activeSpecialty === 'Clinical immunology' ? 'active' : '' }}">Clinical immunology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Clinical microbiology') }}" class="{{ $activeSpecialty === 'Clinical microbiology' ? 'active' : '' }}">Clinical microbiology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Molecular genetics') }}" class="{{ $activeSpecialty === 'Molecular genetics' ? 'active' : '' }}">Molecular genetics</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Clinical genetics') }}" class="{{ $activeSpecialty === 'Clinical genetics' ? 'active' : '' }}">Clinical genetics</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Parasitology') }}" class="{{ $activeSpecialty === 'Parasitology' ? 'active' : '' }}">Parasitology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Clinical physiology') }}" class="{{ $activeSpecialty === 'Clinical physiology' ? 'active' : '' }}">Clinical physiology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Dentistry') }}" class="{{ $activeSpecialty === 'Dentistry' ? 'active' : '' }}">Dentistry</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Dental surgery') }}" class="{{ $activeSpecialty === 'Dental surgery' ? 'active' : '' }}">Dental surgery</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Endodontics') }}" class="{{ $activeSpecialty === 'Endodontics' ? 'active' : '' }}">Endodontics</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Orthodontics') }}" class="{{ $activeSpecialty === 'Orthodontics' ? 'active' : '' }}">Orthodontics</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Oral and maxillofacial surgery') }}" class="{{ $activeSpecialty === 'Oral and maxillofacial surgery' ? 'active' : '' }}">Oral and maxillofacial surgery</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Dermatology') }}" class="{{ $activeSpecialty === 'Dermatology' ? 'active' : '' }}">Dermatology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Emergency medicine') }}" class="{{ $activeSpecialty === 'Emergency medicine' ? 'active' : '' }}">Emergency medicine</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Health informatics/Clinical informatics') }}" class="{{ $activeSpecialty === 'Health informatics/Clinical informatics' ? 'active' : '' }}">Health informatics/Clinical informatics</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Nursing') }}" class="{{ $activeSpecialty === 'Nursing' ? 'active' : '' }}">Nursing</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Nutrition and dietetics') }}" class="{{ $activeSpecialty === 'Nutrition and dietetics' ? 'active' : '' }}">Nutrition and dietetics</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Physiotherapy') }}" class="{{ $activeSpecialty === 'Physiotherapy' ? 'active' : '' }}">Physiotherapy</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Speech and language pathology') }}" class="{{ $activeSpecialty === 'Speech and language pathology' ? 'active' : '' }}">Speech and language pathology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Internal medicine') }}" class="{{ $activeSpecialty === 'Internal medicine' ? 'active' : '' }}">Internal medicine</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Preventive medicine') }}" class="{{ $activeSpecialty === 'Preventive medicine' ? 'active' : '' }}">Preventive medicine</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Cardiology') }}" class="{{ $activeSpecialty === 'Cardiology' ? 'active' : '' }}">Cardiology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Cardiac electrophysiology') }}" class="{{ $activeSpecialty === 'Cardiac electrophysiology' ? 'active' : '' }}">Cardiac electrophysiology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Pulmonology') }}" class="{{ $activeSpecialty === 'Pulmonology' ? 'active' : '' }}">Pulmonology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Medical toxicology') }}" class="{{ $activeSpecialty === 'Medical toxicology' ? 'active' : '' }}">Medical toxicology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Endocrinology') }}" class="{{ $activeSpecialty === 'Endocrinology' ? 'active' : '' }}">Endocrinology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Gastroenterology') }}" class="{{ $activeSpecialty === 'Gastroenterology' ? 'active' : '' }}">Gastroenterology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Hepatology') }}" class="{{ $activeSpecialty === 'Hepatology' ? 'active' : '' }}">Hepatology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Oncology') }}" class="{{ $activeSpecialty === 'Oncology' ? 'active' : '' }}">Oncology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Radiation therapy') }}" class="{{ $activeSpecialty === 'Radiation therapy' ? 'active' : '' }}">Radiation therapy</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Geriatrics') }}" class="{{ $activeSpecialty === 'Geriatrics' ? 'active' : '' }}">Geriatrics</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Gynaecology') }}" class="{{ $activeSpecialty === 'Gynaecology' ? 'active' : '' }}">Gynaecology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Hematology') }}" class="{{ $activeSpecialty === 'Hematology' ? 'active' : '' }}">Hematology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Infectious disease') }}" class="{{ $activeSpecialty === 'Infectious disease' ? 'active' : '' }}">Infectious disease</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Nephrology') }}" class="{{ $activeSpecialty === 'Nephrology' ? 'active' : '' }}">Nephrology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Neurology') }}" class="{{ $activeSpecialty === 'Neurology' ? 'active' : '' }}">Neurology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Neurosurgery') }}" class="{{ $activeSpecialty === 'Neurosurgery' ? 'active' : '' }}">Neurosurgery</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Obstetrics') }}" class="{{ $activeSpecialty === 'Obstetrics' ? 'active' : '' }}">Obstetrics</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Ophthalmology') }}" class="{{ $activeSpecialty === 'Ophthalmology' ? 'active' : '' }}">Ophthalmology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Neuro-ophthalmology') }}" class="{{ $activeSpecialty === 'Neuro-ophthalmology' ? 'active' : '' }}">Neuro-ophthalmology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Orthopedic surgery') }}" class="{{ $activeSpecialty === 'Orthopedic surgery' ? 'active' : '' }}">Orthopedic surgery</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Otorhinolaryngology') }}" class="{{ $activeSpecialty === 'Otorhinolaryngology' ? 'active' : '' }}">Otorhinolaryngology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Pathology') }}" class="{{ $activeSpecialty === 'Pathology' ? 'active' : '' }}">Pathology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Pediatrics') }}" class="{{ $activeSpecialty === 'Pediatrics' ? 'active' : '' }}">Pediatrics</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Pharmaceutical sciences') }}" class="{{ $activeSpecialty === 'Pharmaceutical sciences' ? 'active' : '' }}">Pharmaceutical sciences</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Clinical pharmacology') }}" class="{{ $activeSpecialty === 'Clinical pharmacology' ? 'active' : '' }}">Clinical pharmacology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Physical therapy') }}" class="{{ $activeSpecialty === 'Physical therapy' ? 'active' : '' }}">Physical therapy</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'General practice') }}" class="{{ $activeSpecialty === 'General practice' ? 'active' : '' }}">General practice</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Psychiatry') }}" class="{{ $activeSpecialty === 'Psychiatry' ? 'active' : '' }}">Psychiatry</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Public health') }}" class="{{ $activeSpecialty === 'Public health' ? 'active' : '' }}">Public health</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Radiology') }}" class="{{ $activeSpecialty === 'Radiology' ? 'active' : '' }}">Radiology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Rehabilitation medicine') }}" class="{{ $activeSpecialty === 'Rehabilitation medicine' ? 'active' : '' }}">Rehabilitation medicine</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Respiratory medicine') }}" class="{{ $activeSpecialty === 'Respiratory medicine' ? 'active' : '' }}">Respiratory medicine</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Sleep medicine') }}" class="{{ $activeSpecialty === 'Sleep medicine' ? 'active' : '' }}">Sleep medicine</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Respiratory therapy') }}" class="{{ $activeSpecialty === 'Respiratory therapy' ? 'active' : '' }}">Respiratory therapy</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Rheumatology') }}" class="{{ $activeSpecialty === 'Rheumatology' ? 'active' : '' }}">Rheumatology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Sports medicine') }}" class="{{ $activeSpecialty === 'Sports medicine' ? 'active' : '' }}">Sports medicine</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Surgery') }}" class="{{ $activeSpecialty === 'Surgery' ? 'active' : '' }}">Surgery</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Pediatric surgery') }}" class="{{ $activeSpecialty === 'Pediatric surgery' ? 'active' : '' }}">Pediatric surgery</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Colorectal surgery') }}" class="{{ $activeSpecialty === 'Colorectal surgery' ? 'active' : '' }}">Colorectal surgery</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Transplant surgery') }}" class="{{ $activeSpecialty === 'Transplant surgery' ? 'active' : '' }}">Transplant surgery</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Trauma surgery') }}" class="{{ $activeSpecialty === 'Trauma surgery' ? 'active' : '' }}">Trauma surgery</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Hepatobiliary and pancreatic surgery') }}" class="{{ $activeSpecialty === 'Hepatobiliary and pancreatic surgery' ? 'active' : '' }}">Hepatobiliary and pancreatic surgery</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Bariatric surgery') }}" class="{{ $activeSpecialty === 'Bariatric surgery' ? 'active' : '' }}">Bariatric surgery</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Cardiothoracic surgery') }}" class="{{ $activeSpecialty === 'Cardiothoracic surgery' ? 'active' : '' }}">Cardiothoracic surgery</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Neurosurgery') }}" class="{{ $activeSpecialty === 'Neurosurgery' ? 'active' : '' }}">Neurosurgery</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Plastic surgery') }}" class="{{ $activeSpecialty === 'Plastic surgery' ? 'active' : '' }}">Plastic surgery</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Traumatology') }}" class="{{ $activeSpecialty === 'Traumatology' ? 'active' : '' }}">Traumatology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Urology') }}" class="{{ $activeSpecialty === 'Urology' ? 'active' : '' }}">Urology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Andrology') }}" class="{{ $activeSpecialty === 'Andrology' ? 'active' : '' }}">Andrology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Epidemiology') }}" class="{{ $activeSpecialty === 'Epidemiology' ? 'active' : '' }}">Epidemiology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Nuclear medicine') }}" class="{{ $activeSpecialty === 'Nuclear medicine' ? 'active' : '' }}">Nuclear medicine</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Allergology') }}" class="{{ $activeSpecialty === 'Allergology' ? 'active' : '' }}">Allergology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Forensic medicine & deontology') }}" class="{{ $activeSpecialty === 'Forensic medicine & deontology' ? 'active' : '' }}">Forensic medicine & deontology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Vascular surgery') }}" class="{{ $activeSpecialty === 'Vascular surgery' ? 'active' : '' }}">Vascular surgery</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Cardiovascular surgery') }}" class="{{ $activeSpecialty === 'Cardiovascular surgery' ? 'active' : '' }}">Cardiovascular surgery</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Interventional cardiology') }}" class="{{ $activeSpecialty === 'Interventional cardiology' ? 'active' : '' }}">Interventional cardiology</a>
                                        <a href="{{ route('canva.listArticlesBySpecialty', 'Interventional neuroradiology') }}" class="{{ $activeSpecialty === 'Interventional neuroradiology' ? 'active' : '' }}">Interventional neuroradiology</a> --}}
                                    </div>
                                </div>
                            </div>
                        </aside><!-- .sidebar end -->
                        
                    @endif
                </div>
            </div>
        </div>
    </section><!-- #content end -->
@endsection


<script></script>
