(function(t) {
    t.fn.tagsField = function(e) {
        var i = this
          , n = []
          , r = {
            label: "Tags",
            id: "tag-id",
            placeholder: "Add tag and hit tab or enter",
            maxlength: 20,
            maxTags: 10,
            labelColumnClass: "col-sm-12",
            divColumnClass: "col-sm-12",
            guid: Math.random().toString(36).substring(2) + (new Date).getTime().toString(36),
            onTagAdded: function() {}
        };
        e = t.extend({}, r, e);
        var o = '<label class="'.concat(e.labelColumnClass, '">').concat(e.label, '</label>\n                    <div class="').concat(e.divColumnClass, '">\n                        <input id="').concat(e.guid, '" class="form-control" type="text" placeholder="').concat(e.placeholder, '" autocomplete="off" maxlength="').concat(e.maxlength, '" value="">\n                        <ul class="parsley-errors-list" id="msg-error-tag-').concat(e.guid, '"><li class="parsley-required">This value is required.</li></ul>\n                        <div class="tag-container">\n                            <div class="clearfix"></div>\n                        </div>\n                    </div>')
          , s = "#" + e.guid;
        t(this).on("keydown", s, function(t) {
            9 != t.which && 13 != t.which || t.preventDefault()
        }),
        t(this).on("keyup", s, function(e) {
            if (9 == e.which || 13 == e.which)
                return e.preventDefault(),
                a(t(this).val(), !0),
                t(this).val(""),
                !1
        }),
        t(this).on("blur", s, function(e) {
            return a(t(this).val(), !0),
            t(this).val(""),
            !1
        });
        var a = function(i) {
            var r = arguments.length > 1 && void 0 !== arguments[1] && arguments[1];
            if ("" != i) {
                var o = l(i);
                if (r && 0 == o.checked)
                    return t.toast({
                        text: o.msg,
                        icon: "error",
                        loader: !1,
                        position: "top-right",
                        hideAfter: 5e3
                    }),
                    !1;
                n.push(i),
                e.onTagAdded.call(null, i),
                d()
            }
            u()
        }
          , l = function(t) {
            var i = {
                checked: !0,
                msg: ""
            };
            t.length > e.maxlength && (i = {
                checked: !1,
                msg: "Only " + e.maxlength + " chars are allowed per tag"
            });
            var n = c()
              , r = JSON.parse(n);
            return r.length >= 10 && (i = {
                checked: !1,
                msg: "Max of " + e.maxTags + " tags"
            }),
            r.forEach(function(e) {
                e == t && (i = {
                    checked: !1,
                    msg: "This tag already exists"
                })
            }),
            i
        };
        t(this).on("click", ".tag-element .tag-close", function(e) {
            var i = t(this).parent()
              , r = t(i).find(".tag-text").html();
            n = n.filter(function(t) {
                return t != r
            }),
            t(i).remove()
        });
        var c = function() {
            var e = t(s).siblings(".tag-container").find(".tag-element")
              , i = [];
            return e.each(function(e, n) {
                i.push(t(n).find(".tag-text").html())
            }),
            JSON.stringify(i)
        }
          , u = function() {
            t("#msg-error-tag-" + e.guid).removeClass("filled")
        }
          , h = function() {
            t("#msg-error-tag-" + e.guid).addClass("filled")
        }
          , f = function() {
            t(s).val("");
            var e = t(s).siblings(".tag-container").find(".tag-element");
            t.each(e, function(e, i) {
                t(i).remove()
            })
        }
          , d = function() {
            f(),
            n.forEach(function(e, i) {
                var n = t('<button class="tag-element btn-alt4 btn-space btn-sm">\n                            <span class="tag-text">Text</span>\n                            <span class="tag-close badge">X</span>\n                       </button>');
                t(n).find(".tag-text").html(e);
                var r = t(s).siblings(".tag-container").find(".clearfix");
                t(n).insertBefore(r)
            })
        };
        return this.getTags = function() {
            return c()
        }
        ,
        this.setTags = function(t) {
            Array.isArray(t) || (t = t.split(",")),
            t.forEach(function(t) {
                a(t, !0)
            })
        }
        ,
        this.clean = function() {
            f(),
            n = []
        }
        ,
        this.validate = function() {
            var t = c();
            return void 0 !== t && "" != t && "[]" != t || (h(),
            !1)
        }
        ,
        this.getInput = function() {
            return t(s)
        }
        ,
        this.showError = function() {
            h()
        }
        ,
        this.hideError = function() {
            u()
        }
        ,
        this.each(function() {
            t(i).addClass("form-group"),
            t(i).append(o),
            d()
        }),
        this
    }
}(jQuery));