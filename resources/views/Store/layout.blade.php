<!DOCTYPE html>
<html lang="ar">
    @include('Store.partials.head')
    <body>
        <div class="container-scroller">
           
            <div class="container-fluid page-body-wrapper">
                @include('Store.partials.navbar')
                <div class="main-panel" >
                    <div class="content-wrapper" style="background-color: #0F172A">
                        <main id="main" class="main" >
                            @yield('main')
                        </main>
                    </div>
                    @include('Store.partials.footer')
                </div>
            </div>
            @include('Store.partials.sidebar')
        </div>
        @include('Store.partials.scripts')
    </body>
</html>