(function($) {
   $.tagsField = function(e) {
        e = $.extend({}, {
            label: "Tags",
            id: "tag-id",
            placeholder: "Add tag and hit tab or enter",
            maxlength: 20,
            maxTags: 10,
            labelColumnClass: "col-sm-12",
            divColumnClass: "col-sm-12",
            onTagAdded: function() {}
        }, e);
        var i = '<label class="'.concat(e.labelColumnClass, '">').concat(e.label, '</label>\n                    <div class="').concat(e.divColumnClass, '">\n                        <input id="').concat(e.id, '" class="form-control" type="text" parsley-trigger="change" placeholder="').concat(e.placeholder, '" autocomplete="off" maxlength="').concat(e.maxlength, '" value="">\n                        <div class="tag-container">\n                            <div class="clearfix"></div>\n                        </div>\n                    </div>')
          , n = "#" + e.id;
        t(document).on("keydown", n, function(e) {
            if (9 == e.which || 13 == e.which)
                return r(t(this).val(), !0),
                t(this).val(""),
                !1
        });
        var r = function(i) {
            var r = 1 < arguments.length && void 0 !== arguments[1] && arguments[1];
            if ("" != i) {
                var o = s(i);
                if (r && 0 == o.checked)
                    return $.toast({
                        text: o.msg,
                        icon: "error",
                        loader: !1,
                        position: "top-right",
                        hideAfter: 5e3
                    }),
                    !1;
                var a = t('<div class="tag-element btn btn-alt4 btn-space btn-sm">\n                            <span class="tag-text">Text</span>\n                            <span class="tag-close badge">X</span>\n                       </div>');
                t(a).find(".tag-text").html(i);
                var l = t(n).siblings(".tag-container").find(".clearfix");
                t(a).insertBefore(l),
                e.onTagAdded.call(null, i)
            }
        }
          , s = function(t) {
            var i = {
                checked: !0,
                msg: ""
            };
            $.length > e.maxlength && (i = {
                checked: !1,
                msg: "Only " + e.maxlength + " chars are allowed per tag"
            });
            var n = o()
              , r = JSON.parse(n);
            return 10 <= r.length && (i = {
                checked: !1,
                msg: "Max of " + e.maxTags + " tags"
            }),
            r.forEach(function(e) {
                e == t && (i = {
                    checked: !1,
                    msg: "This tag already exist"
                })
            }),
            i
        };
        t(document).on("click", ".tag-element .tag-close", function(e) {
            var i = t(this).parent();
            t(i).remove()
        });
        var o = function() {
            var e = t(n).siblings(".tag-container").find(".tag-element")
              , i = [];
            return e.each(function(e, n) {
                i.push(t(n).find(".tag-text").html())
            }),
            JSON.stringify(i)
        };
        return this.each(function() {
            t(this).addClass("form-group"),
            t(this).append(i)
        }),
        this.getTags = function() {
            return o()
        }
        ,
        this.setTags = function(t) {
            Array.isArray(t) || (t = $.split(",")),
            $.forEach(function(t) {
                r(t, !0)
            })
        }
        ,
        this.clean = function(e) {
            t(n).val("");
            var i = t(n).siblings(".tag-container").find(".tag-element");
            $.each(i, function(e, i) {
                t(i).remove()
            })
        }
        ,
        this
    }
}(jQuery));