<!DOCTYPE html>
<html lang="ar">
    @include('Super.partials.head')
    <body>
        <div class="container-scroller">
           
            <div class="container-fluid page-body-wrapper">
                @include('Super.partials.navbar')
                <div class="main-panel" >
                    <div class="content-wrapper" style="background-color: #0F172A">
                        <main id="main" class="main" >
                            @yield('main')
                        </main>
                    </div>
                    @include('Super.partials.footer')
                </div>
            </div>
            @include('Super.partials.sidebar')
        </div>
        @include('Super.partials.scripts')
    </body>
</html>