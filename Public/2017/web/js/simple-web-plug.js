/**
 * 
 * @team SlipperClown (http://www.slippersclown.com/)
 * @developer Hacker丶Wand (578112964@qq.com)
 * @date    2017-06-02 14:12:59
 * @version $Id$
 */

function SimpleSliderScale(selector, options, context) {
    selector = selector || '#simple-slider-scale';
    var target = document.querySelector(selector);
    context = context || target;

    // 插件配置
    this.options = {
        min: 0, // 刻度最小值
        max: 100, // 刻度最大值
        scale: null, // 刻度尺子 示例：{10:'10个',20:'20个'}
        clickMove: false, // 点击刻度码移动刻度
        nearly: 0, // 取最近大/小刻度码,设置刻度位置
        siezNearly: false, // 根据距离舍近求远设置刻度位置 
        name: 'slider',
        change: function(scale) {} // 刻度变化回调函数
    };
    for (var i in options)
        this.options[i] = options[i];

    var self = this;
    this.value = this.options.min;

    this.dom = init();

    var isMove = false;
    var offsetLeft = [0, 0];
    var width = parseFloat(getStyle(this.dom.bar, 'width'));

    this.dom.slider.addEventListener('touchstart', function(e) {
        isMove = true;
        offsetLeft[1] = e.changedTouches[0].clientX;
        offsetLeft[0] = parseFloat(getStyle(self.dom.slider, 'left'));
        width = parseFloat(getStyle(self.dom.bar, 'width'));
    });
    this.dom.slider.addEventListener('touchend', function(e) {
        isMove = false;
        if (self.options.nearly && self.options.scale) {
            var t = self.value;

            if (self.options.nearly == 2) {
                for (var i in self.options.scale)
                    if (i >= self.value) {
                        t = i;
                        break;
                    }
            } else {
                for (var i in self.options.scale)
                    if (i <= self.value)
                        t = i;
            }
            self.setValue(t);

        } else if (self.options.siezNearly && self.options.scale) {
            var a, b;
            for (var i in self.options.scale)
                if (i >= self.value) {
                    b = i;
                    break;
                }
            for (var i in self.options.scale)
                if (i <= self.value)
                    a = i;
            self.setValue(Math.abs(self.value - a) < Math.abs(self.value - b) ? a : b);
        }
    });
    context.addEventListener('touchmove', function(e) {
        if (!isMove)
            return false;
        var scaleSize = parseFloat(self.options.max - self.options.min) / width;

        var sliderLeft = offsetLeft[0];
        sliderLeft += (e.changedTouches[0].clientX - offsetLeft[1]);
        self.setValue(sliderLeft * scaleSize + self.options.min);
    });
    if (this.options.scale && this.options.clickMove) {
        this.dom.scale.addEventListener('click', function(e) {
            var t = e.target || e.srcElement;
            if (t.tagName.toLowerCase() != 'span')
                return;
            self.setValue(t.getAttribute('scale-data'));
        });
    }

    this.setValue = function(scale) {
        scale = scale >= this.options.max ? this.options.max : scale;
        scale = scale <= this.options.min ? this.options.min : scale;

        var scaleSize = parseFloat(self.options.max - self.options.min) / width;
        var left = (scale - self.options.min) / scaleSize;

        self.dom.slider.style.left = (left >= width - parseFloat(getStyle(self.dom.slider, 'width')) ? width - parseFloat(getStyle(self.dom.slider, 'width')) : left) + 'px';

        self.dom.i.style.width = self.dom.slider.style.left;

        self.value = scale;
        self.dom.input.setAttribute('value', scale);
        self.options.change(parseInt(scale));
        return self;
    }

    function getStyle(el, attr) {
        return el.currenStyle ? el.currenStyle[attr] : getComputedStyle(el, null)[attr];
    }

    function init() {
        target.innerHTML = '';
        var bar = document.createElement('div');
        bar.classList.add('bar');
        var slider = document.createElement('div');
        slider.classList.add('slider');
        var i = document.createElement('i');
        i.style.width = '0%';
        bar.appendChild(slider);
        bar.appendChild(i);

        var scale = document.createElement('div');
        scale.classList.add('scale');

        for (var s in self.options.scale) {
            var sc = document.createElement('span');
            sc.innerText = self.options.scale[s];
            sc.style.left = ((s - self.options.min) / (self.options.max - self.options.min) * 100) + '%';
            sc.setAttribute('scale-data', s);
            scale.appendChild(sc);
        }

        target.appendChild(bar);
        target.appendChild(scale);

        var input = document.createElement('input');
        input.setAttribute('type', 'text');
        input.setAttribute('style', 'display:none;');
        input.setAttribute('name', self.options.name);
        input.setAttribute('value', self.value);
        target.appendChild(input);
        return {
            bar: bar,
            slider: slider,
            scale: scale,
            i: i,
            input: input
        }
    }
}

