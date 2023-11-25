<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <img src="{{ asset('logo.png') }}" style="with:118px; height:46px" >
    </div>
    <!--c-sidebar-brand-->

    <ul class="c-sidebar-nav">


        <li class="c-sidebar-nav-item">
            <x-teckiproadmin::utils.link class="c-sidebar-nav-link" :href="route('admin.dashboard')" :active="activeClass(Route::is('admin.dashboard'), 'c-active')"
                icon="c-sidebar-nav-icon cil-speedometer" :text="__('Dashboard')" />
        </li>


        @if (
            $logged_in_user->hasAllAccess() ||
                ($logged_in_user->can('admin.access.user.list') ||
                    $logged_in_user->can('admin.access.user.deactivate') ||
                    $logged_in_user->can('admin.access.user.reactivate') ||
                    $logged_in_user->can('admin.access.user.clear-session') ||
                    $logged_in_user->can('admin.access.user.impersonate') ||
                    $logged_in_user->can('admin.access.user.change-password')))
            <li class="c-sidebar-nav-title">@lang('System')</li>



            @if ($logged_in_user->hasAllAccess() && $logged_in_user->isMasterAdmin())
                <li
                    class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.auth.user.*') || Route::is('admin.auth.role.*'), 'c-open c-show') }}">
                    <x-teckiproadmin::utils.link href="#" icon="bi bi-gear-wide-connected"
                        class="c-sidebar-nav-dropdown-toggle" :text="__('Settings')" />

                    <ul class="c-sidebar-nav-dropdown-items">

                        <li class="c-sidebar-nav-item">
                            <x-teckiproadmin::utils.link :href="route('admin.setting.index')" class="c-sidebar-nav-link" :text="__('Domain && Logo')"
                                :active="activeClass(Route::is('admin.setting.index'), 'c-active')" />
                        </li>

                        <li class="c-sidebar-nav-item">
                            <x-teckiproadmin::utils.link :href="route('admin.setting.mail')" class="c-sidebar-nav-link" :text="__('Mail Settings')"
                                :active="activeClass(Route::is('admin.setting.mail'), 'c-active')" />
                        </li>




                        <li class="c-sidebar-nav-item">
                            <x-teckiproadmin::utils.link :href="route('admin.setting.webhook')" class="c-sidebar-nav-link" :text="__('Webhook URLs')"
                                :active="activeClass(Route::is('admin.setting.webhook'), 'c-active')" />
                        </li>


                   {{--
                          <li class="c-sidebar-nav-item">
                            <x-teckiproadmin::utils.link :href="route('admin.setting.database')" class="c-sidebar-nav-link" :text="__('Database Settings')"
                                :active="activeClass(Route::is('admin.setting.database'), 'c-active')" />
                        </li>

                     --}}



                    {{-- Payment Gateways --}}


                    <li class="c-sidebar-nav-dropdown">

                        <x-teckiproadmin::utils.link href="#" class="c-sidebar-nav-dropdown-toggle"
                            :text="__('Payment Gateways')" :active="activeClass(Route::is('admin.plan.gateway.*'), 'c-active')" />


                        <ul class="c-sidebar-nav-dropdown-items">


                            <li class="c-sidebar-nav-item">
                                <x-teckiproadmin::utils.link :href="route('admin.plan.gateway.paddle')" class="c-sidebar-nav-link"
                                    :text="__('Paddle')" :active="activeClass(Route::is('admin.plan.gateway.paddle'), 'c-active')" />
                            </li>

                            <li class="c-sidebar-nav-item">
                                <x-teckiproadmin::utils.link :href="route('admin.plan.gateway.stripe')" class="c-sidebar-nav-link"
                                    :text="__('Stripe')" :active="activeClass(Route::is('admin.plan.gateway.stripe'), 'c-active')" />
                            </li>





                        </ul>
                    </li>

                    {{-- Payment Gateways --}}



                    </ul>
                </li>
            @endif


            <li
                class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.auth.user.*') || Route::is('admin.auth.role.*'), 'c-open c-show') }}">
                <x-teckiproadmin::utils.link href="#" icon="c-sidebar-nav-icon cil-user"
                    class="c-sidebar-nav-dropdown-toggle" :text="__('Access')" />

                <ul class="c-sidebar-nav-dropdown-items">
                    @if (
                        $logged_in_user->hasAllAccess() ||
                            ($logged_in_user->can('admin.access.user.list') ||
                                $logged_in_user->can('admin.access.user.deactivate') ||
                                $logged_in_user->can('admin.access.user.reactivate') ||
                                $logged_in_user->can('admin.access.user.clear-session') ||
                                $logged_in_user->can('admin.access.user.impersonate') ||
                                $logged_in_user->can('admin.access.user.change-password')))
                        <li class="c-sidebar-nav-item">
                            <x-teckiproadmin::utils.link :href="route('admin.auth.user.index')" class="c-sidebar-nav-link" :text="__('User Management')"
                                :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                        </li>
                    @endif

                    @if ($logged_in_user->hasAllAccess() && $logged_in_user->isMasterAdmin())
                        <li class="c-sidebar-nav-item">
                            <x-teckiproadmin::utils.link :href="route('admin.auth.role.index')" class="c-sidebar-nav-link"
                                :text="__('Role Management')" :active="activeClass(Route::is('admin.auth.role.*'), 'c-active')" />
                        </li>

                        <li class="c-sidebar-nav-item">
                            <x-teckiproadmin::utils.link :href="route('admin.permission.index')" class="c-sidebar-nav-link"
                                :text="__('Permission Management')" :active="activeClass(Route::is('admin.permission.*'), 'c-active')" />
                        </li>
                    @endif




                </ul>
            </li>
        @endif







      {{-- PLANS --}}

      <li class="c-sidebar-nav-dropdown">
          <x-teckiproadmin::utils.link href="#" icon="bi bi-tags-fill"
              class="c-sidebar-nav-dropdown-toggle" :text="__('Plans')" />

              <ul class="c-sidebar-nav-dropdown-items">

                <li class="c-sidebar-nav-item">
                    <x-teckiproadmin::utils.link :href="route('admin.plan.settings')" class="c-sidebar-nav-link"
                        :text="__('Setting')" :active="activeClass(Route::is('admin.plan.settings'), 'c-active')" />
                </li>


              <li class="c-sidebar-nav-item">
                <x-teckiproadmin::utils.link :href="route('admin.plan.create')" class="c-sidebar-nav-link"
                    :text="__('Create')" :active="activeClass(Route::is('admin.plan.create'), 'c-active')" />
            </li>

            <li class="c-sidebar-nav-item">
                <x-teckiproadmin::utils.link :href="route('admin.plan.index')" class="c-sidebar-nav-link"
                    :text="__('Manage')" :active="activeClass(Route::is('admin.plan.index'), 'c-active')" />
            </li>


            <li class="c-sidebar-nav-item">
                <x-teckiproadmin::utils.link :href="route('admin.plan.features.index')" class="c-sidebar-nav-link"
                    :text="__('Features')" :active="activeClass(Route::is('admin.plan.features.index'), 'c-active')" />
            </li>




            <li class="c-sidebar-nav-item">
                <x-teckiproadmin::utils.link :href="url('site/pricing')" target="_blank" class="c-sidebar-nav-link"
                    :text="__('Pricing Page')" />
            </li>
    </ul>


      </li>

      {{-- Plan ends --}}


      {{-- SUBSCRIPTIONS --}}

      <li class="c-sidebar-nav-dropdown">
          <x-teckiproadmin::utils.link href="#" icon="bi bi-cash"
              class="c-sidebar-nav-dropdown-toggle" :text="__('Subscriptions')" />

          <ul class="c-sidebar-nav-dropdown-items">



            @if ($logged_in_user->can('admin.plan.launch.*') && $logged_in_user->isMasterAdmin())
            <li class="c-sidebar-nav-item">
                <x-teckiproadmin::utils.link :href="route('admin.plan.launch.index')" class="c-sidebar-nav-link"
                    :text="__('Launches')" icon="bi bi-receipt-cutoff" :active="activeClass(Route::is('admin.plan.launch.index'), 'c-active')" />
            </li>
            @endif






              <li class="c-sidebar-nav-dropdown">

                <x-teckiproadmin::utils.link href="#" class="c-sidebar-nav-dropdown-toggle"
                    :text="__('SaaS')" icon="bi bi-cash-stack" :active="activeClass(Route::is('admin.launch.*'), 'c-active')" />


                <ul class="c-sidebar-nav-dropdown-items">


                    <li class="c-sidebar-nav-dropdown">

                        <x-teckiproadmin::utils.link href="#" class="c-sidebar-nav-dropdown-toggle"
                            :text="__('Stripe')" icon="bi bi-stripe" :active="activeClass(Route::is('admin.stripe.*'), 'c-active')" />


                        <ul class="c-sidebar-nav-dropdown-items">



                        </ul>
                    </li>


                    <li class="c-sidebar-nav-dropdown">

                        <x-teckiproadmin::utils.link href="#" class="c-sidebar-nav-dropdown-toggle"
                            :text="__('Paddle')" icon="bi bi-credit-card-2-front" :active="activeClass(Route::is('admin.paddle.*'), 'c-active')" />



                            <ul class="c-sidebar-nav-dropdown-items">


                                <li class="c-sidebar-nav-item">

                                    <x-teckiproadmin::utils.link :href="route('admin.paddle.receipts')" class="c-sidebar-nav-link"
                                        :text="__('Receipts')" :active="activeClass(Route::is('admin.paddle.receipts'), 'c-active')" />

                                </li>

                                <li class="c-sidebar-nav-item">

                                    <x-teckiproadmin::utils.link :href="route('admin.paddle.customers')" class="c-sidebar-nav-link"
                                        :text="__('Customers')" :active="activeClass(Route::is('admin.paddle.customers'), 'c-active')" />

                                </li>


                                <li class="c-sidebar-nav-item">
                                    <x-teckiproadmin::utils.link :href="route('admin.paddle.index')" class="c-sidebar-nav-link"
                                        :text="__('Subscriptions')" :active="activeClass(Route::is('admin.paddle.index'), 'c-active')" />
                                </li>

                            </ul>

                    </li>



                </ul>
            </li>


          </ul>
      </li>





        {{-- TUTORIALS --}}

        @if ($logged_in_user->hasAllAccess())
            <li class="c-sidebar-nav-item">
                <x-teckiproadmin::utils.link class="c-sidebar-nav-link" :href="route('admin.tutorial.index')" :active="activeClass(Route::is('admin.tutorial.index'), 'c-active')"
                    icon="bi bi-file-slides-fill" :text="__('Tutorials')" />
            </li>
        @endif





        {{-- LOGS --}}

        @if ($logged_in_user->hasAllAccess())
            <li class="c-sidebar-nav-dropdown">
                <x-teckiproadmin::utils.link href="#" icon="bi bi-file-earmark-text-fill"
                    class="c-sidebar-nav-dropdown-toggle" :text="__('Logs')" />

                <ul class="c-sidebar-nav-dropdown-items">

                    <li class="c-sidebar-nav-item">
                        <x-teckiproadmin::utils.link :href="url('log-viewer')" target="_blank" class="c-sidebar-nav-link"
                            :text="__('Logs')" />
                    </li>
                    <li class="c-sidebar-nav-item">
                        <x-teckiproadmin::utils.link href="https://log-viewer.opcodes.io/docs" target="_blank"
                            class="c-sidebar-nav-link" :text="__('Documentation')" />
                    </li>
                </ul>
            </li>
        @endif









        {{-- JOB QUEUES --}}
        @if ($logged_in_user->hasAllAccess())
            <li class="c-sidebar-nav-dropdown">
                <x-teckiproadmin::utils.link href="#" icon="bi bi-filetype-php"
                    class="c-sidebar-nav-dropdown-toggle" :text="__('Job Queues')" />

                <ul class="c-sidebar-nav-dropdown-items">

                    <li class="c-sidebar-nav-item">
                        <x-teckiproadmin::utils.link :href="url('horizon/dashboard')" target="_blank" class="c-sidebar-nav-link"
                            :text="__('Dashboard')" />
                    </li>
                    <li class="c-sidebar-nav-item">
                        <x-teckiproadmin::utils.link href="url('horizon/jobs/pending')" target="_blank"
                            class="c-sidebar-nav-link" :text="__('Pending Jobs')" />
                    </li>

                    <li class="c-sidebar-nav-item">
                        <x-teckiproadmin::utils.link href="url('horizon/jobs/completed')" target="_blank"
                            class="c-sidebar-nav-link" :text="__('Completed Jobs')" />
                    </li>
                </ul>
            </li>
        @endif









        {{-- File Manager --}}
        @if ($logged_in_user->hasAllAccess())
            {{-- Tutorial: https://www.itsolutionstuff.com/post/laravel-file-manager-tutorial-step-by-stepexample.html --}}
            <li class="c-sidebar-nav-dropdown">
                <x-teckiproadmin::utils.link href="#" icon="bi bi-file-earmark-fill"
                    class="c-sidebar-nav-dropdown-toggle" :text="__('File Manager')" />

                <ul class="c-sidebar-nav-dropdown-items">

                    <li class="c-sidebar-nav-item">
                        <x-teckiproadmin::utils.link :href="url('admin/filemanager')" target="_blank" class="c-sidebar-nav-link"
                            :text="__('Dashboard')" />
                    </li>
                    <li class="c-sidebar-nav-item">
                        <x-teckiproadmin::utils.link href="https://github.com/alexusmai/laravel-file-manager"
                            target="_blank" class="c-sidebar-nav-link" :text="__('Github Page')" />
                    </li>
                </ul>
            </li>
        @endif




        @if ($logged_in_user->hasAllAccess() && $logged_in_user->isMasterAdmin())
            <li class="c-sidebar-nav-item">
                <x-teckiproadmin::utils.link class="c-sidebar-nav-link" :href="route('admin.announcement.index')" :active="activeClass(Route::is('admin.announcement.index'), 'c-active')"
                    icon="bi bi-megaphone-fill" :text="__('Announcement')" />
            </li>
        @endif




    </ul>

    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
        data-class="c-sidebar-minimized"></button>
</div>
<!--sidebar-->
