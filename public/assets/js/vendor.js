var App = function() {
    "use strict";
    var t, e, i, n, r = {
        assetsPath: "assets",
        imgPath: "img",
        jsPath: "js",
        libsPath: "lib",
        leftSidebarSlideSpeed: 200,
        enableSwipe: !0,
        swipeTreshold: 100,
        scrollTop: !0,
        openLeftSidebarClass: "open-left-sidebar",
        openRightSidebarClass: "open-right-sidebar",
        removeLeftSidebarClass: "am-nosidebar-left",
        openLeftSidebarOnClick: !0,
        openLeftSidebarOnClickClass: "am-left-sidebar--click",
        transitionClass: "am-animate",
        openSidebarDelay: 400,
        syncSubMenuOnHover: !1
    }, s = {}, o = !1, a = $("html").hasClass("rtl");
    function l(t) {
        var e = $("<div>", {
            class: t
        }).appendTo("body")
          , i = e.css("background-color");
        return e.remove(),
        i
    }
    function h() {
        var n = $(".sidebar-elements > li > a", i)
          , s = !(!i.hasClass(r.openLeftSidebarOnClickClass) && !r.openLeftSidebarOnClick);
        function a(t) {
            var e = $(".sidebar-elements > li", i);
            void 0 !== t && (e = t),
            $.each(e, function(t, e) {
                var i = $(this).find("> ul")
                  , n = $("> li", i)
                  , r = $('<li class="nav-items"><div class="am-scroller nano"><div class="content nano-content"><ul></ul></div></div></li>');
                !i.find("> li.title").length > 0 && (n.appendTo(r.find(".content ul")),
                r.appendTo(i))
            })
        }
        function l() {
            t.removeClass(r.openLeftSidebarClass).addClass(r.transitionClass),
            u()
        }
        function h(t, e, n) {
            var s = $(t).parent()
              , o = s.find(".am-scroller")
              , l = s.find("> ul")
              , h = s.hasClass("open");
            $.isXs() || ($("ul.visible", i).removeClass("visible").parent().removeClass("open"),
            (!n || n && !h) && (s.addClass("open"),
            l.addClass("visible")),
            l.removeClass("hide")),
            o.nanoScroller({
                destroy: !0
            }),
            o.nanoScroller(),
            n ? s.hasClass("parent") && e.preventDefault() : r.syncSubMenuOnHover && a(s)
        }
        if (a(),
        $(".am-toggle-left-sidebar").on("click", function(e) {
            o && t.hasClass(r.openLeftSidebarClass) ? l() : o || (t.addClass(r.openLeftSidebarClass + " " + r.transitionClass),
            o = !0),
            e.stopPropagation(),
            e.preventDefault()
        }),
        $(document).on("touchstart mousedown", function(e) {
            !$(e.target).closest(i).length && t.hasClass(r.openLeftSidebarClass) ? l() : $(e.target).closest(i).length || $.isXs() || $("ul.visible", i).removeClass("visible").parent().removeClass("open")
        }),
        s ? n.on("click", function(t) {
            $.isXs() || h(this, t, !0)
        }) : (n.on("mouseover", function(t) {
            h(this, t, !1)
        }),
        n.on("touchstart", function(t) {
            $.isXs() || h(this, t, !0)
        }),
        n.on("mouseleave", function() {
            var t = $(this)
              , e = t.parent()
              , i = e.find("> ul");
            $.isXs() || (i.length > 0 ? setTimeout(function() {
                i.is(":hover") ? i.on("mouseleave", function() {
                    setTimeout(function() {
                        t.is(":hover") || (i.removeClass("visible"),
                        e.removeClass("open"),
                        i.off("mouseleave"))
                    }, 300)
                }) : (i.removeClass("visible"),
                e.removeClass("open"))
            }, 300) : e.removeClass("open"))
        })),
        $(".sidebar-elements li a", i).on("click", function(t) {
            if ($.isXs()) {
                var e, n = $(this), o = r.leftSidebarSlideSpeed, a = n.parent(), l = n.next();
                (e = a.siblings(".open")) && e.find("> ul:visible").slideUp({
                    duration: o,
                    complete: function() {
                        e.toggleClass("open"),
                        $(this).removeAttr("style").removeClass("visible")
                    }
                }),
                a.hasClass("open") ? l.slideUp({
                    duration: o,
                    complete: function() {
                        a.toggleClass("open"),
                        $(this).removeAttr("style").removeClass("visible")
                    }
                }) : l.slideDown({
                    duration: o,
                    complete: function() {
                        a.toggleClass("open"),
                        $(this).removeAttr("style").addClass("visible")
                    }
                }),
                n.next().is("ul") && t.preventDefault()
            } else {
                if (!s)
                    $(".sidebar-elements > li > ul:visible", i).addClass("hide")
            }
        }),
        $("li.active", i).parents(".parent").addClass("active"),
        e.hasClass("am-fixed-sidebar")) {
            var c = $(".am-left-sidebar > .content");
            c.wrap('<div class="am-scroller nano"></div>'),
            c.addClass("nano-content"),
            c.parent().nanoScroller()
        }
        $(window).resize(function() {
            g(function() {
                if (!$.isXs()) {
                    var t = $(".am-scroller");
                    $(".nano-content", t).css({
                        "margin-right": 0
                    }),
                    t.nanoScroller({
                        destroy: !0
                    }),
                    t.nanoScroller()
                }
            }, 500, "am_check_phone_classes")
        })
    }
    function c() {
        function e() {
            t.removeClass(r.openRightSidebarClass).addClass(r.transitionClass),
            u()
        }
        n.length > 0 && ($(".am-toggle-right-sidebar").on("click", function(i) {
            o && t.hasClass(r.openRightSidebarClass) ? e() : o || (t.addClass(r.openRightSidebarClass + " " + r.transitionClass),
            o = !0),
            i.stopPropagation(),
            i.preventDefault()
        }),
        $(document).on("mousedown touchstart", function(i) {
            !$(i.target).closest(n).length && t.hasClass(r.openRightSidebarClass) && e()
        }))
    }
    function u() {
        o = !0,
        setTimeout(function() {
            o = !1
        }, r.openSidebarDelay)
    }
    function f() {
        var t = $(".am-right-sidebar .tab-pane.chat")
          , e = $(".chat-contacts", t)
          , i = $(".chat-window", t)
          , n = $(".chat-messages", i)
          , r = $(".content > ul", n)
          , s = $(".nano-content", n)
          , o = $(".chat-input", i)
          , a = $("input", o)
          , l = $(".send-msg", o);
        function h(t, e) {
            var i = $('<li class="' + (e ? "self" : "friend") + '"></li>');
            "" != t && ($('<div class="msg">' + t + "</div>").appendTo(i),
            i.appendTo(r),
            s.stop().animate({
                scrollTop: s.prop("scrollHeight")
            }, 900, "swing"),
            d())
        }
        $(".user a", e).on("click", function(i) {
            $(".am-scroller", e).nanoScroller({
                stop: !0
            }),
            t.hasClass("chat-opened") || (t.addClass("chat-opened"),
            $(".am-scroller", n).nanoScroller()),
            i.preventDefault()
        }),
        $(".title .return", i).on("click", function(e) {
            t.hasClass("chat-opened") && t.removeClass("chat-opened"),
            d()
        }),
        a.keypress(function(t) {
            var e = t.keyCode ? t.keyCode : t.which
              , i = $(this).val();
            "13" == e && (h(i, !0),
            $(this).val("")),
            t.stopPropagation()
        }),
        l.on("click", function() {
            h(a.val(), !0),
            a.val("")
        })
    }
    function d() {
        $(".am-scroller").nanoScroller()
    }
    var p, g = (p = {},
    function(t, e, i) {
        i || (i = "x1x2x3x4"),
        p[i] && clearTimeout(p[i]),
        p[i] = setTimeout(t, e)
    }
    );
    return {
        conf: r,
        color: s,
        init: function(u) {
            var p;
            e = $(".am-wrapper"),
            i = $(".am-left-sidebar"),
            n = $(".am-right-sidebar"),
            t = $("body"),
            $.extend(r, u),
            h(),
            FastClick.attach(document.body),
            c(),
            f(),
            r.enableSwipe && function() {
                var i = !1;
                function s() {
                    o || e.hasClass(r.removeLeftSidebarClass) || (t.addClass(r.openLeftSidebarClass + " " + r.transitionClass),
                    o = !0)
                }
                function l() {
                    !o && n.length > 0 && (t.addClass(r.openRightSidebarClass + " " + r.transitionClass),
                    o = !0)
                }
                e.swipe({
                    allowPageScroll: "vertical",
                    preventDefaultEvents: !1,
                    fallbackToMouseEvents: !1,
                    swipeRight: function(t) {
                        a ? l() : s()
                    },
                    swipeLeft: function(t) {
                        a ? s() : l()
                    },
                    swipeStatus: function(t, e) {
                        switch (e) {
                        case "start":
                            o && (i = !0);
                            break;
                        case "end":
                            if (i)
                                return i = !1,
                                !1;
                            break;
                        case "cancel":
                            i = !1
                        }
                    },
                    threshold: r.swipeTreshold
                })
            }(),
            i.on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function() {
                t.removeClass(r.transitionClass)
            }),
            r.scrollTop && ((p = $('<div class="am-scroll-top"></div>')).appendTo("body"),
            $(window).on("scroll", function() {
                $(this).scrollTop() > 220 ? p.fadeIn(500) : p.fadeOut(500)
            }),
            p.on("touchstart mouseup", function(t) {
                $("html, body").animate({
                    scrollTop: 0
                }, 500),
                t.preventDefault()
            })),
            s.primary = l("clr-primary"),
            s.success = l("clr-success"),
            s.info = l("clr-info"),
            s.warning = l("clr-warning"),
            s.danger = l("clr-danger"),
            s.alt1 = l("clr-alt1"),
            s.alt2 = l("clr-alt2"),
            s.alt3 = l("clr-alt3"),
            s.alt4 = l("clr-alt4"),
            $(".am-connections").on("click", function(t) {
                t.stopPropagation()
            }),
            d(),
            $(".dropdown").on("shown.bs.dropdown", function() {
                $(".am-scroller").nanoScroller()
            }),
            $(".nav-tabs").on("shown.bs.tab", function(t) {
                $(".am-scroller").nanoScroller()
            }),
            $('[data-toggle="tooltip"]').tooltip(),
            $('[data-toggle="popover"]').popover(),
            $(".modal").on("show.bs.modal", function() {
                $("html").addClass("am-modal-open")
            }),
            $(".modal").on("hidden.bs.modal", function() {
                $("html").removeClass("am-modal-open")
            })
        },
        leftSidebarInit: h,
        rightSidebarInit: c,
        closeSubMenu: function() {
            var t = $(".sidebar-elements > li > ul:visible", i);
            t.addClass("hide"),
            setTimeout(function() {
                t.removeClass("hide")
            }, 50)
        }
    }
}();

$(document).ready(function($){
    $.isBreakpoint = function(e) {
        var i, n;
        return n = (i = $("<div/>", {
            class: "visible-" + e
        }).appendTo("body")).is(":visible"),
        i.remove(),
        n
    },
    $.extend($, {
        isXs: function() {
            return $.isBreakpoint("xs")
        },
        isSm: function() {
            return $.isBreakpoint("sm")
        },
        isMd: function() {
            return $.isBreakpoint("md")
        },
        isLg: function() {
            return $.isBreakpoint("lg")
        }
    });
});