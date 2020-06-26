<div  id="navigation-allens" style="background: #343a40;">
<nav style="width: 1110px; margin: 0 auto;" class="navbar navbar-expand-lg navbar-light bg-light navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Tooller</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav" style="width: 100%">
            <li class="nav-item @if(explode('_', $route)[0] == 'home') active  @endif">
                <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown @if(explode('_', $route)[0] == 'tool') active  @endif">
                <a class="nav-link dropdown-toggle" href="/development" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    开发工具
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">JSON 格式化</a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/tool/crypt">加密工具</a>
                    <a class="dropdown-item" href="/tool/time">时间工具</a>
                    {{--<a class="dropdown-item" href="#">Other</a>--}}
                </div>
            </li>
            @if(isset($isLogin) && $isLogin)
                <li class="nav-item @if(explode('_', $route)[0] == 'process') active  @endif">
                    <a class="nav-link" href="/process">任务</a>
                </li>
                <li class="nav-item @if(explode('_', $route)[0] == 'article') active  @endif">
                    <a class="nav-link" href="/article">文章</a>
                </li>
                <li class="nav-item @if(explode('_', $route)[0] == 'time-line') active  @endif">
                    <a class="nav-link" href="/time-line">时间轴</a>
                </li>
                <li class="nav-item @if(explode('_', $route)[0] == 'book') active  @endif">
                    <a class="nav-link" href="/book">书籍</a>
                </li>
                <li class="nav-item @if(explode('_', $route)[0] == 'about') active  @endif">
                    <a class="nav-link" href="/about">About</a>
                </li>
            @endif
        </ul>
        @if(isset($isLogin) && $isLogin)
            <div class="nav-item" style="float:right; width: 40px; border-radius: 17.5px; overflow: hidden">
                <img width="35" height="35" src="/resources/assets/images/header00{{ isset($userId) ? $userId % env('HEADER_IMAGE_NUMS') : '0' }}.jpg" alt="">
            </div>
            <div style="color: #fff;width: auto; text-align: right; margin-left: 10px; white-space: nowrap">{{ isset($userName) ? $userName : ''  }}</div>
            <div class="nav-item" style="margin-left: 10px;float:right; line-height: 40px; text-align: center; color: #fff; width: 40px; height: 40px; border-radius: 20px; overflow: hidden">
                <div style="color: #fff !important;" class="white-a"><a style="color: #fff !important;" href="/logout">退出</a></div>
            </div>
        @else
            <div class="nav-item" style="margin-left: 10px;float:right; line-height: 40px; text-align: center; color: #fff; width: 40px; height: 40px; border-radius: 20px; overflow: hidden">
                <div style="color: #fff;"><a style="color: #fff;" href="/login">登录</a></div>
            </div>
        @endif
    </div>
</nav>
</div>
