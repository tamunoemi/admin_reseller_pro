@extends('teckiproadmin::site.layouts.app')

@section('title', __('Home'))

@section('nav')

@include('teckiproadmin::includes.partials.logged-in-as')
@include('teckiproadmin::includes.partials.announcements')

@include('teckiproadmin::site.layouts.nav')


@endsection

@section('content')

<section class="py-0" id="home">
    <div class="bg-holder" style="background-image:url(assets/img/illustrations/hero-bg.png);background-position:bottom;background-size:cover;">
    </div>
    <!--/.bg-holder-->

    <div class="container position-relative">
      <div class="row align-items-center py-8">
        <div class="col-md-5 col-lg-6 order-md-1 text-center text-md-end"><img class="img-fluid" src="{{ asset('vendor/plans/assets/img/illustrations/mobile.png')  }} " width="350" alt="" /></div>
        <div class="col-md-7 col-lg-6 text-center text-md-start"><span class="badge bg-light rounded-pill text-dark align-items-center d-flex flex-row-reverse justify-content-end mx-auto mx-md-0 ps-0 w-75 w-sm-50 w-md-75 w-xl-50 mb-3">#1 Editiors Choice App of 2020<img class="img-fluid float-start me-3" src="{{ asset('vendor/plans/assets/img/illustrations/arrow-right.png')  }} " alt=""/></span>
          <h1 class="mb-4 display-3 fw-bold lh-sm">Best app for your <br class="d-block d-lg-none d-xl-block" />modern lifestyle</h1>
          <p class="mt-3 mb-4 fs-1">Increase productivity with a simple to-do app. app for <br class="d-none d-lg-block" />managing your personal budgets.</p><a class="btn btn-lg btn-primary rounded-pill hover-top" href="#" role="button">Try for free</a><a class="btn btn-link ps-md-4" href="#" role="button"> Watch demo video</a>
        </div>
      </div>
    </div>
  </section>


  <!-- ============================================-->
  <!-- <section> begin ============================-->
  <section class="py-7">

    <div class="container">
      <div class="row">
        <div class="col-12 mx-auto align-items-center text-center">
          <p class="mb-4">Trusted by companies like</p>
        </div>
      </div>
      <div class="row align-items-center justify-content-center justify-content-lg-around">
        <div class="col-6 col-sm-4 col-md-4 col-lg-2 px-md-0 mb-5 mb-lg-0 text-center"><img src="{{ asset('vendor/plans/assets/img/gallery/company-1.png')  }} " alt="" /></div>
        <div class="col-6 col-sm-4 col-md-4 col-lg-2 px-md-0 mb-5 mb-lg-0 text-center"><img src="{{ asset('vendor/plans/assets/img/gallery/company-2.png')  }} " alt="" /></div>
        <div class="col-6 col-sm-4 col-md-4 col-lg-2 px-md-0 mb-5 mb-lg-0 text-center"><img src="{{ asset('vendor/plans/assets/img/gallery/company-3.png')  }} " alt="" /></div>
        <div class="col-6 col-sm-4 col-md-4 col-lg-2 px-md-0 mb-5 mb-lg-0 text-center"><img src="{{ asset('vendor/plans/assets/img/gallery/company-4.png')  }} " alt="" /></div>
        <div class="col-6 col-sm-4 col-md-4 col-lg-2 px-md-0 mb-5 mb-lg-0 text-center"><img src="{{ asset('vendor/plans/assets/img/gallery/company-1.png')  }} " alt="" /></div>
      </div>
    </div>
    <!-- end of .container-->

  </section>
  <!-- <section> close ============================-->
  <!-- ============================================-->


  <section class="py-5" id="features">
    <div class="container-lg">
      <div class="row align-items-center">
        <div class="col-md-5 col-lg-6 order-md-0 text-center text-md-start"><img class="img-fluid" src="{{ asset('vendor/plans/assets/img/illustrations/feature-bg.png')  }} " width="550" alt="" /></div>
        <div class="col-md-7 col-lg-6 px-sm-5 px-md-0">
          <h6 class="fw-bold fs-4 display-3 lh-sm">Awesome apps <br />features</h6>
          <p class="my-4">Increase productivity with a simple to-do app. app for <br class="d-none d-xl-block" />managing your personal budgets.</p>
          <div class="d-flex align-items-center mb-5">
            <div><img class="img-fluid" src="{{ asset('vendor/plans/assets/img/illustrations/fast-performance.png')  }} " width="90" alt="" /></div>
            <div class="px-4">
              <h5 class="fw-bold text-danger">Fast performance</h5>
              <p>Get your blood tests delivered at <br class="d-none d-xl-block"> home collect a sample from the <br class="d-none d-xl-block"> news your blood tests</p>
            </div>
          </div>
          <div class="d-flex align-items-center mb-5">
            <div><img class="img-fluid" src="{{ asset('vendor/plans/assets/img/illustrations/prototype.png')  }} " width="90" alt="" /></div>
            <div class="px-4">
              <h5 class="fw-bold text-primary">Prototyping</h5>
              <p>Get your blood tests delivered at <br class="d-none d-xl-block"> home collect a sample from the <br class="d-none d-xl-block"> news your blood tests</p>
            </div>
          </div>
          <div class="d-flex align-items-center mb-5">
            <div><img class="img-fluid" src="{{ asset('vendor/plans/assets/img/illustrations/vector.png')  }} " width="90" alt="" /></div>
            <div class="px-4">
              <h5 class="fw-bold text-success">Vector Editing</h5>
              <p>Get your blood tests delivered at <br class="d-none d-xl-block"> home collect a sample from the <br class="d-none d-xl-block"> news your blood tests</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ============================================-->
  <!-- <section> begin ============================-->
  <section class="py-5">

    <div class="container">
      <div class="row align-items-center mb-6">
        <div class="col-md-5 col-lg-4 offset-lg-1">
          <h1 class="fw-bold lh-base">Smart jackpots that you may love this anytime &amp; anywhere</h1>
        </div>
        <div class="col-md-6 col-lg-5 offset-lg-1 border-start py-5 ps-5">
          <p class="mb-0">The rise of mobile devices transforms the way we consume information entirely and the world's most elevant channels such as Facebook.</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 col-lg-3 offset-lg-1 mb-4">
          <div class="py-4"><img class="img-fluid" src="{{ asset('vendor/plans/assets/img/illustrations/automatic.png')  }} " width="90" alt="" /></div>
          <h5 class="fw-bold text-danger">Fast performance</h5>
          <p class="mt-2 mb-0">Get your blood tests delivered at home collect a sample from the news your blood tests.</p>
        </div>
        <div class="col-md-4 col-lg-3 offset-lg-1 mb-4">
          <div class="py-4"><img class="img-fluid" src="{{ asset('vendor/plans/assets/img/illustrations/network.png')  }} " width="90" alt="" /></div>
          <h5 class="fw-bold text-primary">Prototyping</h5>
          <p class="mt-2 mb-0">Get your blood tests delivered at home collect a sample from the news your blood tests.</p>
        </div>
        <div class="col-md-4 col-lg-3 offset-lg-1 mb-4">
          <div class="py-4"><img class="img-fluid" src="{{ asset('vendor/plans/assets/img/illustrations/rewards.png')  }} " width="90" alt="" /></div>
          <h5 class="fw-bold text-success">Vector Editing</h5>
          <p class="mt-2 mb-0">Get your blood tests delivered at home collect a sample from the news your blood tests.</p>
        </div>
      </div>
    </div>
    <!-- end of .container-->

  </section>
  <!-- <section> close ============================-->
  <!-- ============================================-->




  <!-- ============================================-->
  <!-- <section> begin ============================-->
  <section class="py-6">

    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-5 order-md-0 text-center text-md-start"><img class="img-fluid mb-4" src="{{ asset('vendor/plans/assets/img/illustrations/call-to-action.png')  }} " width="550" alt="" /></div>
        <div class="col-md-6 text-center text-md-start offset-md-1">
          <h6 class="fw-bold fs-4 display-3 lh-sm">Designed &amp; built by<br />the latest code <br />integration</h6>
          <p class="my-4 pe-xl-5"> The rise of mobile devices transforms the way we consume information entirely and the world's most elevant channels such as Facebook.</p><a class="btn btn-lg btn-primary rounded-pill hover-top" href="#" role="button">Learn more</a>
        </div>
      </div>
    </div>
    <!-- end of .container-->

  </section>
  <!-- <section> close ============================-->
  <!-- ============================================-->




  <!-- ============================================-->
  <!-- <section> begin ============================-->
  <section class="py-6">

    <div class="container">
      <div class="row justify-content-center mb-6">
        <div class="col-lg-6 text-center mx-auto mb-3 mb-md-5 mt-4">
          <h6 class="fw-bold fs-4 display-3 lh-sm">Why you should choose <br />our app </h6>
          <p class="mb-0">The rise of mobile devices transforms the way we consume information entirely and the world's most elevant channels such as Facebook.</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 mb-6">
          <div class="text-center px-lg-3"><img class="img-fluid mb-3" src="{{ asset('vendor/plans/assets/img/illustrations/app.png')  }} " width="90" alt="" />
            <h5 class="fw-bold">App Development</h5>
            <p class="mb-md-0">Get your blood tests delivered at home collect a sample from the news your blood tests.</p>
          </div>
        </div>
        <div class="col-md-4 mb-6">
          <div class="text-center px-lg-3"><img class="img-fluid mb-3" src="{{ asset('vendor/plans/assets/img/illustrations/time-award .png')  }} "width="90" alt="" />
            <h5 class="fw-bold">10 Times Award</h5>
            <p class="mb-md-0">Get your blood tests delivered at home collect a sample from the news your blood tests.</p>
          </div>
        </div>
        <div class="col-md-4 mb-6">
          <div class="text-center px-lg-3"><img class="img-fluid mb-3" src="{{ asset('vendor/plans/assets/img/illustrations/cloud.png')  }} " width="90" alt="" />
            <h5 class="fw-bold">Cloud Storage</h5>
            <p class="mb-md-0">Get your blood tests delivered at home collect a sample from the news your blood tests.</p>
          </div>
        </div>
        <div class="col-md-4 mb-6">
          <div class="text-center px-lg-3"><img class="img-fluid mb-3" src="{{ asset('vendor/plans/assets/img/illustrations/customization.png')  }} " width="90" alt="" />
            <h5 class="fw-bold">Customization</h5>
            <p class="mb-md-0">Get your blood tests delivered at home collect a sample from the news your blood tests.</p>
          </div>
        </div>
        <div class="col-md-4 mb-6">
          <div class="text-center px-lg-3"><img class="img-fluid mb-3" src="{{ asset('vendor/plans/assets/img/illustrations/ux.png')  }} " width="90" alt="" />
            <h5 class="fw-bold">UX Planning</h5>
            <p class="mb-md-0">Get your blood tests delivered at home collect a sample from the news your blood tests.</p>
          </div>
        </div>
        <div class="col-md-4 mb-6">
          <div class="text-center px-lg-3"><img class="img-fluid mb-3" src="{{ asset('vendor/plans/assets/img/illustrations/support.png')  }} " width="90" alt="" />
            <h5 class="fw-bold">Customer Support</h5>
            <p class="mb-md-0">Get your blood tests delivered at home collect a sample from the news your blood tests.</p>
          </div>
        </div>
      </div>
    </div>
    <!-- end of .container-->

  </section>
  <!-- <section> close ============================-->
  <!-- ============================================-->




  <!-- ============================================-->
  <!-- <section> begin ============================-->
  <section class="py-6">

    <div class="container">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-5 order-md-1 text-center text-md-start"><img class="img-fluid mb-4" src="{{ asset('vendor/plans/assets/img/illustrations/ultimate-feature.png')  }} " alt="" /></div>
          <div class="col-md-6 text-center text-md-start">
            <h6 class="fw-bold fs-4 display-3 lh-sm">Ultimate features<br />that we built</h6>
            <p class="my-4 pe-xl-5"> The rise of mobile devices transforms the way we consume information entirely.</p>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-4">
                  <div class="py-4"><img class="img-fluid" src="{{ asset('vendor/plans/assets/img/illustrations/app.png')  }} " width="90" alt="" /></div>
                  <h5 class="fw-bold text-undefined">App Development</h5>
                  <p class="mt-2 mb-0">Get your blood tests delivered at home collect a sample from the news your blood tests.</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <div class="py-4"><img class="img-fluid" src="{{ asset('vendor/plans/assets/img/illustrations/ux.png')  }} " width="90" alt="" /></div>
                  <h5 class="fw-bold text-undefined">UX Planning</h5>
                  <p class="mt-2 mb-0">Get your blood tests delivered at home collect a sample from the news your blood tests.</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <div class="py-4"><img class="img-fluid" src="{{ asset('vendor/plans/assets/img/illustrations/cloud.png')  }} " width="90" alt="" /></div>
                  <h5 class="fw-bold text-undefined">Cloud Storage</h5>
                  <p class="mt-2 mb-0">Get your blood tests delivered at home collect a sample from the news your blood tests.</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <div class="py-4"><img class="img-fluid" src="{{ asset('vendor/plans/assets/img/illustrations/support.png')  }} " width="90" alt="" /></div>
                  <h5 class="fw-bold text-undefined">Customer support</h5>
                  <p class="mt-2 mb-0">Get your blood tests delivered at home collect a sample from the news your blood tests.</p>
                </div>
              </div>
            </div><a class="btn btn-lg btn-primary rounded-pill hover-top" href="#" role="button">See all</a>
          </div>
        </div>
      </div>
    </div>
    <!-- end of .container-->

  </section>
  <!-- <section> close ============================-->
  <!-- ============================================-->




  <!-- ============================================-->
  <!-- <section> begin ============================-->
  <section class="py-8" id="pricing">

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xxl-5 text-center mb-3">
          <h6 class="fw-bold fs-4 display-3 lh-sm mb-3">Get awesome features, without extra charges</h6>
          <p class="mb-4">The rise of mobile devices transforms the way we consume information entirely and the world's most elevant channels such as Facebook.</p>
        </div>
      </div>
      <div class="row flex-center">
        <div class="col-12 mb-3">
          <div class="d-flex justify-content-center">
            <label class="form-check-label me-2" for="customSwitch1">Monthly</label>
            <div class="form-check form-switch">
              <input class="form-check-input" id="customSwitch1" type="checkbox" checked="checked" />
              <label class="form-check-label align-top" for="customSwitch1">Yearly</label>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card shadow-lg mb-4 border-0">
            <div class="card-header border-bottom-0 pt-7 pb-5">
              <div class="d-flex justify-content-center">
                <h1 class="fw-bold">$0</h1><span class="d-flex align-items-center">/month</span>
              </div>
              <h5 class="fw-bold text-center">Business Class</h5><span class="text-700 text-center d-block">For small teams or office</span>
            </div>
            <div class="card-body mx-auto">
              <ul class="list-unstyled mb-4">
                <li class="text-700 py-2 text-secondary">Darg &amp; Drop Builder</li>
                <li class="text-700 py-2 text-secondary">1,000's of Templates</li>
                <li class="text-700 py-2 text-secondary">Blog Support Tools</li>
                <li class="text-700 py-2 text-secondary">eCommerce Store </li>
              </ul><a class="btn btn-lg btn-primary rounded-pill mb-3" href="#">Start free trial</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card shadow-lg mb-4">
            <div class="card-header border-bottom-0 pt-7 pb-5">
              <div class="d-flex justify-content-center">
                <h1 class="fw-bold">$99</h1><span class="d-flex align-items-center">/month</span>
              </div>
              <h5 class="fw-bold text-center">Pro Master</h5><span class="text-700 text-center d-block">For small teams or office</span>
            </div>
            <div class="card-body mx-auto">
              <ul class="list-unstyled mb-4">
                <li class="text-700 py-2 text-secondary">Darg &amp; Drop Builder</li>
                <li class="text-700 py-2 text-secondary">1,000's of Templates</li>
                <li class="text-700 py-2 text-secondary">Blog Support Tools</li>
                <li class="text-700 py-2 text-secondary">eCommerce Store </li>
              </ul>
              <div class="d-flex flex-column"> <a class="btn btn-lg btn-primary rounded-pill mb-3" href="#">Start free trial</a><a href="#">Or Start 14 days trail</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end of .container-->

  </section>
  <!-- <section> close ============================-->
  <!-- ============================================-->


  <section class="py-8" id="testimonial">
    <div class="container-lg">
      <div class="row flex-center">
        <div class="col-sm-10 col-md-5 col-lg-5 order-md-0 text-center text-md-start"><img class="img-fluid mb-4" src="{{ asset('vendor/plans/assets/img/illustrations/testimonial.png')  }} " alt="" /></div>
        <div class="col-sm-10 col-md-6 col-lg-6 text-center text-md-start offset-md-1">
          <h6 class="fw-bold fs-4 display-3 lh-sm"> Meet Client Satisfaction <br />by using product</h6>
          <p class="my-4 pe-xl-5"> The rise of mobile devices transforms the way we consume.Elevant channels such as Facebook.</p>
          <div class="carousel slide" id="carouselExampleDark" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active" data-bs-interval="10000">
                <div class="row h-100">
                  <div class="col-12">
                    <svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFCC00" viewBox="0 0 16 16">
                      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                    </svg>
                    <svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFCC00" viewBox="0 0 16 16">
                      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                    </svg>
                    <svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFCC00" viewBox="0 0 16 16">
                      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                    </svg>
                    <svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFCC00" viewBox="0 0 16 16">
                      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                    </svg>
                    <svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFCC00" viewBox="0 0 16 16">
                      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                    </svg>
                    <h5 class="my-4 fw-bold lh-sm">User friendly &amp; Customizable</h5>
                    <p class="mb-0 text-center text-md-start">Bring to the table win-win survival strategies to ensure proactive domination. At the end of the day, going forward, a new normal that has evolved from generation X is on the runway heading towards a streamlined cloud solution. User generated content in real-time will have multiple touchpoints for offshoring.</p>
                  </div>
                  <div class="col-xl-6 pt-4 d-flex d-sm-block flex-center">
                    <div class="d-flex align-items-md-center"><img class="img-fluid me-4 me-md-3 me-lg-4" src="{{ asset('vendor/plans/assets/img/gallery/user.png')  }} " width="100" alt="" />
                      <div class="w-lg-50 my-3">
                        <h5 class="mb-0 fw-bold">Zoltan Nemeth</h5>
                        <p class="fw-normal mb-0">CEO of Pixer Lab</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="carousel-item" data-bs-interval="2000">
                <div class="row h-100">
                  <div class="col-12">
                    <svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFCC00" viewBox="0 0 16 16">
                      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                    </svg>
                    <svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFCC00" viewBox="0 0 16 16">
                      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                    </svg>
                    <svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFCC00" viewBox="0 0 16 16">
                      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                    </svg>
                    <svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFCC00" viewBox="0 0 16 16">
                      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                    </svg>
                    <svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFCC00" viewBox="0 0 16 16">
                      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                    </svg>
                    <h5 class="my-4 fw-bold lh-sm">User friendly &amp; Customizable</h5>
                    <p class="mb-0 text-center text-md-start">Bring to the table win-win survival strategies to ensure proactive domination. At the end of the day, going forward, a new normal that has evolved from generation X is on the runway heading towards a streamlined cloud solution. User generated content in real-time will have multiple touchpoints for offshoring.</p>
                  </div>
                  <div class="col-xl-6 pt-4 d-flex d-sm-block flex-center">
                    <div class="d-flex align-items-md-center"><img class="img-fluid me-4 me-md-3 me-lg-4" src="{{ asset('vendor/plans/assets/img/gallery/user-1.png')  }} " width="100" alt="" />
                      <div class="w-lg-50 my-3">
                        <h5 class="mb-0 fw-bold">Jhon Doe</h5>
                        <p class="fw-normal mb-0">Web Developer</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="carousel-item">
                <div class="row h-100">
                  <div class="col-12">
                    <svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFCC00" viewBox="0 0 16 16">
                      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                    </svg>
                    <svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFCC00" viewBox="0 0 16 16">
                      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                    </svg>
                    <svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFCC00" viewBox="0 0 16 16">
                      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                    </svg>
                    <svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFCC00" viewBox="0 0 16 16">
                      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                    </svg>
                    <svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFCC00" viewBox="0 0 16 16">
                      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                    </svg>
                    <h5 class="my-4 fw-bold lh-sm">User friendly &amp; Customizable</h5>
                    <p class="mb-0 text-center text-md-start">Bring to the table win-win survival strategies to ensure proactive domination. At the end of the day, going forward, a new normal that has evolved from generation X is on the runway heading towards a streamlined cloud solution. User generated content in real-time will have multiple touchpoints for offshoring.</p>
                  </div>
                  <div class="col-xl-6 pt-4 d-flex d-sm-block flex-center">
                    <div class="d-flex align-items-md-center"><img class="img-fluid me-4 me-md-3 me-lg-4" src="{{ asset('vendor/plans/assets/img/gallery/user-2.png')  }} " width="100" alt="" />
                      <div class="w-lg-50 my-3">
                        <h5 class="mb-0 fw-bold">Viezh Robert</h5>
                        <p class="fw-normal mb-0">UI/UX Designer</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="position-relative mt-sm-n5"><a class="carousel-control-prev carousel-icon z-index-2" href="#carouselExampleDark" role="button" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></a><a class="carousel-control-next carousel-icon z-index-2" href="#carouselExampleDark" role="button" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></a></div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ============================================-->
  <!-- <section> begin ============================-->
  <section class="py-8" id="faq">

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 text-center mb-3">
          <h6 class="fw-bold fs-4 display-3 lh-sm mb-3">Frequently asked questions</h6>
          <p class="mb-5">The rise of mobile devices transforms the way we consume information entirely and the world's most elevant channels such as Facebook.</p>
        </div>
      </div>
      <div class="row flex-center">
        <div class="col-lg-9">
          <div class="accordion" id="accordionExample">
            <div class="accordion-item mb-2">
              <h2 class="accordion-header" id="heading1">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1"><span class="mb-0 fw-bold text-start fs-1 text-1000">How to contact with riders emergency?</span></button>
              </h2>
              <div class="accordion-collapse collapse show" id="collapse1" aria-labelledby="heading1" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-100">Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment.Bring to the table win-win survival strategies to ensure proactive domination. At the end of the day, going forward, a new normal that has evolved from generation X is on the runway heading towards a streamlined cloud solution. User generated content in real-time will have multiple touchpoints for offshoring.</div>
              </div>
            </div>
            <div class="accordion-item mb-2">
              <h2 class="accordion-header" id="heading2">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="true" aria-controls="collapse2"><span class="mb-0 fw-bold text-start fs-1 text-1000">App installation failed, how to update system information?</span></button>
              </h2>
              <div class="accordion-collapse collapse" id="collapse2" aria-labelledby="heading2" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-100">You can issue either partial or full refunds. There are no fees to refund a charge, but the fees from the original charge are not returned.</div>
              </div>
            </div>
            <div class="accordion-item mb-2">
              <h2 class="accordion-header" id="heading3">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="true" aria-controls="collapse3"><span class="mb-0 fw-bold text-start fs-1 text-1000">Website reponse taking time, how to improve?</span></button>
              </h2>
              <div class="accordion-collapse collapse" id="collapse3" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-100">Disputed payments (also known as chargebacks) incur a $15.00 fee. If the customer’s bank resolves the dispute in your favor, the fee is fully refunded.</div>
              </div>
            </div>
            <div class="accordion-item mb-2">
              <h2 class="accordion-header" id="heading4">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="true" aria-controls="collapse4"><span class="mb-0 fw-bold text-start fs-1 text-1000">New update fixed all bug and issues</span></button>
              </h2>
              <div class="accordion-collapse collapse" id="collapse4" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-100">There are no additional fees for using our mobile SDKs or to accept payments using consumer wallets like Apple Pay or Google Pay.</div>
              </div>
            </div>
            <div class="accordion-item mb-2">
              <h2 class="accordion-header" id="heading5">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="true" aria-controls="collapse5"><span class="mb-0 fw-bold text-start fs-1 text-1000">How to contact with riders emergency?</span></button>
              </h2>
              <div class="accordion-collapse collapse" id="collapse5" aria-labelledby="heading5" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-100">There are no additional fees for using our mobile SDKs or to accept payments using consumer wallets like Apple Pay or Google Pay.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end of .container-->

  </section>
  <!-- <section> close ============================-->
  <!-- ============================================-->


  <section class="py-6">
    <hr />
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-5 col-lg-7 order-md-1 text-center text-md-start z-index-2 cta-image"><img class="img-fluid mb-4 mb-md-0" src="{{ asset('vendor/plans/assets/img/illustrations/cta.png')  }} " width="850" alt="" /></div>
        <div class="col-md-7 col-lg-5 text-center text-md-start">
          <h1 class="display-3 fw-bold lh-sm">Download our App now</h1>
          <p class="my-4"> The rise of mobile devices transforms the way we consume information entirely and the world's most elevant channels such as Facebook.</p>
          <div class="d-flex justify-content-center d-md-inline-block"><a class="pe-2 pe-sm-3 pe-md-4" href="!#"><img src="{{ asset('vendor/plans/assets/img/illustrations/google-play.png')  }} " width="160" alt="" /></a><a href="!#"><img src="{{ asset('vendor/plans/assets/img/illustrations/app-store.png')  }} " width="160" alt="" /></a></div>
        </div>
      </div>
    </div>
  </section>

@endsection
