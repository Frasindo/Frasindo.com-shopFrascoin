/*!
 * Uploader v0.1.1
 * https://github.com/fengyuanchen/uploader
 *
 * Copyright (c) 2014-2016 Fengyuan Chen
 * Released under the MIT license
 *
 * Date: 2016-07-13T06:41:02.002Z
 */
! function(e) { "function" == typeof define && define.amd ? define("uploader", ["jquery"], e) : e("object" == typeof exports ? require("jquery") : jQuery) }(function(e) { "use strict";

    function t(n, o) { this.$element = e(n), this.options = e.extend(!0, {}, t.DEFAULTS, e.isPlainObject(o) && o), this.disabled = !1, this.sync = !1, this.queues = 0, this.init() } var n = window.FormData,
        o = "uploader",
        i = "change." + o,
        s = "dragover." + o,
        a = "drop." + o,
        r = "upload." + o,
        l = "start." + o,
        d = "progress." + o,
        u = "done." + o,
        p = "fail." + o,
        c = "end." + o,
        f = "uploaded." + o;
    t.prototype = { constructor: t, init: function() { var t = this.options,
                o = this.$element;
            t.name || (t.name = o.attr("name") || "file"), t.dropzone && (this.$dropzone = e(t.dropzone)), n || (this.sync = !0, this.$clone = o.clone()), this.bind() }, bind: function() { var t = this.options,
                n = this.$element;
            e.isFunction(t.upload) && n.on(r, t.upload), e.isFunction(t.start) && n.on(l, t.start), e.isFunction(t.progress) && n.on(d, t.progress), e.isFunction(t.done) && n.on(u, t.done), e.isFunction(t.fail) && n.on(p, t.fail), e.isFunction(t.end) && n.on(c, t.end), e.isFunction(t.uploaded) && n.on(f, t.uploaded), n.on(i, e.proxy(this.change, this)), t.dropzone && this.$dropzone.on(s, e.proxy(this.dragover, this)).on(a, e.proxy(this.drop, this)) }, unbind: function() { var t = this.options,
                n = this.$element;
            e.isFunction(t.upload) && n.off(r, t.upload), e.isFunction(t.start) && n.off(l, t.start), e.isFunction(t.progress) && n.off(d, t.progress), e.isFunction(t.done) && n.off(u, t.done), e.isFunction(t.fail) && n.off(p, t.fail), e.isFunction(t.end) && n.off(c, t.end), e.isFunction(t.uploaded) && n.off(f, t.uploaded), n.off(i, this.change), t.dropzone && this.$dropzone.off(s, this.dragover).off(a, this.drop) }, change: function() { this.options.autoUpload && this.upload() }, dragover: function(e) { e.preventDefault() }, drop: function(e) { var t = e.originalEvent;
            e.preventDefault(), t.dataTransfer && this.upload(t.dataTransfer.files) }, upload: function(t) { var n, o = this.$element;
            t = t || o.prop("files"), (t && t.length || o.val()) && (n = e.Event(r, { files: t }), o.trigger(n), n.isDefaultPrevented() || (t && t.length ? this.start(t) : o.val() && this.start())) }, start: function(t) { var n, o = this.options,
                i = this.$element,
                s = this; if (!this.disabled) { if (!this.sync && o.singleUpload && t && t.length) return this.disabled = !0, i.prop("disabled", !1), void e.each(t, function(t, n) { var o = e.Event(l, { index: t, files: [n] });
                    i.trigger(o), o.isDefaultPrevented() || (s.queues++, s.ajaxUpload(n, t)) });
                n = e.Event(l, { index: 0, files: t }), i.trigger(n), n.isDefaultPrevented() || (this.disabled = !0, this.sync ? this.syncUpload() : (i.prop("disabled", !1), this.ajaxUpload(t))) } }, ajaxUpload: function(t, o) { var i, s = this.options,
                a = this.$element,
                r = new n,
                l = this;
            e.isPlainObject(s.data) && e.each(s.data, function(e, t) { r.append(e, t) }), r.append(s.name, t), i = e.extend({}, s, { method: s.method || "POST", data: r, processData: !1, contentType: !1, success: function(e, t, n) { l.success(e, t, n, this, o) }, error: function(e, t, n) { l.error(e, t, n, this, o) }, complete: function(e, t) { l.complete(e, t, this, o) } }), e.isFunction(s.progress) && (i.xhr = function() { var t = new XMLHttpRequest; return t.upload && (t.upload.onprogress = function(t) { a.trigger(e.Event(d, { index: o, lengthComputable: t.lengthComputable, total: t.total, loaded: t.loaded })) }), t }), e.ajax(i.url, i) }, syncUpload: function() { var t = this.$element,
                n = this.$clone,
                i = this.options,
                s = (new Date).getTime(),
                a = o + s,
                r = function() { var t = []; return e.isPlainObject(i.data) && e.each(i.data, function(e, n) { t.push('<input type="hidden" name="' + e + '" value="' + n + '">') }), t.join("") }(),
                l = e("<form>").attr({ method: i.method || "POST", action: function(e) { return e + (e.indexOf("?") === -1 ? "?" : "&") + "timestamp=" + s }(i.url), enctype: "multipart/form-data", target: a }),
                u = e("<iframe>").attr({ name: a, src: "" }),
                p = { lengthComputable: !0, total: 100, loaded: 0 },
                c = !1,
                f = function() { c ? p.loaded = 100 : p.loaded < 100 && (p.loaded += (100 - p.loaded) / 10, setTimeout(f, 500)), t.trigger(e.Event(d, p)) },
                h = this;
            u.one("load", function() { u.one("load", function() { var o, i; try { i = e(this).contents().find("body").text(), "json" === h.options.dataType && (i = e.parseJSON(i)) } catch (s) { o = s.message }
                    o ? h.error(null, "error", o, null, 0) : h.success(i, "success", null, null, 0), c = !0, l.get(0).reset(), n.after(t).detach(), l.empty().remove(), h.complete(null, "complete", null, 0) }), t.after(n), l.append(r), l.append(t), l.one("submit", f).submit() }), l.append(u).hide().appendTo("body") }, success: function(t, n, o, i, s) { var a = this.options;
            e.isFunction(a.success) && a.success.call(i, t, n, o), this.$element.trigger(e.Event(u, { index: s }), t, n) }, error: function(t, n, o, i, s) { var a = this.options;
            e.isFunction(a.error) && a.error.call(i, t, n, o), this.$element.trigger(e.Event(p, { index: s }), n, o) }, complete: function(t, n, o, i) { var s = this.options,
                a = this.$element,
                r = !1,
                l = e.proxy(function() { r = !0, this.disabled = !1, a.prop("disabled", !1), this.reset() }, this);!this.sync && this.queues ? (this.queues--, this.queues || l()) : l(), e.isFunction(s.complete) && s.complete.call(o, t, n), a.trigger(e.Event(c, { index: i }), n), r && a.trigger(f) }, reset: function() { var t, n = this.$element,
                o = this.$clone;
            n.val(""), n.val() && (t = e("<form>"), n.after(o), t.append(n).hide().appendTo("body").get(0).reset(), o.after(n).detach(), t.remove()) }, destroy: function() { this.unbind(), this.$element.removeData(o) } }, t.DEFAULTS = { name: "", url: "", data: null, autoUpload: !0, singleUpload: !0, dropzone: "", upload: null, start: null, progress: null, done: null, fail: null, end: null, uploaded: null }, t.setDefaults = function(n) { e.extend(!0, t.DEFAULTS, n) }, t.other = e.fn.uploader, e.fn.uploader = function(n) { var i = [].slice.call(arguments, 1); return this.each(function() { var s, a = e(this),
                r = a.data(o); if (!r) { if (/destroy/.test(n)) return;
                a.data(o, r = new t(this, n)) } "string" == typeof n && e.isFunction(s = r[n]) && s.apply(r, i) }) }, e.fn.uploader.Constructor = t, e.fn.uploader.setDefaults = t.setDefaults, e.fn.uploader.noConflict = function() { return e.fn.uploader = t.other, this } });