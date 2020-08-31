<aside class="left-sidebar">

        <div class="center-block w-xxl w-auto-xs p-v-md">
            <div class="navbar">
                <div class="m-t-lg text-center">
                    <img class="logo" src="/assets/images/batman-logo.png">

                    <div class="user-detail">
                            <h5>{{Auth::user()->name}}</h5>
                            <h5>{{Auth::user()->email}}</h5>
                        <br>
                    </div>

                </div>
            </div>
        </div>

    <div class="side-menu dashboard">
        <a href="/admin/dashboard">
            <div class="pading-menu">
                <i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard
            </div>
        </a>
    </div>

    <div class="side-menu result">
        <a href="/admin/result">
            <div class="pading-menu">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Result
            </div>
        </a>
    </div>

    <div class="side-menu logout">
        <a href="/admin/logout">
            <div class="pading-menu">
                <i class="fa fa-sign-out" aria-hidden="true"></i>Logout
            </div>
        </a>
    </div>

</aside>
