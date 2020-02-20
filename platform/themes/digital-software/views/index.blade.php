<div class="row">
    {!! Theme::partial('left-side',['categories' => $categories['categories']]) !!}
    <div class="col-12 col-md-8 col-lg-7 px-0">
        <h4 class="mb-4 title-bar"> <i class="fa fa-folder-open-o" aria-hidden="true"></i> Featured Categories</h4>
        <div class="cat-item-wrapper d-none d-sm-none d-md-block">
            @if($featuredCat)
                <div class="row">
                    @foreach($featuredCat as $featured)
                        <div class="col-md-4">
                        <div class="cat-item1 bg-light">
                            <a href="{{route('public.list-cat', $featured->slug)}}">
                                <div class="icon bg-primary">
                                    <img src="https://www.premiumpress.com/_demoimages/softwaretheme/c1.jpg" class="img-fluid">
                                </div>
                                <div class="content bg-secondary">
                                    <h6 class="text-white font-weight-bold">{{$featured->name}}</h6>
                                    <span class="bg-danger text-white">{{$featured->softwares->count()}}</span>
                                </div>
                            </a>
                        </div>
                    </div>
                     @endforeach
                </div>
            @endif
        </div>
        <div class="wlt_sellspace home1"><a href="http://so9.wlthemes.com/advertising/?selladd=1&amp;ad=home1">
                <div class="sellspace_banner banner_700_90 text-center hidden-xs hidden-sm" style="width:700px; height:90px">
                    <div class="title">Advertise Here</div> <div class="pricing">view pricing</div>
                </div>
            </a></div>
        <h4 class="mb-4 title-bar"> <i class="fa fa-folder-open-o" aria-hidden="true"></i> All Categories</h4>
        @if($allCategories)
        <div class="cat-item-wrapper">
            <div class="row">
                @foreach($allCategories as $cat)
                    <div class="col-md-4 col-12">
                    <div class="cat-item2 bg-light">
                        <a href="{{route('public.list-cat', $cat->slug)}}">
                            <div class="content">
                                <h6 class="text-dark font-weight-bold">
                                    <span class="float-left">{{$cat->name}}</span>
                                    <span class="float-right countb bg-primary text-light px-2">{{$cat->softwares->count()}}</span>
                                </h6>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        <a href="http://so9.wlthemes.com/?s=" class="float-right mr-3 d-none d-sm-block btn-primary mt-2">View All <i class="fa fa-chevron-right ml-3" aria-hidden="true"></i></a>
        <h4 class="mb-4 title-bar"><i class="fa fa-check-square-o" aria-hidden="true"></i> Recently Added</h4>
        <div class="row">
            <div class="col-12">
                {!! Theme::partial('software-list',['softwares' => $softwares]) !!}
            </div>
        </div>
    </div>
    <aside class="sidebar-home col-12 col-md-4 col-lg-3">
        <h4 class="title-bar"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Top Downloads
        </h4>
        <div class="card mb-4 py-0">
            <div class="card-body py-1">
                <ul class="list-group list-group-flush top10 popular">
                    <li class="list-group-item px-0 py-2">
                        <div class="image">
                            <img src="https://www.premiumpress.com/_demoimages/softwaretheme/12.jpg"
                                 alt=""
                                 data-src="https://www.premiumpress.com/_demoimages/softwaretheme/12.jpg"
                                 class="wlt_image img-fluid"></div>
                        <div class="details mt-1">
                            <a href="http://so9.wlthemes.com/listing/sample-download-3/"
                               class="font-weight-bold">Sample Affiliate Link</a>
                        </div>
                        <p class="mb-0 mt-1 small">
                            1,066 views /

                            295 downloads
                        </p>
                    </li>
                    <li class="list-group-item px-0 py-2">
                        <div class="image">
                            <img src="https://www.premiumpress.com/_demoimages/softwaretheme/8.jpg"
                                 alt=""
                                 data-src="https://www.premiumpress.com/_demoimages/softwaretheme/8.jpg"
                                 class="wlt_image img-fluid"></div>
                        <div class="details mt-1">
                            <a href="http://so9.wlthemes.com/listing/early-detection-center/"
                               class="font-weight-bold">Early Detection Center</a>
                        </div>
                        <p class="mb-0 mt-1 small">
                            1,093 views /

                            226 downloads
                        </p>
                    </li>
                    <li class="list-group-item px-0 py-2">
                        <div class="image">
                            <img src="https://www.premiumpress.com/_demoimages/softwaretheme/14.jpg"
                                 alt=""
                                 data-src="https://www.premiumpress.com/_demoimages/softwaretheme/14.jpg"
                                 class="wlt_image img-fluid"></div>
                        <div class="details mt-1">
                            <a href="http://so9.wlthemes.com/listing/sample-download-5/"
                               class="font-weight-bold">Sample Download</a>
                        </div>
                        <p class="mb-0 mt-1 small">
                            1,208 views /

                            190 downloads
                        </p>
                    </li>
                    <li class="list-group-item px-0 py-2">
                        <div class="image">
                            <img src="https://www.premiumpress.com/_demoimages/softwaretheme/10.jpg"
                                 alt=""
                                 data-src="https://www.premiumpress.com/_demoimages/softwaretheme/10.jpg"
                                 class="wlt_image img-fluid"></div>
                        <div class="details mt-1">
                            <a href="http://so9.wlthemes.com/listing/sample-download/"
                               class="font-weight-bold">Sample Download</a>
                        </div>
                        <p class="mb-0 mt-1 small">
                            688 views /

                            135 downloads
                        </p>
                    </li>
                    <li class="list-group-item px-0 py-2">
                        <div class="image">
                            <img src="https://www.premiumpress.com/_demoimages/softwaretheme/13.jpg"
                                 alt=""
                                 data-src="https://www.premiumpress.com/_demoimages/softwaretheme/13.jpg"
                                 class="wlt_image img-fluid"></div>
                        <div class="details mt-1">
                            <a href="http://so9.wlthemes.com/listing/sample-download-4/"
                               class="font-weight-bold">Sample Download</a>
                        </div>
                        <p class="mb-0 mt-1 small">
                            577 views /

                            73 downloads
                        </p>
                    </li>
                    <li class="list-group-item px-0 py-2">
                        <div class="image">
                            <img src="https://www.premiumpress.com/_demoimages/softwaretheme/1.jpg"
                                 alt=""
                                 data-src="https://www.premiumpress.com/_demoimages/softwaretheme/1.jpg"
                                 class="wlt_image img-fluid"></div>
                        <div class="details mt-1">
                            <a href="http://so9.wlthemes.com/listing/bitdefender-antivirus-plus-2014/"
                               class="font-weight-bold">Bitdefender Antivirus Plus 2014</a>
                        </div>
                        <p class="mb-0 mt-1 small">
                            267 views /

                            37 downloads
                        </p>
                    </li>
                    <li class="list-group-item px-0 py-2">
                        <div class="image">
                            <img src="https://www.premiumpress.com/_demoimages/softwaretheme/11.jpg"
                                 alt=""
                                 data-src="https://www.premiumpress.com/_demoimages/softwaretheme/11.jpg"
                                 class="wlt_image img-fluid"></div>
                        <div class="details mt-1">
                            <a href="http://so9.wlthemes.com/listing/sample-download-2/"
                               class="font-weight-bold">Sample Download</a>
                        </div>
                        <p class="mb-0 mt-1 small">
                            404 views /

                            36 downloads
                        </p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="wlt_sellspace sidebar270a"><a
                href="http://so9.wlthemes.com/advertising/?selladd=1&amp;ad=sidebar270a">
                <div class="sellspace_banner banner_270_200 text-center hidden-xs hidden-sm"
                     style="width:270px; height:200px">
                    <div class="title">Advertise Here</div>
                    <div class="pricing">view pricing</div>
                </div>
            </a></div>
        <h4 class="title-bar"><i class="fa fa-cloud-download" aria-hidden="true"></i> Featured
            Downloads</h4>
        <div class="card mb-4 py-0">
            <div class="card-body py-1">
                <ul class="list-group list-group-flush top10">
                    <li class="list-group-item px-0 py-3">
                        <div class="image">
                            <img src="https://www.premiumpress.com/_demoimages/softwaretheme/8.jpg"
                                 alt=""
                                 data-src="https://www.premiumpress.com/_demoimages/softwaretheme/8.jpg"
                                 class="wlt_image img-fluid"></div>
                        <div class="details">
                            <a href="http://so9.wlthemes.com/listing/early-detection-center/"
                               class="mt-0">Early Detection Center</a>
                        </div>
                        <p class="mb-0 small">1,093 views /

                            226 downloads</p>
                    </li>
                    <li class="list-group-item px-0 py-3">
                        <div class="image">
                            <img src="https://www.premiumpress.com/_demoimages/softwaretheme/10.jpg"
                                 alt=""
                                 data-src="https://www.premiumpress.com/_demoimages/softwaretheme/10.jpg"
                                 class="wlt_image img-fluid"></div>
                        <div class="details">
                            <a href="http://so9.wlthemes.com/listing/sample-download/" class="mt-0">Sample
                                Download</a>
                        </div>
                        <p class="mb-0 small">688 views /

                            135 downloads</p>
                    </li>
                    <li class="list-group-item px-0 py-3">
                        <div class="image">
                            <img src="https://www.premiumpress.com/_demoimages/softwaretheme/11.jpg"
                                 alt=""
                                 data-src="https://www.premiumpress.com/_demoimages/softwaretheme/11.jpg"
                                 class="wlt_image img-fluid"></div>
                        <div class="details">
                            <a href="http://so9.wlthemes.com/listing/sample-download-2/"
                               class="mt-0">Sample Download</a>
                        </div>
                        <p class="mb-0 small">404 views /

                            36 downloads</p>
                    </li>
                    <li class="list-group-item px-0 py-3">
                        <div class="image">
                            <img src="https://www.premiumpress.com/_demoimages/softwaretheme/14.jpg"
                                 alt=""
                                 data-src="https://www.premiumpress.com/_demoimages/softwaretheme/14.jpg"
                                 class="wlt_image img-fluid"></div>
                        <div class="details">
                            <a href="http://so9.wlthemes.com/listing/sample-download-5/"
                               class="mt-0">Sample Download</a>
                        </div>
                        <p class="mb-0 small">1,208 views /

                            190 downloads</p>
                    </li>
                    <li class="list-group-item px-0 py-3">
                        <div class="image">
                            <img src="https://www.premiumpress.com/_demoimages/softwaretheme/2.jpg"
                                 alt=""
                                 data-src="https://www.premiumpress.com/_demoimages/softwaretheme/2.jpg"
                                 class="wlt_image img-fluid"></div>
                        <div class="details">
                            <a href="http://so9.wlthemes.com/listing/kaspersky-anti-virus/"
                               class="mt-0">Kaspersky Anti-Virus</a>
                        </div>
                        <p class="mb-0 small">267 views /

                            11 downloads</p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="wlt_sellspace sidebar270b"><a
                href="http://so9.wlthemes.com/advertising/?selladd=1&amp;ad=sidebar270b">
                <div class="sellspace_banner banner_270_200 text-center hidden-xs hidden-sm"
                     style="width:270px; height:200px">
                    <div class="title">Advertise Here</div>
                    <div class="pricing">view pricing</div>
                </div>
            </a></div>
        <h4 class="title-bar"><i class="fa fa-bookmark-o" aria-hidden="true"></i> New Downloads</h4>
        <div class="card mb-4 py-0">
            <div class="card-body py-1">
                <ul class="list-group list-group-flush top10">
                    <li class="list-group-item px-0 py-3">
                        <div class="image">
                            <img
                                src="http://so9.wlthemes.com/wp-content/uploads/sites/67/2019/12/johari-300x169.png"
                                alt="johari.png"
                                data-src="http://so9.wlthemes.com/wp-content/uploads/sites/67/2019/12/johari-300x169.png"
                                class="wlt_image img-fluid"></div>
                        <div class="details">
                            <a href="http://so9.wlthemes.com/listing/ebook/" class="mt-0">ebook</a>
                        </div>
                        <p class="mb-0 small">109 views /

                            12 downloads</p>
                    </li>
                    <li class="list-group-item px-0 py-3">
                        <div class="image">
                            <img src="https://www.premiumpress.com/_demoimages/softwaretheme/14.jpg"
                                 alt=""
                                 data-src="https://www.premiumpress.com/_demoimages/softwaretheme/14.jpg"
                                 class="wlt_image img-fluid"></div>
                        <div class="details">
                            <a href="http://so9.wlthemes.com/listing/sample-download-5/"
                               class="mt-0">Sample Download</a>
                        </div>
                        <p class="mb-0 small">1,208 views /

                            190 downloads</p>
                    </li>
                    <li class="list-group-item px-0 py-3">
                        <div class="image">
                            <img src="https://www.premiumpress.com/_demoimages/softwaretheme/13.jpg"
                                 alt=""
                                 data-src="https://www.premiumpress.com/_demoimages/softwaretheme/13.jpg"
                                 class="wlt_image img-fluid"></div>
                        <div class="details">
                            <a href="http://so9.wlthemes.com/listing/sample-download-4/"
                               class="mt-0">Sample Download</a>
                        </div>
                        <p class="mb-0 small">577 views /

                            73 downloads</p>
                    </li>
                    <li class="list-group-item px-0 py-3">
                        <div class="image">
                            <img src="https://www.premiumpress.com/_demoimages/softwaretheme/12.jpg"
                                 alt=""
                                 data-src="https://www.premiumpress.com/_demoimages/softwaretheme/12.jpg"
                                 class="wlt_image img-fluid"></div>
                        <div class="details">
                            <a href="http://so9.wlthemes.com/listing/sample-download-3/"
                               class="mt-0">Sample Affiliate Link</a>
                        </div>
                        <p class="mb-0 small">1,066 views /

                            295 downloads</p>
                    </li>
                    <li class="list-group-item px-0 py-3">
                        <div class="image">
                            <img src="https://www.premiumpress.com/_demoimages/softwaretheme/11.jpg"
                                 alt=""
                                 data-src="https://www.premiumpress.com/_demoimages/softwaretheme/11.jpg"
                                 class="wlt_image img-fluid"></div>
                        <div class="details">
                            <a href="http://so9.wlthemes.com/listing/sample-download-2/"
                               class="mt-0">Sample Download</a>
                        </div>
                        <p class="mb-0 small">404 views /

                            36 downloads</p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="wlt_sellspace sidebar270c"><a
                href="http://so9.wlthemes.com/advertising/?selladd=1&amp;ad=sidebar270c">
                <div class="sellspace_banner banner_270_200 text-center hidden-xs hidden-sm"
                     style="width:270px; height:200px">
                    <div class="title">Advertise Here</div>
                    <div class="pricing">view pricing</div>
                </div>
            </a></div>
        <h4 class="mb-4 mt-3 title-bar"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Latest
            News</h4>
        <div class="card mb-4">
            <div class="card-body px-2 py-1">
                <ul class="list-group list-group-flush top10 blog">
                    <li class="list-group-item px-0 py-3">

                        <a href="http://so9.wlthemes.com/2019/02/05/example-blog-post-8/">
                            <div class="image">
                                <img src="https://www.premiumpress.com/_demoimages/blog/blog8.jpg"
                                     alt=""
                                     data-src="https://www.premiumpress.com/_demoimages/blog/blog8.jpg"
                                     class="wlt_image img-fluid">
                            </div>
                            <div class="content">
                                <h6>Example Blog Post</h6>
                                <p class="recent-post-sm-meta mb-0"><i
                                        class="fa fa-clock-o mr-1"></i> February 5, 2019</p>
                            </div>
                        </a>

                    </li>
                    <li class="list-group-item px-0 py-3">

                        <a href="http://so9.wlthemes.com/2019/02/05/example-blog-post-7/">
                            <div class="image">
                                <img src="https://www.premiumpress.com/_demoimages/blog/blog7.jpg"
                                     alt=""
                                     data-src="https://www.premiumpress.com/_demoimages/blog/blog7.jpg"
                                     class="wlt_image img-fluid">
                            </div>
                            <div class="content">
                                <h6>Example Blog Post</h6>
                                <p class="recent-post-sm-meta mb-0"><i
                                        class="fa fa-clock-o mr-1"></i> February 5, 2019</p>
                            </div>
                        </a>

                    </li>
                    <li class="list-group-item px-0 py-3">

                        <a href="http://so9.wlthemes.com/2019/02/05/example-blog-post-6/">
                            <div class="image">
                                <img src="https://www.premiumpress.com/_demoimages/blog/blog6.jpg"
                                     alt=""
                                     data-src="https://www.premiumpress.com/_demoimages/blog/blog6.jpg"
                                     class="wlt_image img-fluid">
                            </div>
                            <div class="content">
                                <h6>Example Blog Post</h6>
                                <p class="recent-post-sm-meta mb-0"><i
                                        class="fa fa-clock-o mr-1"></i> February 5, 2019</p>
                            </div>
                        </a>

                    </li>

                </ul>
            </div>
        </div>

    </aside>
</div>