function SimpleProgress(topic, clickBind) {
    topic = topic || '进度提示';
    clickBind = clickBind || {};

    var root = initDom();
    var self = this;

    this.hide = function() {
        root.root.style.opacity = 0;
        setTimeout(function() {
            root.root.style.display = "none";
        }, 300);
    }

    this.update = function(plan) {
        root.root.style.display = "block";
        root.root.style.opacity = "1";
        plan = parseFloat(plan);
        if (isNaN(plan)) {
            plan = 0;
            console.log('simple-progress update 参数只能为数字');
        }
        root.span.innerText = plan + '%';
        root.i.style.width = plan + '%';
        if (plan >= 99)
            this.hide();
    }

    function initDom() {
        var root = document.createElement('div');
        root.classList.add('simple-progress');

        var progress = document.createElement('div');
        progress.classList.add('progress'); {
            var h1 = document.createElement('h1');
            h1.innerText = topic;
            var plan = document.createElement('div');
            plan.classList.add('plan'); {
                var div = document.createElement('div');
                div.style.width = "0%";
                var span = document.createElement('span');
                span.innerText = '0%';
                plan.appendChild(div);
                plan.appendChild(span);
            }
            progress.appendChild(plan);
            progress.appendChild(h1);

            var butList = document.createElement('div');
            butList.classList.add('but-list');
            for (var i in clickBind) {
                var a = document.createElement('a');
                a.setAttribute('href', 'javascript:;');
                a.innerText = clickBind[i].text;
                a.addEventListener('click', clickBind[i].fun);
                butList.appendChild(a);
            }
            progress.appendChild(butList);
        }
        root.appendChild(progress);

        document.getElementsByTagName('body')[0].appendChild(root);
        root.style.opacity = 1;
        return {
            "root": root,
            "h1": h1,
            "plan": plan,
            "i": div,
            "span": span,
            "progress": progress,
            "butList": butList
        };
    }
}

function SimpleUpload(selector, options) {
    selector = selector || '#simple-upload';

    this.options = {
        multiple: false,
        xhr: new XMLHttpRequest(),
        method: 'POST',
        url: '',
        asyn: true,
        useSimpleProgress: true,
        progress: null
    }, options = options || {};

    for (var i in options)
        this.options[i] = options[i];

    var root = document.querySelector(selector);

    var fileName = root.getAttribute('name');
    var formData = new FormData();

    var fileInput = document.createElement('input');
    fileInput.setAttribute('type', 'file');
    fileInput.setAttribute('id', selector + '-file-input');
    fileInput.setAttribute('multiple', this.options.multiple);
    fileInput.style.display = 'none';
    document.getElementsByTagName('body')[0].appendChild(fileInput);

    this.fileChange = function(file) {
        return true;
    }
    this.click = function(e) {
        return true;
    }
    this.onreadystatechange = function(e) {};
    this.done = function() {}
    this.error = function() {}

    root.onclick = (function(self) {
        return function(event) {
            if (!self.click(event))
                return false;
            var e = document.createEvent("MouseEvents");
            e.initEvent("click", true, true);
            fileInput.dispatchEvent(e);
            return false;
        }
    })(this);

    this.options.xhr.onreadystatechange = (function(self) {
        return function() {
            self.onreadystatechange(self.options.xhr.readyState, self.options.xhr.status);
            if (self.options.xhr.readyState == 4) {
                if (self.options.xhr.status == 200)
                    self.options.done(self.options.xhr.response, self.options.xhr.status, self.options.xhr);
                else
                    self.options.error(self.options.xhr.response, self.options.xhr.status, self.options.xhr);
                if (self.options.progress)
                    self.options.progress.hide();
            }
        }
    })(this);

    fileInput.onchange = (function(self) {
        return function() {
            if (this.files.length < 1)
                return;
            formData = new FormData();
            for (var i = 0; i < this.files.length; i++) {
                if (!self.fileChange(this.files[i]))
                    continue;
                formData.append(fileName + (options.multiple ? '[' + i + ']' : ''), this.files[i]);
            }

            if (!self.options.progress && self.options.useSimpleProgress && typeof SimpleProgress !== 'undefined') {
                self.options.progress = new SimpleProgress('文件上传进度提示');
            }
            self.options.xhr.open(self.options.method, self.options.url, self.options.asyn);
            self.options.xhr.send(formData);
        }
    })(this);

    this.options.xhr.upload.onprogress = (function(self) {
        return function(e) {
            if (self.options.progress)
                self.options.progress.update(100 * (e.loaded / e.total));
        }
    })(this);
}
