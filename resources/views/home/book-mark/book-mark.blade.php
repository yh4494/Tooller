<head>
    <style type="text/css">
        .allens-slider {
            width: 200px;
            /*height: 100%;*/
            position: absolute;
            left: 0;
            top: 56px;
            bottom: 0;
            background: #fff;
            border-right: 1px solid #666666;
            /*box-shadow: #f3f3f3 1px 1px 1px 1px;*/
        }
        .allens-mark-content {
            position: absolute;
            left: 0;
            width: 100%;
            top: 0px;
            height: 100%;
        }
        .allens-slider .title {
            width: 100%;
            height: 30px;
            font-weight: bold;
            text-align: center;
            line-height: 30px;
            border-bottom: 1px solid #f3f3f3;
            background: #5C5C5C;
            color: #fff;
        }

        .allens-slider .title div {
            color: #fff;
            font-size: 14px;
            height: 100%;
            cursor: pointer;
        }

        .allens-slider .title div:hover {
            background: #2D3338;
        }

        .allens-slider .element {
            width: 100%;
            height: 30px;
            font-size: 13px;
            text-align: left;
            line-height: 30px;
            text-indent: 5px;
            border-bottom: 1px solid #f3f3f3;
            cursor: pointer;
        }
    </style>
</head>

<script type="application/javascript">
    function getUrl(URL) {
        let http = (window.location.protocol === 'http:' ? 'http:' : 'https:');
        //调用跨域API
        let realurl = http + '//cors-anywhere.herokuapp.com/' + URL;
        axios.get(realurl).then((response) => {
            // console.log(response)
            let html = response.data;
            html = html.replace(/data-src/g, "src")
                .replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/g, '')
                .replace(/https/g, 'http');
            //let html_src = 'data:text/html;charset=utf-8,' + html;
            let html_src = html;
            let iframe = document.getElementById('iFrame');
            iframe.src = html_src;
            var doc = iframe.contentDocument || iframe.document;
            doc.write(html_src);
            doc.getElementById("js_content").style.visibility = "visible";
            var doc = iframe.contentDocument || iframe.document;
            doc.body.innerHTML = html_src;
            $(iframe.document).children('body').innerHTML = html_src;
        }, (err) => {
            console.log(err);
        });
    }

    var vue = new Vue({
        el: '#real-content',
        data: {
            list: [],
            realUrl: '',
            showLinksChild: false,
            currentCategoryId: 0,
            currentCategoryName: null,
            name: '',
            address: ''
        },
        methods: {
            clickToJumping(url) {
                //加载层-默认风格
                window.open(url)
            },
            clickToShowLinks(categoryId, categoryName = null) {
                this.showLinksChild = true;
                this.currentCategoryName = categoryName;
                this.currentCategoryId = categoryId;
                console.log(this.currentCategoryId)
                this.$http.get('/api/mark/links?categoryId=' + categoryId).then(function (response) {
                    var data = response.body;
                    this.list = data.data;
                })
            },
            clickToBack() {
                this.showLinksChild = false;
                this.currentCategoryId = 0;
                this.currentCategoryName = null;
            },
            clickToAddMark() {
                var url = ('/api/mark/save?categoryId=' + this.currentCategoryId + '&name=' + this.name + '&address=' + this.address)
                this.$http.get(url).then(function (response) {
                    var data = response.body;
                    if (data.code !== 0) {
                        layer.msg(data.msg, {icon: 5});
                    } else {
                        $('#exampleModalCenter').modal('hide')
                        this.clickToShowLinks(this.currentCategoryId);
                    }
                })
            }
        }
    })
</script>
