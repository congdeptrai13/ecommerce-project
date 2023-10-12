<section id="wsus__banner">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="wsus__banner_content">
                    <div class="row banner_slider">
                        @foreach ($sliders as $item)
                            <div class="col-xl-12">
                                <div class="wsus__single_slider" style="background: url({{ $item->banner }});">
                                    <div class="wsus__single_slider_text">
                                        <h3>{{ $item->type }}</h3>
                                        <h1>{{ $item->title }}</h1>
                                        <h6>start at ${{ $item->starting_price }}</h6>
                                        <a class="common_btn" href="{{ $item->btn_url }}">shop now</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
