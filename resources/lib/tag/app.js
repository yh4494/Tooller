(function(global, noGlobal) {
    var unDelStatus = []
    var that = new Vue({
        el: '.container',
        data: {
            listData: [],
        },
        mounted: function() {
            this.requestProcessList();
        },
        methods: {
            requestProcessList: function () {
                this.$http.get('/process/all?pid=0&history=false').then(function (response) {
                    that.listData = response.body.data;
                    unDelStatus = []
                    that.listData.forEach(function(e) {
                        if (e.status == 0) {
                            unDelStatus.push.apply(unDelStatus, e.child_process);
                            console.log(unDelStatus)
                        }
                    });
                    domReady.ready(store.setup);
                });
            },
            clickToComplete: function (id) {
                this.$http.get('/process/complete/' + id).then(function (response) {
                    var data = response.body;
                    if (data.code === 0) {
                        window.location.href = '/process/tag'
                    }
                })
            },
            clickToShowSprint: function () {
                window.location.href = '/process'
            },
            clickToAddSprint: function () {
                layer.open({
                    title: '',
                    type: 2,
                    area: ['40%', '450px'],
                    fixed: true, //不固定
                    maxmin: true,
                    content: '/modal/process-child',
                    end: function () {
                        that.requestProcessList()
                    }
                });
            },
            clickToAddProcess: function (id, name, content, pid) {
                $.ajax({
                    url: '/process/add',
                    method: 'POST',
                    type: 'json',
                    data: {id, name, content, pid},
                    success: function (data) {
                        v.requestProcessList();
                    }
                })
            },
            clickToDeleteChildTask(id) {
                layer.confirm('是否删除该任务？', {
                    btn: ['删除', '取消'] //按钮
                }, function (index) {
                    layer.close(index);
                    that.$http.get('/process/delete/' + id).then(function (response) {
                        that.requestProcessList();
                        var data = response.body;
                        if (data.code === 0) {
                            window.location.href = '/process/tag'
                        }
                    })
                }, function () {

                });
            },
            clickToRefresh: function() {
                that.requestProcessList()
            }
        }
    });
  class StickyNote {
    constructor(options) {
      this.init(options);
    }

    init(options) {
      Object.assign(this, config, options);
      this.id = this.id ? this.id : new Date().getTime();
      StickyNote.top = Math.max(StickyNote.top, this.layer);
      if(!this.root) {
        this.root = document.body;
      }
      this.container = document.createElement('div');
      this.container.classList.add(this.className || 'note-container');
      this.root.appendChild(this.container);
      this.render();
      this.bindEvent();
    }

    save() {
      this.content = this.noteContent.innerHTML;
      store.set(this.id, {
        content: this.content || '',
        postTime: new Date().getTime(),
        x: this.x,
        y: this.y,
        layer: this.layer
      });
    }

    editor () {
        this.content = this.noteContent.innerHTML;
        that.clickToAddProcess(this.id, this.title, this.content, this.pid)
    }

    close() {
      if (this.root) {
        this.root.removeChild(this.container);
      }
    }

    bindEvent() {
      var pos = {}, self = this, canMove = false;
      addEvent(this.titleBar, 'mousedown', function(e) {
        pos.x = e.clientX - self.container.offsetLeft;
        pos.y = e.clientY - self.container.offsetTop;
        if (e.button == 0) {
          canMove = true;
        }
      });
      addEvent(document, 'mousemove', function(e) {
        if (!canMove) return;
        var
        x = Math.min( document.documentElement.clientWidth - self.width, Math.max(e.clientX - pos.x, 0)),
        y = Math.min( document.documentElement.clientHeight - self.height, Math.max(e.clientY - pos.y, 0));

        self.container.style.left = x  + 'px';
        self.container.style.top = y + 'px';
      });
      addEvent(document, 'mouseup', function(e) {
        canMove = false;
      });

      addEvent(self.noteContent, 'keyup', function(e) {
          self.editor()
        self.save();
      });

      addEvent(self.btnClose, 'click', function(e) {
        self.close();
        self.save();
      });

      addEvent(self.finish, 'click', function(e) {
          store.remove(self.id);
          that.clickToComplete(self.id)
          self.close();
      });

      addEvent(self.btnNew, 'click', function(e) {
          that.clickToAddSprint()
        // var x = self.x,
        //     y = self.y,
        //     maxWidth = document.documentElement.clientWidth - self.width,
        //     maxHeight = document.documentElement.clientHeight - self.height;
        // if ( x >= maxWidth || x < 0 ) {
        //   vx *= -1;
        // }
        //
        // if ( y >= maxHeight || y < 0 ) {
        //   vy *= -1;
        // }
        //
        // x = x + 20 * vx;
        // y = y + 20 * vy;
        //
        // new StickyNote({
        //   root: self.root,
        //   x: x,
        //   y: y,
        //   layer: StickyNote.top++
        // });
      });
      addEvent(self.btnRemove, 'click', function(e) {
          that.clickToDeleteChildTask(self.id)
        // store.remove(self.id);
        // self.close();
      });

      addEvent(self.container, 'mousedown', function(e) {
        if (e.button != 0) return;
        self.layer = StickyNote.top++;
        self.container.style.zIndex = self.layer;
      });

      addEvent(self.container, 'mouseup', function(e) {
        self.x = self.container.offsetLeft || 0;
        self.y = self.container.offsetTop || 0;
        self.save();
      });
    }

    render() {
      var self = this;
      self.container.innerHTML = template.replace(/\{\{([^\}]+)\}\}/g, ($0, $1) =>  self[$1]);
      self.titleBar = self.container.querySelector('.note-title');
      self.noteContent = self.container.querySelector('.note-content');
      self.btnClose = self.container.querySelector('.btn-close');
      self.btnNew = self.container.querySelector('.btn-new');
      self.finish = self.container.querySelector('.btn-finish');
      self.btnRemove = self.container.querySelector('.btn-remove');
      self.container.style.position = 'absolute';
      self.container.style.left = self.x + 'px';
      self.container.style.top = self.y + 'px';
      self.noteContent.innerHTML = self.content;
      self.container.data = self;
      self.container.style.zIndex = self.layer;
      self.save();
    }
  }

  StickyNote.top = 0;
  var vx = 1, vy = 1;
  const config = {
    id: null,
    root: null,
    title: '任务',
    btnCloseTip: '关闭',
    textBtnNew: '新建任务',
    textBtnRemove: '删除任务',
    container: null,
    titleBar: null,
      pid: 0,
    width: 300,
    height: 400,
    x: 0,
    y: 0,
    layer: 0,
    content: '',
    finishTask: '完成任务'
  };


  const template = [
    '<div class="note-title">',
    '   <h6>{{title}}</h6>',
    '   <a href="javascript:;" title="{{btnCloseTip}}" class="btn-close">&times;</a>',
    '</div>',
    '<div class="note-content" contenteditable="true"></div>',
    '<div class="note-footer">',
    '   <button class="btn-new">{{textBtnNew}}</button>',
    '   <button class="btn-finish">{{finishTask}}</button>',
    '   <button class="btn-remove">{{textBtnRemove}}</button>',
    '</div>'
  ].join('\n');

  function addEvent(el, type, fn) {
    var ieType = 'on' + type;
    if ('addEventListener' in window) {
      addEventListener.call(el, type, fn, false);
    } else if ('attachEvent' in el) {
      attachEvent.call(el, ieType, fn, false);
    } else {
      el[ieType] = fn;
    }
  }

  function removeEvent(el, type, fn) {
    var ieType = 'on' + type;
    if ('removeEventListener' in window) {
      removeEventListener.call(el, type, fn, false);
    } else if ('dispatchEvent' in el) {
      el.dispatch(ieType, fn);
    } else {
      el[ieType] = null;
    }
  }

  const store = {
    appId: 'stickyNote',
    data: {},
    get(id) {
      return store.data ? store.data[id] : {};
    },

    set(id, value) {
      store.data[id] = value;
    },

    remove(id) {
      delete store.data[id];
    },

    setup() {
      try {
        // store.data =  JSON.parse(localStorage[store.appId]) || {};
          var tempArr = {}
          var i = 1;
          var x = 0;
          var y = 0;
          unDelStatus.forEach(function (e) {
              if ((i - 1) % 10 === 0 && (i - 1) !== 0) {
                  x += 310;
                  y = 0;
              }
              var indent = (i - 1) / 10 / 5;
              if (indent >= 1 && (i - 1) / 10 % 5 === 0) {
                  x = 0;
              }
              tempArr[e.id] = { content: e.content, layer: i, postTime: e.create_at || 0, x: 80 + x, y: 80 + (y * 40) + (parseInt(indent) * 780), title: e.name, pid: e.pid }
              i ++;
              y ++;
          })
          console.log(tempArr)
          store.data = tempArr
      } catch(e) {
        store.data = {};
      }
      var data = store.data;
      if ( !isEmpty(data) ) {
        for(var k in data) {
          new StickyNote({
            root: document.body,
            id: k,
            x: data[k].x,
            y: data[k].y,
            title: data[k].title,
            layer: data[k].layer,
            content: data[k].content,
            pid: data[k].pid
          });
        }
      } else {
        // new StickyNote({
        //   root:document.body,
        //   // x: (document.documentElement.clientWidth - config.width) / 2,
        //   // y: document.documentElement.clientHeight- config.height,
        //     x: document.documentElement.clientWidth - config.width - 50,
        //     y: 80
        // });
      }
      window.onunload = function() {
        localStorage.setItem(store.appId, JSON.stringify(data));
      };
    },

    unsetup() {
      store.data = {};
      localStorage.removeItem(store.appId);
      window.onunload = null;
    }
  };

  function isEmpty(o) {
    if (typeof o === 'string' || Array.isArray(o) ) {
      return o.length === 0;
    } else if (typeof o === 'object') {
      for(let k in o) {
        if (!o.hasOwnProperty(k)) continue;
        return false;
      }
      return true;
    } else {
      return  o == null;
    }
  }

  var domReady = {
    tasks: [],
    isReady: false,
    ready: function(fn) {
      domReady.tasks.push(fn);
      if (domReady.isReady) {
        return domReady.completed();
      } else {
        addEvent(document, 'DOMContentLoaded', domReady.completed);
        addEvent(document, 'readystatechange', function() {
          if ( /^(?:interactive|complete)$/.test(document.readyState)) {
            domReady.completed();
            removeEvent(document, 'readystatechange', arguments.callee);
          }
        });
      }
    },
    completed: function() {
      removeEvent(document, 'DOMContentLoaded', domReady.completed);
      domReady.isReady = true;
      domReady.execTasks();
    },
    execTasks: function() {
      while( domReady.tasks.length ) {
        domReady.tasks.shift()();
      };
    }
  };
  domReady.ready(store.setup);
  window.store = store;
})();
