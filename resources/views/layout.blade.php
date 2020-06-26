<!DOCTYPE html>
<html>
    <head>
        <title>Allens Tooller</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="/resources/lib/css/common.css">
        @yield("header")
        <meta name="viewport" content="initial-scale=1, maximum-scale=3, minimum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="/resources/lib/font-awesome-4.7.0/css/font-awesome.css">
        <link rel="stylesheet" href="/resources/lib/animate/animate.min.css">
        <style type="text/css">
            [v-cloak] {
                display: none;
            }
            .white-a {
                color: #fff;
            }
            a.white-a :hover {
                color: #fff;
            }
            .carousel-item {
                top: 50%;
                margin-top: -250px;
            }
            body {
                background: url("/resources/assets/images/bg00{{ env('BACKGROUND_IMAGE') }}.jpg") repeat;
            }
            .container {
                background: #fff;
            }
            .test-5::-webkit-scrollbar {
                /*滚动条整体样式*/
                width : 10px;  /*高宽分别对应横竖滚动条的尺寸*/
                height: 1px;
            }
            .test-5::-webkit-scrollbar-thumb {
                /*滚动条里面小方块*/
                border-radius   : 10px;
                background-color: skyblue;
                background-image: -webkit-linear-gradient(
                    45deg,
                    rgba(255, 255, 255, 0.2) 25%,
                    transparent 25%,
                    transparent 50%,
                    rgba(255, 255, 255, 0.2) 50%,
                    rgba(255, 255, 255, 0.2) 75%,
                    transparent 75%,
                    transparent
                );
            }
            .test-5::-webkit-scrollbar-track {
                /*滚动条里面轨道*/
                box-shadow   : inset 0 0 5px rgba(0, 0, 0, 0.2);
                background   : #ededed;
                border-radius: 10px;
            }
        </style>
    </head>
    <body style="z-index: 10000; @if(explode('_', $route)[0] == 'home') position: absolute; width: 100%; height: 100%; overflow-y: scroll @endif" class="test-5">
        @include('nav')
        @if(explode('_', $route)[0] == 'home')
            <canvas id="world" style="position: fixed; pointer-events:none; top: 60px; left: 0; z-index: 100;"></canvas>
        @endif
{{--        <div style="position: absolute; height: 56px; width: 100%; background: #343a40;" id="navigation-allens"></div>--}}
        <div class="container" id="body-allens">
        <!-- Content here -->
        @yield("content")
        </div>
    </body>
    <script src="/resources/lib/js/jquery.slim.min.js"></script>
{{--    <script src="/resources/lib/js/jquery-3.3.1.min.js"></script>--}}
    <script type="text/javascript" src="/resources/lib/webuploader-0.1.5/examples/image-upload/jquery.js"></script>
    <script src="/resources/lib/layer-v3.1.1/layer/layer.js"></script>
    <script src="/resources/lib/js/popper.min.js"></script>
    <script src="/resources/lib/js/vue.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>
    <script src="/resources/lib/js/common.js"></script>
    @yield("footer")
    @if(explode('_', $route)[0] == 'home')
    <script>
        (function() {
            var COLORS, Confetti, NUM_CONFETTI, PI_2, canvas, confetti, context, drawCircle, i, range, resizeWindow, xpos;

            NUM_CONFETTI = 350;

            COLORS = [[85, 71, 106], [174, 61, 99], [219, 56, 83], [244, 92, 68], [248, 182, 70]];

            PI_2 = 2 * Math.PI;

            canvas = document.getElementById("world");

            context = canvas.getContext("2d");

            window.w = 0;

            window.h = 0;

            resizeWindow = function() {
                window.w = canvas.width = window.innerWidth;
                return window.h = canvas.height = window.innerHeight;
            };

            window.addEventListener('resize', resizeWindow, false);

            window.onload = function() {
                return setTimeout(resizeWindow, 0);
            };

            range = function(a, b) {
                return (b - a) * Math.random() + a;
            };

            drawCircle = function(x, y, r, style) {
                context.beginPath();
                context.arc(x, y, r, 0, PI_2, false);
                context.fillStyle = style;
                return context.fill();
            };

            xpos = 0.5;

            document.onmousemove = function(e) {
                return xpos = e.pageX / w;
            };

            window.requestAnimationFrame = (function() {
                return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function(callback) {
                    return window.setTimeout(callback, 1000 / 60);
                };
            })();

            Confetti = class Confetti {
                constructor() {
                    this.style = COLORS[~~range(0, 5)];
                    this.rgb = `rgba(${this.style[0]},${this.style[1]},${this.style[2]}`;
                    this.r = ~~range(2, 6);
                    this.r2 = 2 * this.r;
                    this.replace();
                }

                replace() {
                    this.opacity = 0;
                    this.dop = 0.03 * range(1, 4);
                    this.x = range(-this.r2, w - this.r2);
                    this.y = range(-20, h - this.r2);
                    this.xmax = w - this.r;
                    this.ymax = h - this.r;
                    this.vx = range(0, 2) + 8 * xpos - 5;
                    return this.vy = 0.7 * this.r + range(-1, 1);
                }

                draw() {
                    var ref;
                    this.x += this.vx;
                    this.y += this.vy;
                    this.opacity += this.dop;
                    if (this.opacity > 1) {
                        this.opacity = 1;
                        this.dop *= -1;
                    }
                    if (this.opacity < 0 || this.y > this.ymax) {
                        this.replace();
                    }
                    if (!((0 < (ref = this.x) && ref < this.xmax))) {
                        this.x = (this.x + this.xmax) % this.xmax;
                    }
                    return drawCircle(~~this.x, ~~this.y, this.r, `${this.rgb},${this.opacity})`);
                }

            };

            confetti = (function() {
                var j, ref, results;
                results = [];
                for (i = j = 1, ref = NUM_CONFETTI; (1 <= ref ? j <= ref : j >= ref); i = 1 <= ref ? ++j : --j) {
                    results.push(new Confetti);
                }
                return results;
            })();

            window.step = function() {
                var c, j, len, results;
                requestAnimationFrame(step);
                context.clearRect(0, 0, w, h);
                results = [];
                for (j = 0, len = confetti.length; j < len; j++) {
                    c = confetti[j];
                    results.push(c.draw());
                }
                return results;
            };

            step();

        }).call(this);
    </script>
    @endif
</html>
