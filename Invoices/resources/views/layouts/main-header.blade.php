<!-- main-header opened -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">
        <div class="main-header-left ">
            <div class="responsive-logo">
                < </div>
                    <div class="app-sidebar__toggle" data-toggle="sidebar">
                        <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                        <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
                    </div>

            </div>
            <div class="main-header-right">
                <ul class="nav">
                    <li class="">
                        <div class="dropdown  nav-itemd-none d-md-flex">
                            <a href="#" class="d-flex  nav-item nav-link pl-0 country-flag1"
                                data-toggle="dropdown" aria-expanded="false">
                                @if (App::getLocale() == 'ar')
                                    <span class="avatar country-Flag mr-0 align-self-center bg-transparent"><img
                                            src="{{ URL::asset('assets/img/flags/egypt_flag.jpg') }}"
                                            alt="img"></span>
                                    <strong
                                        class="mr-2 ml-2 my-auto">{{ LaravelLocalization::getCurrentLocaleName() }}</strong>
                                @else
                                    <span class="avatar country-Flag mr-0 align-self-center bg-transparent"><img
                                            src="{{ URL::asset('assets/img/flags/us_flag.jpg') }}"
                                            alt="img"></span>
                                    <strong
                                        class="mr-2 ml-2 my-auto">{{ LaravelLocalization::getCurrentLocaleName() }}</strong>
                                @endif
                                <div class="my-auto">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow" x-placement="bottom-end">
                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                                        href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                        @if ($properties['native'] == 'English')
                                            <i class="flag-icon flag-icon-us"></i>
                                        @elseif($properties['native'] == 'العربية')
                                            <i class="flag-icon flag-icon-eg"></i>
                                        @endif
                                        {{ $properties['native'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="nav nav-item  navbar-nav-right ml-auto">


                    @can('الاشعارات')
                        <div class="dropdown nav-item main-header-notification">
                            <a class="new nav-link" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-bell">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                </svg><span class=" pulse"></span></a>
                            <div class="dropdown-menu">
                                <div class="menu-header-content bg-primary text-right">
                                    <div class="d-flex">
                                        <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">الإشعارات
                                        </h6>
                                        <span class="badge badge-pill badge-warning mr-auto my-auto float-left">تعيين قراءة
                                            الإشعارات</span>
                                    </div>
                                    <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 "> عدد الإشعارات
                                        الغير مقروءة <span class="badge badge-pill badge-warning mr-auto my-auto"
                                            style="color: white;font-weight:bolder;font-size:14px;"
                                            id="notifications_count">{{ auth()->user()->unreadNotifications->count() }}</span>
                                    </p>
                                </div>
                                <div id="unreadNotifications">
                                    @foreach (auth()->user()->unreadNotifications as $notification)
                                        <div class="main-notification-list Notification-scroll">
                                            <a class="d-flex p-3 border-bottom"
                                                href="{{ route('markAsRead', ['notification_id' => $notification->id, 'invoice_id' => $notification->data['id']]) }}">
                                                <div class="notifyimg bg-pink">
                                                    <i class="la la-file-alt text-white"></i>
                                                </div>
                                                <div class="mr-3">
                                                    <h5 class="notification-label mb-1">{{ $notification->data['title'] }} :
                                                        {{ $notification->data['user'] }}</h5>
                                                    <div class="notification-subtext">
                                                        {{ $notification->created_at->diffForHumans(null, false, false, 2) }}
                                                    </div>
                                                </div>

                                                <div class="mr-auto">
                                                    <i class="las la-angle-left text-left text-muted"></i>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                @if (auth()->user()->unreadNotifications->count() > 0)
                                    <div class="dropdown-footer">
                                        <a href="{{ route('markAsReadAll') }}">تعيين قراءة الكل</a>
                                    </div>
                                @else
                                    <div class="dropdown-footer">
                                        لا يوجد إشعارات غير مقروءة
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endcan
                    <div class="nav-item full-screen fullscreen-button">
                        <a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                                class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-maximize">
                                <path
                                    d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3">
                                </path>
                            </svg></a>
                    </div>
                    <div class="dropdown main-profile-menu nav nav-item nav-link">
                        <a class="profile-user d-flex" href=""><img alt=""
                                src="{{ Auth::user()->profile_photo_url }}"></a>
                        <div class="dropdown-menu">
                            <div class="main-header-profile bg-primary p-3">
                                <div class="d-flex wd-100p">
                                    <div class="main-img-user"><img alt=""
                                            src="{{ Auth::user()->profile_photo_url }}" class=""></div>
                                    <div class="mr-3 my-auto">
                                        <h6>{{ Auth::user()->name }}</h6>
                                    </div>
                                </div>
                            </div>
                            <a class="dropdown-item" href="{{ route('profile.show') }}"><i
                                    class="bx bx-user-circle"></i>البروفايل</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                    class="bx bx-log-out"></i>تسجيل خروج</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- /main-header -->



    {{-- <script type="module">
    Echo.channel('notify')
        .listen('RealTimeNotification', (event) => {
            // Handle the received event data here
            console.log(event);

            // Update your notification UI with the received data
            let notificationHtml = `
                                <a class="d-flex p-3 border-bottom"
                                    href="#">
                                    <div class="notifyimg bg-pink">
                                        <i class="la la-file-alt text-white"></i>
                                    </div>
                                    <div class="mr-3">
                                        <h5 class="notification-label mb-1">تم إضافة فاتورة جديدة بواسطة :
                                            ${event.user.name}</h5>
                                        <div class="notification-subtext">
                                            ${event.created_at}</div>
                                    </div>

                                    <div class="mr-auto">
                                        <i class="las la-angle-left text-left text-muted"></i>
                                    </div>
                                </a>
        `;

            // Append the new notification to the notifications dropdown
            $('.main-notification-list').append(notificationHtml);
        });
</script> --}}
