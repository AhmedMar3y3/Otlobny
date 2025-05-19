<!DOCTYPE html>
<html lang="ar">
    @include('Admin.partials.head')
    <body>
        <div class="container-scroller">
           
            <div class="container-fluid page-body-wrapper">
                @include('Admin.partials.navbar')
                <div class="main-panel" >
                    <div class="content-wrapper" style="background-color: #F6D2D4">
                        <main id="main" class="main" >
                            @yield('main')
                        </main>
                    </div>
                    @include('Admin.partials.footer')
                </div>
            </div>
            @include('Admin.partials.sidebar')
        </div>
        @include('Admin.partials.scripts')
    </body>
</html>