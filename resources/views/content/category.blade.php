@extends('layouts.frontend')

@section('title', $category_obj->name.' Templates | Designer Online | Wayak')

@section('css')
    <style>
        body {
            font-size: 16px;
        }
    </style>
    <style>
        @media all {
            .row {
                margin-left: -12px;
                margin-right: -12px;
            }
            .row.margin-top-40-40-24 {
                margin-top: 40px;
            }
            .row.margin-top-80-56-32 {
                margin-top: 80px;
            }
            .row.margin-top-80-56-0 {
                margin-top: 80px;
            }
            .top-112 img {
                margin-top: -112px;
            }
            #main_content {
                overflow: hidden;
            }
            body {
                color: #272b35;
                font-size: 16px;
                line-height: 24px;
            }
            #main_content h1,
            #main_content h2,
            #main_content h3 {
                /* font-family: "Fugue Regular"; */
                margin-top: 0;
            }
            #main_content .h-lg-64 {
                font-size: 64px;
                line-height: 100%;
            }
            #main_content .h-lg-56 {
                font-size: 56px;
                line-height: 100%;
            }
            #main_content .h-lg-40 {
                font-size: 40px;
                line-height: 100%;
            }
            #main_content .h-lg-32 {
                font-size: 32px;
                line-height: 100%;
            }
            #main_content p {
                font-size: 16px;
                line-height: 24px;
                margin-top: 16px;
            }
            #main_content {
                margin-bottom: 0;
            }
            #main_content h1 {
                font-weight: 400;
                font-size: 64px;
                line-height: 64px;
                color: #272b35;
            }
            #main_content h2 {
                font-weight: 400;
                font-size: 40px;
                line-height: 40px;
                color: #272b35;
            }
            #main_content h3 {
                font-weight: 400;
                font-size: 40px;
                line-height: 40px;
            }
            #main_content .row h2 {
                margin: 0 auto;
            }
            #main_content .vc_btn3-container.vc_btn3-inline {
                margin-top: 32px;
                margin-bottom: 0;
            }
            #main_content a.vc_general.vc_btn3-style-btn-crello {
                font-weight: 400;
                font-size: 16px;
                line-height: 24px;
                padding: 12px 24px;
                border-radius: 8px;
                background-image: none;
            }
            #main_content .padding-44 a.vc_general.vc_btn3-style-btn-crello {
                padding: 12px 44px;
            }
            #main_content a.vc_general.vc_btn3-style-btn-crello.vc_btn3-color-btn-yellow {
                background-color: #ffde4e;
                color: #121110;
            }
            #main_content a.vc_general.vc_btn3-style-btn-crello.vc_btn3-color-btn-yellow:hover {
                background-color: #fdd319;
            }
            #main_content a.vc_general.vc_btn3-style-btn-crello.vc_btn3-color-btn-blue {
                background-color: #2153cc;
                color: #fff;
            }
            #main_content a.vc_general.vc_btn3-style-btn-crello.vc_btn3-color-btn-blue:hover {
                background-color: #0f3cb4;
            }
            section#main_content {
                margin-top: 64px;
                margin-bottom: 0;
            }
            #main_content .wpb_content_element {
                margin-bottom: 0;
            }
            .wpb-js-composer .vc_tta.vc_general .vc_tta-panel-body {
                overflow: initial!important;
            }
            #main_content .vc_tta-container {
                margin-bottom: 0;
                margin-top: 24px;
            }
            .wpb-js-composer .vc_tta.vc_tta-o-no-fill.vc_tta-tabs .vc_tta-tabs-container {
                width: 100%;
                overflow-x: scroll;
                overflow: -moz-hidden-unscrollable;
                -ms-overflow-style: none;
            }
            .wpb-js-composer .vc_tta.vc_general div.vc_tta-panel-body {
                padding: 60px 0;
            }
            .wpb-js-composer .vc_tta.vc_tta-o-no-fill.vc_tta-tabs .vc_tta-tabs-container::-webkit-scrollbar {
                width: 0!important;
            }
            .wpb-js-composer .vc_tta.vc_tta-o-no-fill.vc_tta-tabs span.scroll_forward,
            .wpb-js-composer .vc_tta.vc_tta-o-no-fill.vc_tta-tabs span.scroll_back {
                display: none;
            }
            ul.vc_tta-tabs-list {
                width: max-content;
                margin: 0 auto!important;
            }
            ul.vc_tta-tabs-list li {
                width: auto;
            }
            ul.vc_tta-tabs-list li a {
                background: #fbf8f5!important;
                margin-top: 0!important;
                border: none!important;
                border-radius: 8px!important;
                margin: 0 4px;
                padding: 0 16px 10px 8px!important;
            }
            ul.vc_tta-tabs-list li.vc_active a {
                background: #2153cc!important;
            }
            ul.vc_tta-tabs-list li a span {
                font-size: 14px;
                line-height: 21px;
                color: #121110;
            }
            ul.vc_tta-tabs-list li.vc_active a span {
                color: #fff;
            }
            ul.vc_tta-tabs-list li a span:before {
                content: "";
                display: inline-block;
                width: 24px;
                height: 24px;
                position: relative;
                top: 8px;
                right: 8px;
                margin-left: 16px;
            }
            .tabs-design-2.vc_tta.vc_general div.vc_tta-panel-body {
                padding-top: 28px;
            }
            .tabs-design-2 ul.vc_tta-tabs-list li a span {
                font-size: 16px;
                line-height: 24px;
                font-weight: 600;
            }
            .tabs-design-2 ul.vc_tta-tabs-list li a {
                background-color: #f5eee7!important;
                padding: 0 24px 8px!important;
            }
            .tabs-design-2 ul.vc_tta-tabs-list li.vc_active a,
            .tabs-design-2 ul.vc_tta-tabs-list li.vc_active a:hover {
                background-color: #2153cc!important;
                border: 2px solid #2153cc!important;
            }
            .tabs-design-2 ul.vc_tta-tabs-list li a span {
                color: #91949c;
            }
            .tabs-design-2 ul.vc_tta-tabs-list li.vc_active a span {
                color: #fff;
            }
            .tabs-design-2 ul.vc_tta-tabs-list li a span:before {
                width: 0;
                margin-left: 0;
            }
            .row.three-million-users {
                border-radius: 12px;
            }
            #main_content .three-million-users .vc_btn3-container.vc_btn3-center {
                margin-bottom: 0;
            }
            @media screen and (min-width:1280px) {
                section#main_content {
                    margin-top: 64px;
                }
            }
            @media screen and (max-width:992px) {
                .top-112 img {
                    margin-top: auto;
                }
            }
            @media screen and (max-width:768px) {
                #main_content h1 {
                    font-size: 48px;
                    line-height: 48px;
                }
                #main_content h3 {
                    font-size: 32px;
                    line-height: 32px;
                }
                .row.margin-top-40-40-24 {
                    margin-top: 40px;
                }
                .row.margin-top-80-56-32 {
                    margin-top: 56px;
                }
                .row.margin-top-80-56-0 {
                    margin-top: 56px;
                }
                #main_content .h-md-48-56 {
                    font-size: 48px;
                    line-height: 56px;
                }
                #main_content .h-md-40-48 {
                    font-size: 40px;
                    line-height: 48px;
                }
                #main_content .h-md-40 {
                    font-size: 40px;
                    line-height: 100%;
                }
                #main_content .h-md-32 {
                    font-size: 32px;
                    line-height: 100%;
                }
                .vc_empty_space.space-md-56 {
                    height: 56px!important;
                }
                .vc_empty_space.space-md-48 {
                    height: 48px!important;
                }
                .vc_empty_space.space-md-32 {
                    height: 32px!important;
                }
                .vc_empty_space.space-md-24 {
                    height: 24px!important;
                }
                .vc_empty_space.space-md-0 {
                    height: 0!important;
                }
                .top-112 img {
                    margin-top: auto;
                }
                .tablet-text-align-center {
                    text-align: center;
                }
                #main_content .container {
                    padding-right: 24px;
                    padding-left: 24px;
                }
                #main_content h2 {
                    font-size: 48px;
                    line-height: 48px;
                }
                .wpb-js-composer .vc_tta.vc_tta-tabs .vc_tta-tabs-container {
                    display: block!important;
                }
                .wpb-js-composer .vc_tta.vc_tta-tabs .vc_tta-tabs-container ul.vc_tta-tabs-list li a {
                    width: max-content;
                }
                .wpb-js-composer .vc_tta.vc_general .vc_tta-panel .vc_tta-panel-heading {
                    display: none!important;
                }
                ul.vc_tta-tabs-list {
                    width: max-content;
                }
                .wpb-js-composer .vc_tta.vc_tta-o-no-fill.vc_tta-tabs .vc_tta-tabs-container {
                    width: calc(100% - 40px);
                    overflow-x: scroll;
                    margin-left: 20px!important;
                }
                .wpb-js-composer .vc_tta.vc_general div.vc_tta-panel-body {
                    padding: 14px 0 40px;
                }
                .row.three-million-users {
                    border-radius: 8px;
                }
            }
            @media screen and (max-width:414px) {
                .row.margin-top-40-40-24 {
                    margin-top: 24px;
                }
                .row.margin-top-80-56-32 {
                    margin-top: 32px;
                }
                .row.margin-top-80-56-0 {
                    margin-top: 0;
                }
                #main_content h1 {
                    font-size: 40px;
                    line-height: 40px;
                }
                #main_content .h-sm-40-48 {
                    font-size: 40px;
                    line-height: 48px;
                }
                #main_content .h-sm-34-40 {
                    font-size: 34px;
                    line-height: 40px;
                }
                #main_content .h-sm-27-32 {
                    font-size: 27px;
                    line-height: 32px;
                }
                .vc_empty_space.space-sm-48 {
                    height: 48px!important;
                }
                .vc_empty_space.space-sm-32 {
                    height: 32px!important;
                }
                .vc_empty_space.space-sm-24 {
                    height: 24px!important;
                }
                .vc_empty_space.space-sm-16 {
                    height: 16px!important;
                }
                .vc_empty_space.space-sm-0 {
                    height: 0!important;
                }
                p {
                    text-align: center!important;
                }
                .vc_btn3-container.vc_btn3-inline {
                    width: 100%;
                    text-align: center;
                }
                .vc_btn3-container.vc_btn3-inline a {
                    width: auto!important;
                }
                #main_content a.vc_general.vc_btn3-style-btn-crello {
                    width: 100%;
                    padding-left: 30px;
                    padding-right: 30px;
                }
                #main_content .container {
                    padding-right: 16px;
                    padding-left: 16px;
                }
                #main_content h2 {
                    font-size: 28px;
                    line-height: 42px;
                }
                .wpb-js-composer .vc_tta.vc_tta-o-no-fill.vc_tta-tabs .vc_tta-tabs-container {
                    width: calc(100% + 60px);
                    margin-left: -30px!important;
                }
                .wpb-js-composer .vc_tta .vc_tta-tabs-list {
                    padding-left: 26px!important;
                    padding-right: 26px!important;
                }
                #three-million-users {
                    margin-top: 32px;
                }
                .row.three-million-users {
                    border-radius: 0;
                    background-image: none;
                }
                .col-xxs-12 {
                    float: left;
                    position: relative;
                    min-height: 1px;
                    padding-right: 8px!important;
                    padding-left: 8px!important;
                }
                div.col-xxs-12 {
                    width: 100%;
                }
                div.col-xxs-offset-0 {
                    margin-left: 0;
                }
            }
            .row.three-million-users {
                background-size: cover;
            }
            .loaded.webp .row.three-million-users {
                background-image: url(http://static.crello.com/create/wp-content/themes/crello-landing-new/css/../images/3-million-users-bg-400.webp);
            }
            @media (max-width:414px) {
                .loaded.webp .row.three-million-users {
                    background-image: url(http://static.crello.com/create/wp-content/themes/crello-landing-new/css/../images/3-million-users-bg-400.webp);
                }
            }
            @media (min-width:415px) and (max-width:768px) {
                .loaded.webp .row.three-million-users {
                    background-image: url(http://static.crello.com/create/wp-content/themes/crello-landing-new/css/../images/3-million-users-bg-720.webp);
                }
            }
            @media (min-width:769px) and (max-width:1280px) {
                .loaded.webp .row.three-million-users {
                    background-image: url(http://static.crello.com/create/wp-content/themes/crello-landing-new/css/../images/3-million-users-bg-1170.webp);
                }
            }
            @media (min-width:1281px) {
                .loaded.webp .row.three-million-users {
                    background-image: url(http://static.crello.com/create/wp-content/themes/crello-landing-new/css/../images/3-million-users-bg.webp);
                }
            }
            @media (-webkit-min-device-pixel-ratio:2) and (max-width:414px) {
                .loaded.webp .row.three-million-users {
                    background-image: url(http://static.crello.com/create/wp-content/themes/crello-landing-new/css/../images/3-million-users-bg-720.webp);
                }
            }
            @media (-webkit-min-device-pixel-ratio:2) and (min-width:415px) and (max-width:768px) {
                .loaded.webp .row.three-million-users {
                    background-image: url(http://static.crello.com/create/wp-content/themes/crello-landing-new/css/../images/3-million-users-bg-1170.webp);
                }
            }
            @media (-webkit-min-device-pixel-ratio:2) and (min-width:769px) and (max-width:1280px) {
                .loaded.webp .row.three-million-users {
                    background-image: url(http://static.crello.com/create/wp-content/themes/crello-landing-new/css/../images/3-million-users-bg.webp);
                }
            }
            #main_content .faq_widget .item {
                margin-left: 48px;
                padding: 1px 0;
            }
            #main_content .faq_widget .item h3 {
                /* font-family: "Fugue Regular"; */
                font-size: 24px;
                line-height: 100%;
                color: #121316;
                margin-top: 44px;
                margin-bottom: 36px;
                position: relative;
                cursor: pointer;
            }
            #main_content .faq_widget .item.closed h3 {
                margin-bottom: 26px;
            }
            #main_content .faq_widget .item h3:before {
                content: "";
                display: block;
                width: 32px;
                height: 32px;
                position: absolute;
                top: -5px;
                left: -48px;
                background: url('data:image/svg+xml;utf8,<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="14" width="24" height="4" fill="%23121316"/></svg>');
            }
            #main_content .faq_widget .item.closed h3:before {
                background: url('data:image/svg+xml;utf8,<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="14" width="24" height="4" fill="%23121316"/><rect x="18" y="4" width="24" height="4" transform="rotate(90 18 4)" fill="%23121316"/></svg>');
            }
            .crello-templates-grid-wrapper {
                overflow: hidden;
                margin-bottom: -16px;
            }
            .crello-templates-grid-wrapper .template {
                float: left;
                margin-right: 16px;
                margin-bottom: 16px;
                width: calc(25% - 12px);
            }
            .crello-templates-grid-wrapper .template:nth-child(4n) {
                margin-right: 0;
            }
            .crello-templates-grid-wrapper .template img {
                max-width: 100%;
                border-radius: 12px;
            }
            @media screen and (max-width:768px) {
                .crello-templates-grid-wrapper {
                    margin-bottom: -13px;
                }
                .crello-templates-grid-wrapper .template {
                    margin-right: 13px;
                    margin-bottom: 13px;
                    width: calc(33% - 12px);
                }
                .crello-templates-grid-wrapper .template:nth-child(4n) {
                    margin-right: 13px;
                }
                .crello-templates-grid-wrapper .template:nth-child(3n) {
                    margin-right: 0;
                }
            }
            @media screen and (max-width:414px) {
                .crello-templates-grid-wrapper {
                    margin-bottom: -16px;
                }
                .crello-templates-grid-wrapper .template {
                    margin-right: 16px;
                    margin-bottom: 16px;
                    width: calc(50% - 8px);
                }
                .crello-templates-grid-wrapper .template:nth-child(4n) {
                    margin-right: 16px;
                }
                .crello-templates-grid-wrapper .template:nth-child(3n) {
                    margin-right: 16px;
                }
                .crello-templates-grid-wrapper .template:nth-child(2n) {
                    margin-right: 0;
                }
            }
            #testimonials_2 {
                margin-top: 32px;
            }
            #testimonials_2 .container {
                background: 0 0;
                padding-left: 0;
                padding-right: 0;
            }
            .owl-carousel.testimonials_2 .item {
                width: 100%;
                min-height: 424px;
                border-radius: 8px;
                overflow: hidden;
            }
            .owl-carousel.testimonials_2 .item .portrait-mobile {
                display: none;
            }
            .owl-carousel.testimonials_2 .item .left {
                width: 49%;
                float: left;
            }
            .owl-carousel.testimonials_2 .item .right {
                width: 49%;
                float: left;
            }
            .owl-carousel.testimonials_2 .item .left .text {
                font-size: 24px;
                line-height: 29px;
                padding-top: 48px;
                margin-left: 40px;
                color: #fff;
            }
            .owl-carousel.testimonials_2 .item.light .left .text {
                color: #000;
            }
            .owl-carousel.testimonials_2 .item .left .name {
                /* font-family: "Proxima Nova"; */
                font-weight: 600;
                font-size: 20px;
                line-height: 28px;
                padding-top: 32px;
                margin-left: 40px;
                color: #fff;
            }
            .owl-carousel.testimonials_2 .item.light .left .name {
                color: #000;
            }
            .owl-carousel.testimonials_2 .item .left .position {
                /* font-family: "Proxima Nova"; */
                font-size: 16px;
                line-height: 20px;
                padding-top: 8px;
                margin-left: 40px;
                color: #fff;
                opacity: .7;
                padding-bottom: 16px;
            }
            .owl-carousel.testimonials_2 .item.light .left .position {
                color: #000;
            }
            .owl-carousel.testimonials_2 .item .right .portrait {
                position: absolute;
                bottom: 0;
            }
            .owl-carousel.testimonials_2 .item .right .portrait img {
                max-height: 424px;
                width: auto;
            }
            .owl-carousel.testimonials_2 .item .nav {
                position: absolute;
                top: 50px;
                right: 44px;
                z-index: 99;
            }
            .owl-carousel.testimonials_2 .item .nav span {
                height: 25px;
                width: 15px;
                cursor: pointer;
            }
            .owl-carousel.testimonials_2 .item .nav span.prev {
                margin-right: 37px;
            }
            .owl-carousel.testimonials_2 .item.light .nav span svg path {
                fill: #000!important;
            }
            .owl-carousel.testimonials_2 .item .nav span:hover svg path {
                opacity: 1;
            }
            .owl-carousel.testimonials_2 .owl-dots {
                width: -webkit-fit-content;
                width: -moz-fit-content;
                margin: 32px auto;
                line-height: 0;
            }
            .owl-carousel.testimonials_2 .owl-dots .owl-dot {
                display: inline-block;
                margin-left: 10px;
                margin-right: 10px;
                width: 10px;
                height: 10px;
                background-color: #f0ddca;
                border-radius: 50%;
            }
            .owl-carousel.testimonials_2 .owl-dots .owl-dot.active {
                background-color: #121216;
            }
            @media screen and (max-width:768px) {
                .owl-carousel.testimonials_2 {
                    padding-left: 24px;
                    padding-right: 24px;
                }
                #main_content #testimonials_2 .container {
                    padding-right: 0;
                    padding-left: 0;
                }
                #testimonials_2 .row>div {
                    padding-right: 8px;
                    padding-left: 8px;
                }
                .owl-carousel.testimonials_2 .item {
                    min-height: 430px;
                    border-radius: 8px;
                }
                .owl-carousel.testimonials_2 .item .left .text {
                    padding-top: 24px;
                    font-weight: 400;
                    font-size: 16px;
                    line-height: 24px;
                    margin-left: 24px;
                    width: 100%;
                }
                .owl-carousel.testimonials_2 .item .left .name {
                    font-weight: 600;
                    font-size: 16px;
                    line-height: 24px;
                    padding-top: 24px;
                    margin-left: 24px;
                }
                .owl-carousel.testimonials_2 .item .left .position {
                    font-weight: 400;
                    font-size: 14px;
                    line-height: 20px;
                    opacity: .7;
                    margin-left: 24px;
                }
                #testimonials_2 .owl-carousel.testimonials_2 .item .nav {
                    position: initial;
                    margin-left: 28px;
                    margin-top: 48px;
                }
                .owl-carousel.testimonials_2 .owl-dots {
                    margin-top: 24px;
                }
            }
            @media screen and (max-width:414px) {
                .owl-carousel.testimonials_2 {
                    padding-left: 0;
                    padding-right: 0;
                }
                .owl-carousel.testimonials_2 .item {
                    border-radius: 0;
                }
                .owl-carousel.testimonials_2 .item .portrait-mobile {
                    display: block;
                    padding-top: 47px;
                }
                .owl-carousel.testimonials_2 .item .portrait-mobile img {
                    width: 97px;
                    height: auto;
                    margin: 0 auto;
                }
                .owl-carousel.testimonials_2 .item .left {
                    width: 100%;
                    text-align: center;
                }
                .owl-carousel.testimonials_2 .item .left .text {
                    padding-top: 16px;
                    font-weight: 400;
                    font-size: 16px;
                    line-height: 24px;
                    margin-left: 0;
                    width: 100%;
                }
                .owl-carousel.testimonials_2 .item .left .name {
                    font-weight: 600;
                    font-size: 16px;
                    line-height: 24px;
                    padding-top: 16px;
                    margin-left: 0;
                }
                .owl-carousel.testimonials_2 .item .left .position {
                    font-weight: 400;
                    font-size: 14px;
                    line-height: 20px;
                    opacity: .7;
                    margin-left: 0;
                }
                .owl-carousel.testimonials_2 .item .right .portrait img {
                    display: none;
                }
                #testimonials_2 .owl-carousel.testimonials_2 .item .nav {
                    position: relative;
                    margin-left: calc(50% + 10px);
                    margin-top: 0;
                    margin-bottom: auto;
                    top: 32px;
                }
                .owl-carousel.testimonials_2 .owl-dots {
                    margin-top: 16px;
                }
            }
            .trial-block {
                width: calc(100% + 28px);
                margin-left: -14px;
                border: 3px solid #ffde4e;
                border-radius: 8px;
                overflow: hidden;
                background-color: #f5eee7;
            }
            .trial-block.black {
                border: 3px solid #2153cc;
                background-color: #2d2d36;
            }
            .trial-block .crello-pro-label {
                width: 135px;
                height: 42px;
                border-radius: 0 0 10.5px 10.5px;
                background: #ffde4e;
                padding: 10.5px 21px;
            }
            .trial-block.black .crello-pro-label {
                background: #2153cc;
            }
            .trial-block .crello-pro-label span {
                font-weight: 300;
                font-size: 20px;
                line-height: 24px;
                color: #121216;
                position: relative;
                display: inline-block;
                float: right;
                left: 3px;
                top: 1px;
            }
            .trial-block.black .crello-pro-label span {
                color: #fff;
            }
            .trial-block.black .crello-pro-label svg path {
                fill: #fff;
            }
            #main_content .trial-block h2 {
                font-size: 27px;
                line-height: 28px;
                color: #121316;
                margin-top: 32px;
            }
            #main_content .trial-block.black h2 {
                color: #fff;
            }
            .trial-block ul.trial-list {
                margin-top: 16px;
                list-style: none;
                padding-left: 20px;
            }
            .trial-block ul.trial-list li {
                margin-bottom: 8px;
                font-weight: 600;
                font-size: 14px;
                line-height: 20px;
                color: #121316;
                position: relative;
            }
            .trial-block.black ul.trial-list li {
                color: #fff;
            }
            .trial-block ul.trial-list li:before {
                content: "";
                display: block;
                width: 16px;
                height: 16px;
                background: url('data:image/svg+xml;utf8,<svg width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.8782 1.2702L4.1466 7.87987C4.06927 7.95675 3.96399 8 3.85418 8C3.74436 8 3.63909 7.95675 3.56175 7.87987L0.121829 4.50194C0.0438579 4.42568 0 4.32188 0 4.21359C0 4.10531 0.0438579 4.0015 0.121829 3.92525L0.698442 3.35669C0.775777 3.2798 0.881049 3.23656 0.990868 3.23656C1.10069 3.23656 1.20596 3.2798 1.28329 3.35669L3.85006 5.87365L9.71671 0.11683C9.87965 -0.0389432 10.1386 -0.0389432 10.3016 0.11683L10.8782 0.693515C10.9561 0.76977 11 0.873572 11 0.981858C11 1.09014 10.9561 1.19395 10.8782 1.2702Z" fill="%232153CC"/></svg>');
                position: absolute;
                left: -24px;
            }
            .trial-block ul.trial-list li:nth-child(1):before {
                background: url('data:image/svg+xml;utf8,<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.7 6.29999H2.8C1.8 6.29999 1 7.09999 1 8.09999V13.4C1 14.4 1.8 15.2 2.8 15.2H10.7C11.7 15.2 12.5 14.4 12.5 13.4V7.99999C12.5 6.99999 11.7 6.29999 10.7 6.29999ZM11.2 13.3C11.2 13.6 11 13.8 10.7 13.8H2.8C2.5 13.8 2.3 13.6 2.3 13.3V7.99999C2.3 7.69999 2.5 7.49999 2.8 7.49999H10.7C11 7.49999 11.2 7.69999 11.2 7.99999V13.3Z" fill="%232153CC"/><path d="M6.19995 8.89999C6.79995 8.89999 6.59995 8.89999 7.49995 8.89999V10.5H8.79995C8.89995 10.5 8.99995 10.6 9.09995 10.7C9.09995 10.8 9.09995 10.9 8.99995 11L7.09995 12.9C6.99995 13 6.79995 13 6.69995 12.9L4.79995 11C4.69995 10.9 4.69995 10.8 4.69995 10.7C4.69995 10.6 4.89995 10.5 4.99995 10.5H6.29995L6.19995 8.89999Z" fill="%232153CC"/><path d="M6.8001 2.2C5.4001 2.2 4.3001 3.3 4.3001 4.5V6.8H3.1001V4.5C3.1001 2.5 4.8001 1 6.8001 1C8.8001 1 10.5001 2.6 10.5001 4.5H9.3001C9.2001 3.3 8.2001 2.2 6.8001 2.2Z" fill="%232153CC"/></svg>');
            }
            .trial-block.black ul.trial-list li:nth-child(1):before {
                background: url('data:image/svg+xml;utf8,<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.7 6.29999H2.8C1.8 6.29999 1 7.09999 1 8.09999V13.4C1 14.4 1.8 15.2 2.8 15.2H10.7C11.7 15.2 12.5 14.4 12.5 13.4V7.99999C12.5 6.99999 11.7 6.29999 10.7 6.29999ZM11.2 13.3C11.2 13.6 11 13.8 10.7 13.8H2.8C2.5 13.8 2.3 13.6 2.3 13.3V7.99999C2.3 7.69999 2.5 7.49999 2.8 7.49999H10.7C11 7.49999 11.2 7.69999 11.2 7.99999V13.3Z" fill="%23FFDE4E"/><path d="M6.19995 8.89999C6.79995 8.89999 6.59995 8.89999 7.49995 8.89999V10.5H8.79995C8.89995 10.5 8.99995 10.6 9.09995 10.7C9.09995 10.8 9.09995 10.9 8.99995 11L7.09995 12.9C6.99995 13 6.79995 13 6.69995 12.9L4.79995 11C4.69995 10.9 4.69995 10.8 4.69995 10.7C4.69995 10.6 4.89995 10.5 4.99995 10.5H6.29995L6.19995 8.89999Z" fill="%23FFDE4E"/><path d="M6.8001 2.2C5.4001 2.2 4.3001 3.3 4.3001 4.5V6.8H3.1001V4.5C3.1001 2.5 4.8001 1 6.8001 1C8.8001 1 10.5001 2.6 10.5001 4.5H9.3001C9.2001 3.3 8.2001 2.2 6.8001 2.2Z" fill="%23FFDE4E"/></svg>');
            }
            .trial-block ul.trial-list li:nth-child(2):before {
                background: url('data:image/svg+xml;utf8,<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.8 8.3C13.5 7.6 13.9 6.7 13.9 5.7C13.9 3.7 12.3 2.1 10.3 2.1C9.6 2.1 8.9 2.3 8.3 2.7C7.7 2.2 7 2 6.2 2C4.2 2 2.6 3.6 2.6 5.6C2.6 6.6 3 7.5 3.7 8.2C2 9.2 1 10.9 1 12.9V14.7H10.5H11.3H15.4V12.9C15.4 10.9 14.4 9.2 12.8 8.3ZM12.6 5.6C12.6 6.9 11.6 7.9 10.3 7.9C9.9 8 9.5 7.9 9.2 7.7C9.6 7.1 9.8 6.4 9.8 5.6C9.8 4.8 9.6 4.1 9.2 3.5C9.5 3.3 9.9 3.2 10.3 3.2C11.6 3.3 12.6 4.4 12.6 5.6ZM6.2 3.3C7.5 3.3 8.5 4.4 8.5 5.6C8.5 6.8 7.5 8 6.2 8C4.9 8 3.9 7 3.9 5.7C3.9 4.4 4.9 3.3 6.2 3.3ZM10 13.4H2.3V12.9C2.3 11.2 3.4 9.6 5 9.1C5.4 9.2 5.8 9.3 6.3 9.3C6.7 9.3 7.1 9.2 7.5 9.1C8.9 9.6 10 11.1 10 12.9V13.4ZM14.1 13.4H11.3V12.9C11.3 11.5 10.8 10.2 9.9 9.3C10 9.3 10.2 9.3 10.3 9.3C10.7 9.3 11.1 9.2 11.5 9.1C13.1 9.7 14.1 11.2 14.1 12.9V13.4Z" fill="%232153CC"/></svg>');
            }
            .trial-block.black ul.trial-list li:nth-child(2):before {
                background: url('data:image/svg+xml;utf8,<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.8 8.3C13.5 7.6 13.9 6.7 13.9 5.7C13.9 3.7 12.3 2.1 10.3 2.1C9.6 2.1 8.9 2.3 8.3 2.7C7.7 2.2 7 2 6.2 2C4.2 2 2.6 3.6 2.6 5.6C2.6 6.6 3 7.5 3.7 8.2C2 9.2 1 10.9 1 12.9V14.7H10.5H11.3H15.4V12.9C15.4 10.9 14.4 9.2 12.8 8.3ZM12.6 5.6C12.6 6.9 11.6 7.9 10.3 7.9C9.9 8 9.5 7.9 9.2 7.7C9.6 7.1 9.8 6.4 9.8 5.6C9.8 4.8 9.6 4.1 9.2 3.5C9.5 3.3 9.9 3.2 10.3 3.2C11.6 3.3 12.6 4.4 12.6 5.6ZM6.2 3.3C7.5 3.3 8.5 4.4 8.5 5.6C8.5 6.8 7.5 8 6.2 8C4.9 8 3.9 7 3.9 5.7C3.9 4.4 4.9 3.3 6.2 3.3ZM10 13.4H2.3V12.9C2.3 11.2 3.4 9.6 5 9.1C5.4 9.2 5.8 9.3 6.3 9.3C6.7 9.3 7.1 9.2 7.5 9.1C8.9 9.6 10 11.1 10 12.9V13.4ZM14.1 13.4H11.3V12.9C11.3 11.5 10.8 10.2 9.9 9.3C10 9.3 10.2 9.3 10.3 9.3C10.7 9.3 11.1 9.2 11.5 9.1C13.1 9.7 14.1 11.2 14.1 12.9V13.4Z" fill="%23FFDE4E"/></svg>');
            }
            .trial-block ul.trial-list li:nth-child(3):before {
                background: url('data:image/svg+xml;utf8,<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.4 11.5C10.9 11.5 13.8 9.2 13.8 6.3C13.8 3.4 10.9 1 7.4 1C3.9 1 1 3.3 1 6.2C1 7.6 1.7 8.9 2.9 9.9C2.4 10.6 2 11 1.5 11.1C1.2 11.2 1 11.5 1 11.8C1 12.1 1.3 12.4 1.7 12.4H1.8C2.3 12.4 4 12.3 6 11.3C6.4 11.4 6.9 11.5 7.4 11.5ZM4 10.7C4.1 10.5 4.3 10.3 4.4 10.1C4.6 9.8 4.5 9.4 4.2 9.2C3 8.4 2.4 7.4 2.4 6.2C2.4 4.1 4.6 2.3 7.4 2.3C10.2 2.3 12.4 4 12.4 6.2C12.4 8.4 10.2 10.1 7.4 10.1C6.9 10.1 6.5 10.1 6 10C5.8 10 5.7 10 5.5 10.1C5.1 10.3 4.5 10.5 4 10.7Z" fill="%232153CC"/><path d="M15 14.1C14.6 14 14.2 13.7 13.8 13.2C14.9 12.3 15.5 11.1 15.5 9.79999C15.5 9.19999 15.3 8.49999 15 7.89999C14.9 7.69999 14.8 7.59999 14.6 7.59999C14.4 7.49999 14.2 7.59999 14.1 7.59999C13.8 7.79999 13.6 8.19999 13.8 8.49999C14 8.99999 14.1 9.39999 14.1 9.79999C14.1 10.8 13.5 11.8 12.5 12.5C12.2 12.7 12.1 13.1 12.3 13.4C12.4 13.5 12.5 13.7 12.5 13.8C12.1 13.7 11.6 13.5 11.2 13.3C11.1 13.2 10.9 13.2 10.7 13.2C9 13.6 7.2 13.1 6.1 12.1C6 12 5.8 11.9 5.7 12C5.5 12 5.3 12.1 5.2 12.2C5.1 12.3 5 12.5 5 12.7C5 12.9 5.1 13.1 5.2 13.2C6.6 14.4 8.7 15 10.8 14.6C12.4 15.4 13.8 15.5 14.5 15.5C14.7 15.5 14.8 15.5 14.9 15.5C15.2 15.5 15.5 15.2 15.5 14.9C15.5 14.5 15.3 14.2 15 14.1Z" fill="%232153CC"/></svg>');
            }
            .trial-block.black ul.trial-list li:nth-child(3):before {
                background: url('data:image/svg+xml;utf8,<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.4 11.5C10.9 11.5 13.8 9.2 13.8 6.3C13.8 3.4 10.9 1 7.4 1C3.9 1 1 3.3 1 6.2C1 7.6 1.7 8.9 2.9 9.9C2.4 10.6 2 11 1.5 11.1C1.2 11.2 1 11.5 1 11.8C1 12.1 1.3 12.4 1.7 12.4H1.8C2.3 12.4 4 12.3 6 11.3C6.4 11.4 6.9 11.5 7.4 11.5ZM4 10.7C4.1 10.5 4.3 10.3 4.4 10.1C4.6 9.8 4.5 9.4 4.2 9.2C3 8.4 2.4 7.4 2.4 6.2C2.4 4.1 4.6 2.3 7.4 2.3C10.2 2.3 12.4 4 12.4 6.2C12.4 8.4 10.2 10.1 7.4 10.1C6.9 10.1 6.5 10.1 6 10C5.8 10 5.7 10 5.5 10.1C5.1 10.3 4.5 10.5 4 10.7Z" fill="%23FFDE4E"/><path d="M15 14.1C14.6 14 14.2 13.7 13.8 13.2C14.9 12.3 15.5 11.1 15.5 9.79999C15.5 9.19999 15.3 8.49999 15 7.89999C14.9 7.69999 14.8 7.59999 14.6 7.59999C14.4 7.49999 14.2 7.59999 14.1 7.59999C13.8 7.79999 13.6 8.19999 13.8 8.49999C14 8.99999 14.1 9.39999 14.1 9.79999C14.1 10.8 13.5 11.8 12.5 12.5C12.2 12.7 12.1 13.1 12.3 13.4C12.4 13.5 12.5 13.7 12.5 13.8C12.1 13.7 11.6 13.5 11.2 13.3C11.1 13.2 10.9 13.2 10.7 13.2C9 13.6 7.2 13.1 6.1 12.1C6 12 5.8 11.9 5.7 12C5.5 12 5.3 12.1 5.2 12.2C5.1 12.3 5 12.5 5 12.7C5 12.9 5.1 13.1 5.2 13.2C6.6 14.4 8.7 15 10.8 14.6C12.4 15.4 13.8 15.5 14.5 15.5C14.7 15.5 14.8 15.5 14.9 15.5C15.2 15.5 15.5 15.2 15.5 14.9C15.5 14.5 15.3 14.2 15 14.1Z" fill="%23FFDE4E"/></svg>');
            }
            .trial-block ul.trial-list li:nth-child(4):before {
                background: url('data:image/svg+xml;utf8,<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="2" width="3" height="3" fill="%232153CC"/><rect x="5" y="5" width="3" height="3" fill="%232153CC"/><rect x="8" y="2" width="3" height="3" fill="%232153CC"/><rect x="8" y="8" width="3" height="3" fill="%232153CC"/><rect x="5" y="11" width="3" height="3" fill="%232153CC"/><rect x="11" y="11" width="3" height="3" fill="%232153CC"/><rect x="11" y="5" width="3" height="3" fill="%232153CC"/><rect x="2" y="8" width="3" height="3" fill="%232153CC"/></svg>');
            }
            .trial-block.black ul.trial-list li:nth-child(4):before {
                background: url('data:image/svg+xml;utf8,<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="2" width="3" height="3" fill="%23FFDE4E"/><rect x="5" y="5" width="3" height="3" fill="%23FFDE4E"/><rect x="8" y="2" width="3" height="3" fill="%23FFDE4E"/><rect x="8" y="8" width="3" height="3" fill="%23FFDE4E"/><rect x="5" y="11" width="3" height="3" fill="%23FFDE4E"/><rect x="11" y="11" width="3" height="3" fill="%23FFDE4E"/><rect x="11" y="5" width="3" height="3" fill="%23FFDE4E"/><rect x="2" y="8" width="3" height="3" fill="%23FFDE4E"/></svg>');
            }
            .trial-block .button-wrapper {
                margin-top: 24px;
                margin-bottom: 44px;
            }
            .trial-block .button-wrapper .vc_btn3-container.vc_btn3-inline {
                margin-top: 0!important;
            }
            .trial-block .button-wrapper .vc_btn3-container.vc_btn3-inline a {
                min-width: 215px;
            }
            .trial-block .button-wrapper a.after-button {
                padding: 6px 24px;
                margin-top: 8px;
                display: inline-block;
                margin-left: 6px;
                font-weight: 600;
                font-size: 14px;
                line-height: 20px;
            }
            .trial-block img {
                width: 104%;
            }
            @media screen and (max-width:1200px) {
                .trial-block .crello-pro-label {
                    margin-left: 28px;
                }
                #main_content .trial-block h2 {
                    margin-left: 28px;
                }
                .trial-block .button-wrapper {
                    text-align: left;
                    margin-left: 32px;
                }
                .trial-block ul.trial-list {
                    margin-left: 32px;
                }
                .trial-block img {
                    max-height: 416px;
                    width: auto;
                    float: right;
                    margin-right: -16px;
                }
            }
            @media screen and (max-width:720px) {
                .trial-block .crello-pro-label {
                    margin: 0 auto;
                }
                #main_content .trial-block h2 {
                    margin: 16px 16px 0;
                    font-size: 20px;
                    line-height: 20px;
                    text-align: center;
                }
                .trial-block ul.trial-list {
                    margin-left: 8px;
                }
                .trial-block .button-wrapper {
                    margin-bottom: 8px;
                    margin-left: 0;
                }
                .trial-block img {
                    max-height: none;
                    width: 106%;
                    float: none;
                    margin-right: 0;
                }
                #main_content a.vc_general.vc_btn3-style-btn-crello {
                    width: 100%!important;
                }
            }
            body {
                margin: 0;
            }
            figure,
            section {
                display: block;
            }
            a {
                background-color: transparent;
            }
            a:active,
            a:hover {
                outline: 0;
            }
            h1 {
                font-size: 2em;
                margin: 0.67em 0;
            }
            img {
                border: 0;
            }
            svg:not(:root) {
                overflow: hidden;
            }
            figure {
                margin: 1em 40px;
            }
            button {
                color: inherit;
                font: inherit;
                margin: 0;
            }
            button {
                overflow: visible;
            }
            button {
                text-transform: none;
            }
            button {
                -webkit-appearance: button;
                cursor: pointer;
            }
            button::-moz-focus-inner {
                border: 0;
                padding: 0;
            }
            @media print {
                *,
                *:before,
                *:after {
                    color: #000!important;
                    text-shadow: none!important;
                    background: transparent!important;
                    -webkit-box-shadow: none!important;
                    box-shadow: none!important;
                }
                a,
                a:visited {
                    text-decoration: underline;
                }
                a[href]:after {
                    content: " (" attr(href) ")";
                }
                a[href^="#"]:after {
                    content: "";
                }
                img {
                    page-break-inside: avoid;
                }
                img {
                    max-width: 100%!important;
                }
                p,
                h2,
                h3 {
                    orphans: 3;
                    widows: 3;
                }
                h2,
                h3 {
                    page-break-after: avoid;
                }
            }
            * {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            *:before,
            *:after {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            body {
                /* font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; */
                font-size: 14px;
                line-height: 1.42857143;
                color: #333;
                background-color: #fff;
            }
            button {
                font-family: inherit;
                font-size: inherit;
                line-height: inherit;
            }
            a {
                color: #337ab7;
                text-decoration: none;
            }
            a:hover,
            a:focus {
                color: #23527c;
                text-decoration: underline;
            }
            a:focus {
                outline: 5px auto -webkit-focus-ring-color;
                outline-offset: -2px;
            }
            figure {
                margin: 0;
            }
            img {
                vertical-align: middle;
            }
            [role="button"] {
                cursor: pointer;
            }
            h1,
            h2,
            h3 {
                font-family: inherit;
                font-weight: 500;
                line-height: 1.1;
                color: inherit;
            }
            h1,
            h2,
            h3 {
                margin-top: 20px;
                margin-bottom: 10px;
            }
            h1 {
                font-size: 36px;
            }
            h2 {
                font-size: 30px;
            }
            h3 {
                font-size: 24px;
            }
            p {
                margin: 0 0 10px;
            }
            ul {
                margin-top: 0;
                margin-bottom: 10px;
            }
            .container {
                padding-right: 15px;
                padding-left: 15px;
                margin-right: auto;
                margin-left: auto;
            }
            @media (min-width:768px) {
                .container {
                    width: 750px;
                }
            }
            @media (min-width:992px) {
                .container {
                    width: 970px;
                }
            }
            @media (min-width:1200px) {
                .container {
                    width: 1170px;
                }
            }
            .row {
                margin-right: -15px;
                margin-left: -15px;
            }
            .col-md-4,
            .col-lg-4,
            .col-md-5,
            .col-lg-5,
            .col-xs-6,
            .col-sm-6,
            .col-md-6,
            .col-lg-6,
            .col-md-7,
            .col-lg-7,
            .col-xs-8,
            .col-sm-8,
            .col-md-8,
            .col-lg-8,
            .col-sm-10,
            .col-md-10,
            .col-lg-10,
            .col-sm-12 {
                position: relative;
                min-height: 1px;
                padding-right: 15px;
                padding-left: 15px;
            }
            .col-xs-6,
            .col-xs-8 {
                float: left;
            }
            .col-xs-8 {
                width: 66.66666667%;
            }
            .col-xs-6 {
                width: 50%;
            }
            .col-xs-offset-2 {
                margin-left: 16.66666667%;
            }
            @media (min-width:768px) {
                .col-sm-6,
                .col-sm-8,
                .col-sm-10,
                .col-sm-12 {
                    float: left;
                }
                .col-sm-12 {
                    width: 100%;
                }
                .col-sm-10 {
                    width: 83.33333333%;
                }
                .col-sm-8 {
                    width: 66.66666667%;
                }
                .col-sm-6 {
                    width: 50%;
                }
                .col-sm-offset-2 {
                    margin-left: 16.66666667%;
                }
                .col-sm-offset-1 {
                    margin-left: 8.33333333%;
                }
                .col-sm-offset-0 {
                    margin-left: 0;
                }
            }
            @media (min-width:992px) {
                .col-md-4,
                .col-md-5,
                .col-md-6,
                .col-md-7,
                .col-md-8,
                .col-md-10 {
                    float: left;
                }
                .col-md-10 {
                    width: 83.33333333%;
                }
                .col-md-8 {
                    width: 66.66666667%;
                }
                .col-md-7 {
                    width: 58.33333333%;
                }
                .col-md-6 {
                    width: 50%;
                }
                .col-md-5 {
                    width: 41.66666667%;
                }
                .col-md-4 {
                    width: 33.33333333%;
                }
                .col-md-offset-2 {
                    margin-left: 16.66666667%;
                }
                .col-md-offset-1 {
                    margin-left: 8.33333333%;
                }
                .col-md-offset-0 {
                    margin-left: 0;
                }
            }
            @media (min-width:1200px) {
                .col-lg-4,
                .col-lg-5,
                .col-lg-6,
                .col-lg-7,
                .col-lg-8,
                .col-lg-10 {
                    float: left;
                }
                .col-lg-10 {
                    width: 83.33333333%;
                }
                .col-lg-8 {
                    width: 66.66666667%;
                }
                .col-lg-7 {
                    width: 58.33333333%;
                }
                .col-lg-6 {
                    width: 50%;
                }
                .col-lg-5 {
                    width: 41.66666667%;
                }
                .col-lg-4 {
                    width: 33.33333333%;
                }
                .col-lg-offset-2 {
                    margin-left: 16.66666667%;
                }
                .col-lg-offset-1 {
                    margin-left: 8.33333333%;
                }
                .col-lg-offset-0 {
                    margin-left: 0;
                }
            }
            .container:before,
            .container:after,
            .row:before,
            .row:after {
                display: table;
                content: " ";
            }
            .container:after,
            .row:after {
                clear: both;
            }
            #crello-footer {
                background-color: #121216;
                color: #fff;
                /* font-family: Proxima Nova; */
                font-size: 14px;
                line-height: 21px;
                font-weight: 600;
            }
            #crello-footer a {
                color: #91949c;
                font-weight: 400;
                display: inline-block;
                width: 100%;
            }
            #crello-footer a:hover {
                color: #fff;
                text-decoration: none;
            }
            #crello-footer ul.menu {
                padding-left: 0;
                list-style: none;
                margin-top: 10px;
                margin-bottom: 29px;
            }
            #crello-footer ul.menu li a {
                padding-top: 5px;
                padding-bottom: 6px;
            }
            #crello-footer .wrapper {
                width: 968px;
                margin: 0 auto;
                padding-top: 32px;
                display: flex;
                flex-flow: column wrap;
                max-height: 360px;
            }
            #crello-footer .wrapper div.column,
            #crello-footer .wrapper div.menu {
                flex: auto;
                width: 192px;
            }
            #crello-footer .wrapper div.menu-lang {
                height: 200px;
            }
            #crello-footer .wrapper div.menu-lang .lang-switcher {
                background-color: #1d1d23;
                border-radius: 4px;
                width: 136px;
                height: 32px;
                cursor: pointer;
                margin-bottom: 24px;
            }
            #crello-footer .wrapper div.menu-lang .lang-switcher:hover {
                background-color: #2d2d36;
            }
            #crello-footer .wrapper div.menu-lang .lang-switcher span.current {
                display: block;
                padding-top: 6px;
                font-weight: 400;
                margin-left: 32px;
            }
            #crello-footer .wrapper div.menu-lang .lang-switcher span.current:before {
                content: "";
                display: block;
                width: 16px;
                height: 16px;
                background: url(https://static.crello.com/create/wp-content/themes/crello-landing-new/images/lang/icnFlagEN.svg);
                position: absolute;
                margin-left: -24px;
                margin-top: 3px;
            }
            #crello-footer .wrapper div.menu-lang .lang-switcher span.current:after {
                content: "";
                display: block;
                width: 6px;
                height: 4px;
                background-image: url('data:image/svg+xml;utf8,<svg width="6" height="4" viewBox="0 0 6 4" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 0L0 0L3 4L6 0Z" fill="white"/></svg>');
                position: relative;
                top: -12px;
                left: calc(100% - 15px);
            }
            #crello-footer .wrapper div.menu-lang .lang-switcher:hover span.current:after {
                background-image: url('data:image/svg+xml;utf8,<svg width="6" height="4" viewBox="0 0 6 4" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.76837e-07 4L6 4L3 -4.76837e-07L4.76837e-07 4Z" fill="white"/></svg>');
            }
            #crello-footer .wrapper div.menu-lang .lang-switcher .lang-options {
                display: none;
            }
            #crello-footer .wrapper div.menu-lang .app img {
                width: 136px;
                height: 40px;
                margin-bottom: 16px;
            }
            #crello-footer .bottom {
                height: 40px;
            }
            #crello-footer .bottom .wrapper {
                padding-top: 0;
                max-height: 40px;
            }
            #crello-footer .bottom .wrapper .column {
                width: 49%;
                height: 40px;
                font-weight: 400;
                font-size: 12px;
                line-height: 18px;
                color: #92929c;
            }
            #crello-footer .bottom .wrapper .social {
                text-align: right;
            }
            #crello-footer .bottom .wrapper .social a {
                display: inline-block;
                width: 40px;
                height: 35px;
                text-align: center;
            }
            #crello-footer .bottom .wrapper .column span {
                display: inline-block;
                margin-top: 12px;
            }
            #crello-footer .bottom .wrapper .column svg {
                display: inline-block;
                margin-top: 12px;
            }
            #crello-footer .bottom .wrapper .social a:hover svg path {
                fill: #fff;
            }
            @media screen and (max-width:1279px) {
                #crello-footer .wrapper {
                    width: 100%;
                    padding-left: 24px;
                    padding-right: 24px;
                }
                #crello-footer .wrapper div.column,
                #crello-footer .wrapper div.menu {
                    width: 156px;
                }
                #crello-footer .wrapper div.menu-crello {
                    order: 1;
                }
                #crello-footer .wrapper div.menu-tools {
                    order: 2;
                }
                #crello-footer .wrapper div.menu-discover {
                    order: 3;
                }
                #crello-footer .wrapper div.menu-help {
                    order: 4;
                }
                #crello-footer .wrapper div.menu-legal {
                    order: 5;
                }
                #crello-footer .wrapper div.menu-partner {
                    order: 6;
                }
                #crello-footer .wrapper div.menu-lang {
                    order: 7;
                    height: 180px;
                }
                #crello-footer .bottom .wrapper .column {
                    width: 50%;
                }
            }
            @media screen and (max-width:719px) {
                #crello-footer .wrapper {
                    width: 100%;
                    padding-left: 16px;
                    padding-right: 16px;
                }
                #crello-footer .wrapper {
                    display: block;
                    max-height: 99999px;
                }
                #crello-footer .wrapper div.column,
                #crello-footer .wrapper div.menu {
                    width: 100%;
                    height: 40px;
                    cursor: pointer;
                    border-bottom: 1px solid #1d1d23;
                    padding-top: 9px;
                    padding-bottom: 21px;
                }
                #crello-footer .wrapper div.menu-default:hover span {
                    color: #94949f;
                }
                #crello-footer .wrapper div.menu-default span:after {
                    content: "";
                    display: block;
                    width: 16px;
                    height: 16px;
                    position: absolute;
                    right: 16px;
                    margin-top: -22px;
                    background: url('data:image/svg+xml;utf8,<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 7.57143V8.42857C14 8.66527 13.8081 8.85714 13.5714 8.85714H8.85714V13.5714C8.85714 13.8081 8.66527 14 8.42857 14H7.57143C7.33473 14 7.14286 13.8081 7.14286 13.5714V8.85714H2.42857C2.19188 8.85714 2 8.66527 2 8.42857V7.57143C2 7.33473 2.19188 7.14286 2.42857 7.14286H7.14286V2.42857C7.14286 2.19188 7.33473 2 7.57143 2H8.42857C8.66527 2 8.85714 2.19188 8.85714 2.42857V7.14286H13.5714C13.8081 7.14286 14 7.33473 14 7.57143Z" fill="white"/></svg>');
                }
                #crello-footer .wrapper div.menu-default:hover span:after {
                    content: "";
                    display: block;
                    width: 16px;
                    height: 16px;
                    position: absolute;
                    right: 16px;
                    margin-top: -22px;
                    background: url('data:image/svg+xml;utf8,<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 7.57143V8.42857C14 8.66527 13.8081 8.85714 13.5714 8.85714H8.85714V13.5714C8.85714 13.8081 8.66527 14 8.42857 14H7.57143C7.33473 14 7.14286 13.8081 7.14286 13.5714V8.85714H2.42857C2.19188 8.85714 2 8.66527 2 8.42857V7.57143C2 7.33473 2.19188 7.14286 2.42857 7.14286H7.14286V2.42857C7.14286 2.19188 7.33473 2 7.57143 2H8.42857C8.66527 2 8.85714 2.19188 8.85714 2.42857V7.14286H13.5714C13.8081 7.14286 14 7.33473 14 7.57143Z" fill="rgb(148,148,159)"/></svg>');
                }
                #crello-footer .main ul.menu {
                    display: none;
                    margin-top: 12px;
                    margin-bottom: 13px;
                }
                #crello-footer .wrapper div.menu-lang {
                    height: auto;
                    margin-top: 24px;
                    cursor: auto;
                }
                #crello-footer .wrapper div.menu-lang .lang-switcher {
                    margin: 0 auto 24px;
                }
                #crello-footer .wrapper div.menu-lang .app a:first-child {
                    text-align: right;
                    margin-right: 8px;
                }
                #crello-footer .wrapper div.menu-lang .app a:last-child {
                    text-align: left;
                    margin-left: 8px;
                }
                #crello-footer .wrapper div.menu-lang .app a {
                    width: calc(49% - 8px);
                }
                #crello-footer .bottom {
                    height: auto;
                    overflow: hidden;
                }
                #crello-footer .bottom .wrapper {
                    height: auto;
                }
                #crello-footer .bottom .wrapper .column {
                    width: auto;
                    float: left;
                    left: 16px;
                    color: #91949c;
                    border: none;
                    font-weight: 400;
                    font-size: 14px;
                    line-height: 21px;
                    height: auto;
                }
                #crello-footer .bottom .wrapper .column:last-child {
                    float: right;
                }
                #crello-footer .bottom .wrapper .social a {
                    width: 24px;
                    height: 24px;
                    margin: 0 8px;
                }
            }
            .owl-carousel,
            .owl-carousel .owl-item {
                -webkit-tap-highlight-color: transparent;
                position: relative;
            }
            .owl-carousel {
                display: none;
                width: 100%;
                z-index: 1;
            }
            .owl-carousel .owl-stage {
                position: relative;
                -ms-touch-action: pan-Y;
                touch-action: manipulation;
                -moz-backface-visibility: hidden;
            }
            .owl-carousel .owl-stage:after {
                content: ".";
                display: block;
                clear: both;
                visibility: hidden;
                line-height: 0;
                height: 0;
            }
            .owl-carousel .owl-stage-outer {
                position: relative;
                overflow: hidden;
                -webkit-transform: translate3d(0, 0, 0);
            }
            .owl-carousel .owl-item {
                -webkit-backface-visibility: hidden;
                -moz-backface-visibility: hidden;
                -ms-backface-visibility: hidden;
                -webkit-transform: translate3d(0, 0, 0);
                -moz-transform: translate3d(0, 0, 0);
                -ms-transform: translate3d(0, 0, 0);
            }
            .owl-carousel .owl-item {
                min-height: 1px;
                float: left;
                -webkit-backface-visibility: hidden;
                -webkit-touch-callout: none;
            }
            .owl-carousel .owl-item img {
                display: block;
                width: 100%;
            }
            .owl-carousel .owl-nav.disabled {
                display: none;
            }
            .owl-carousel.owl-loaded {
                display: block;
            }
            .owl-carousel .owl-dot,
            .owl-carousel .owl-nav .owl-next,
            .owl-carousel .owl-nav .owl-prev {
                cursor: pointer;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
            .owl-carousel .owl-nav button.owl-next,
            .owl-carousel .owl-nav button.owl-prev,
            .owl-carousel button.owl-dot {
                background: 0 0;
                color: inherit;
                border: none;
                padding: 0!important;
                font: inherit;
            }
            .owl-carousel.owl-drag .owl-item {
                -ms-touch-action: pan-y;
                touch-action: pan-y;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
            .owl-height {
                transition: height .5s ease-in-out;
            }
            .vc_clearfix:after,
            .vc_clearfix:before {
                content: " ";
                display: table;
            }
            .vc_clearfix:after {
                clear: both;
            }
            .vc_clearfix:after,
            .vc_clearfix:before {
                content: " ";
                display: table;
            }
            .vc_clearfix:after {
                clear: both;
            }
            .wpb_text_column :last-child,
            .wpb_text_column p:last-child {
                margin-bottom: 0;
            }
            .wpb_content_element {
                margin-bottom: 35px;
            }
            .vc_column-inner:after,
            .vc_column-inner:before {
                content: " ";
                display: table;
            }
            .vc_column-inner:after {
                clear: both;
            }
            .vc_btn3-container {
                display: block;
                margin-bottom: 21.73913043px;
                max-width: 100%;
            }
            .vc_btn3-container.vc_btn3-inline {
                display: inline-block;
                vertical-align: top;
            }
            .vc_general.vc_btn3 {
                display: inline-block;
                margin-bottom: 0;
                text-align: center;
                vertical-align: middle;
                cursor: pointer;
                background-image: none;
                background-color: transparent;
                color: #5472d2;
                border: 1px solid transparent;
                box-sizing: border-box;
                word-wrap: break-word;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                text-decoration: none;
                position: relative;
                top: 0;
                -webkit-transition: all .2s ease-in-out;
                transition: all .2s ease-in-out;
                line-height: normal;
                -webkit-box-shadow: none;
                -moz-box-shadow: none;
                box-shadow: none;
                font-size: 14px;
                padding-top: 14px;
                padding-bottom: 14px;
                padding-left: 20px;
                padding-right: 20px;
            }
            .vc_btn3.vc_btn3-shape-rounded {
                border-radius: 5px;
            }
            .vc_btn3.vc_btn3-size-md {
                font-size: 14px;
                padding-top: 14px;
                padding-bottom: 14px;
                padding-left: 20px;
                padding-right: 20px;
            }
            .vc_btn3-container.vc_btn3-center {
                text-align: center;
            }
            .wpb_single_image img {
                height: auto;
                max-width: 100%;
                vertical-align: top;
            }
            .wpb_single_image .vc_single_image-wrapper {
                display: inline-block;
                vertical-align: top;
                max-width: 100%;
            }
            .wpb_single_image.vc_align_center {
                text-align: center;
            }
            .wpb_single_image.vc_align_left {
                text-align: left;
            }
            .wpb_single_image .vc_figure {
                display: inline-block;
                vertical-align: top;
                margin: 0;
                max-width: 100%;
            }
            .wpb-js-composer .vc_tta-container {
                margin-bottom: 21.73913043px;
            }
            .wpb-js-composer .vc_tta.vc_general {
                font-size: 1em;
            }
            .wpb-js-composer .vc_tta.vc_general .vc_tta-panels,
            .wpb-js-composer .vc_tta.vc_general .vc_tta-panels-container {
                box-sizing: border-box;
                position: relative;
            }
            .wpb-js-composer .vc_tta.vc_general .vc_tta-panel {
                display: block;
            }
            .wpb-js-composer .vc_tta.vc_general .vc_tta-panel-heading {
                border: solid transparent;
                box-sizing: border-box;
                transition: background .2s ease-in-out;
            }
            .wpb-js-composer .vc_tta.vc_general .vc_tta-panel-body {
                border: solid transparent;
                box-sizing: content-box;
                padding: 14px 20px;
                display: none;
                overflow: hidden;
                -webkit-transform: translate3d(0, 0, 0);
                transform: translate3d(0, 0, 0);
                transition: padding .2s ease-in-out;
            }
            .wpb-js-composer .vc_tta.vc_general .vc_tta-panel-body>:last-child {
                margin-bottom: 0;
            }
            .wpb-js-composer .vc_tta.vc_general .vc_tta-panel.vc_active {
                display: block;
            }
            .wpb-js-composer .vc_tta.vc_general .vc_tta-panel.vc_active .vc_tta-panel-body {
                display: block;
            }
            .wpb-js-composer .vc_tta.vc_general .vc_tta-tabs-container {
                display: block;
                position: relative;
                z-index: 3;
            }
            .wpb-js-composer .vc_tta.vc_general .vc_tta-tabs-list {
                list-style-type: none;
                display: block;
                padding: 0;
                margin: 0;
                box-sizing: border-box;
            }
            .wpb-js-composer .vc_tta.vc_general .vc_tta-tab {
                display: inline-block;
                padding: 0;
                margin: 0;
            }
            .wpb-js-composer .vc_tta.vc_general .vc_tta-tab>a {
                padding: 14px 20px;
                display: block;
                box-sizing: border-box;
                border: solid transparent;
                position: relative;
                text-decoration: none;
                color: inherit;
                transition: background .2s ease-in-out, color .2s ease-in-out, border .2s ease-in-out;
                box-shadow: none;
            }
            .wpb-js-composer .vc_tta.vc_general .vc_tta-tab.vc_active>a {
                cursor: default;
                text-decoration: none;
                color: inherit;
                transition: background .2s ease-in-out, color .2s ease-in-out;
                box-shadow: none;
            }
            .wpb-js-composer .vc_tta.vc_general .vc_tta-tab.vc_active>a:after,
            .wpb-js-composer .vc_tta.vc_general .vc_tta-tab.vc_active>a:before {
                display: none;
                content: '';
                position: absolute;
                border-width: inherit;
                border-color: inherit;
                border-style: inherit;
                width: 100vw;
                height: 200vw;
            }
            .wpb-js-composer .vc_tta.vc_tta-tabs .vc_tta-tabs-container {
                display: none;
            }
            @media (min-width:768px) {
                .wpb-js-composer .vc_tta.vc_tta-tabs .vc_tta-tabs-container {
                    display: block;
                }
                .wpb-js-composer .vc_tta.vc_tta-tabs .vc_tta-panel-heading {
                    display: none;
                }
            }
            .wpb-js-composer .vc_tta.vc_tta-shape-rounded .vc_tta-panel-body {
                min-height: 10px;
            }
            .wpb-js-composer .vc_tta.vc_tta-shape-rounded .vc_tta-panel-body,
            .wpb-js-composer .vc_tta.vc_tta-shape-rounded .vc_tta-panel-heading {
                border-radius: 5px;
            }
            .wpb-js-composer .vc_tta.vc_tta-shape-rounded .vc_tta-tabs-container {
                margin: 5px;
            }
            .wpb-js-composer .vc_tta.vc_tta-shape-rounded .vc_tta-tab>a {
                border-radius: 5px;
            }
            @media (min-width:768px) {
                .wpb-js-composer .vc_tta.vc_tta-shape-rounded.vc_tta-tabs .vc_tta-panels {
                    border-radius: 5px;
                }
            }
            .wpb-js-composer .vc_tta.vc_tta-shape-rounded.vc_tta-o-no-fill .vc_tta-panel-body {
                border-radius: 0;
            }
            @media (min-width:768px) {
                .wpb-js-composer .vc_tta-shape-rounded.vc_tta-tabs .vc_tta-panel-body:after,
                .wpb-js-composer .vc_tta-shape-rounded.vc_tta-tabs .vc_tta-panel-body:before {
                    box-sizing: border-box;
                    content: '';
                    display: none;
                    position: absolute;
                    width: 5px;
                    height: 5px;
                    border-radius: 5px;
                    border-style: inherit;
                    border-width: inherit;
                }
            }
            .wpb-js-composer .vc_tta.vc_tta-style-flat .vc_tta-panel-body,
            .wpb-js-composer .vc_tta.vc_tta-style-flat .vc_tta-panel-heading {
                border-width: 0;
            }
            .wpb-js-composer .vc_tta-color-white.vc_tta-style-flat .vc_tta-panel .vc_tta-panel-heading {
                background-color: #fafafa;
            }
            .wpb-js-composer .vc_tta-color-white.vc_tta-style-flat .vc_tta-panel.vc_active .vc_tta-panel-heading {
                background-color: #fff;
            }
            .wpb-js-composer .vc_tta-color-white.vc_tta-style-flat .vc_tta-panel .vc_tta-panel-body {
                background-color: #fff;
            }
            .wpb-js-composer .vc_tta-color-white.vc_tta-style-flat .vc_tta-tab>a {
                background-color: #fafafa;
                color: #666;
            }
            .wpb-js-composer .vc_tta-color-white.vc_tta-style-flat .vc_tta-tab.vc_active>a {
                background-color: #fff;
                color: #666;
            }
            @media (min-width:768px) {
                .wpb-js-composer .vc_tta-color-white.vc_tta-style-flat.vc_tta-tabs .vc_tta-panels {
                    background-color: #fff;
                }
                .wpb-js-composer .vc_tta-color-white.vc_tta-style-flat.vc_tta-tabs .vc_tta-panels .vc_tta-panel-body {
                    border-color: transparent;
                    background-color: transparent;
                }
            }
            .wpb-js-composer .vc_tta.vc_tta-o-no-fill .vc_tta-panels .vc_tta-panel-body {
                border-color: transparent;
                background-color: transparent;
            }
            @media (min-width:768px) {
                .wpb-js-composer .vc_tta.vc_tta-o-no-fill.vc_tta-tabs .vc_tta-panels {
                    border-color: transparent;
                    background-color: transparent;
                }
            }
            .wpb-js-composer .vc_tta.vc_tta-o-no-fill.vc_tta-tabs .vc_tta-tabs-container {
                margin: 0;
            }
            .wpb-js-composer .vc_tta.vc_tta-o-no-fill.vc_tta-tabs-position-top .vc_tta-panel-body {
                padding-left: 0;
                padding-right: 0;
            }
            .wpb-js-composer .vc_tta.vc_tta-spacing-1 .vc_tta-panel.vc_active+.vc_tta-panel .vc_tta-panel-heading,
            .wpb-js-composer .vc_tta.vc_tta-spacing-1 .vc_tta-panel:not(:first-child) .vc_tta-panel-heading {
                margin-top: 1px;
            }
            .wpb-js-composer .vc_tta.vc_tta-spacing-1 .vc_tta-panel.vc_active .vc_tta-panel-heading,
            .wpb-js-composer .vc_tta.vc_tta-spacing-1 .vc_tta-panel:not(:last-child) .vc_tta-panel-heading {
                margin-bottom: 1px;
            }
            .wpb-js-composer .vc_tta.vc_tta-spacing-1 .vc_tta-tabs-list {
                padding: 0;
                margin-top: -1px;
                margin-bottom: 0;
                margin-left: -1px;
                margin-right: 0;
            }
            .wpb-js-composer .vc_tta.vc_tta-spacing-1 .vc_tta-tab {
                margin-top: 1px;
                margin-bottom: 0;
                margin-left: 1px;
                margin-right: 0;
            }
            .wpb-js-composer .vc_tta-tabs.vc_tta-tabs-position-top .vc_tta-tabs-container {
                overflow: hidden;
            }
            .wpb-js-composer .vc_tta-tabs.vc_tta-tabs-position-top .vc_tta-tabs-list {
                overflow: hidden;
            }
            .wpb-js-composer .vc_tta-tabs.vc_tta-tabs-position-top .vc_tta-panel-body:before {
                right: auto;
                bottom: auto;
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
                border-bottom-left-radius: 0;
                border-right-width: 0;
                border-bottom-width: 0;
            }
            .wpb-js-composer .vc_tta-tabs.vc_tta-tabs-position-top .vc_tta-panel-body:after {
                left: auto;
                bottom: auto;
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
                border-left-width: 0;
                border-bottom-width: 0;
            }
            .wpb-js-composer .vc_tta-tabs.vc_tta-o-no-fill .vc_tta-panel-body:after,
            .wpb-js-composer .vc_tta-tabs.vc_tta-o-no-fill .vc_tta-panel-body:before {
                display: none;
            }
            .wpb-js-composer .vc_tta-tabs.vc_tta-o-no-fill .vc_tta-tabs-container,
            .wpb-js-composer .vc_tta-tabs.vc_tta-o-no-fill .vc_tta-tabs-list {
                overflow: initial;
            }
            .wpb-js-composer .vc_tta.vc_tta-controls-align-center .vc_tta-panel-heading,
            .wpb-js-composer .vc_tta.vc_tta-controls-align-center .vc_tta-tabs-container {
                text-align: center;
            }
        }
        /*! CSS Used from: Embedded */
        
        .vc_custom_1589808463806 {
            background-color: #FAF6F2!important;
        }
        /*! CSS Used from: Embedded */
        
        iframe#_hjRemoteVarsFrame {
            display: none!important;
            width: 1px!important;
            height: 1px!important;
            opacity: 0!important;
            pointer-events: none!important;
        }
        /*! CSS Used from: Embedded */
        
        .logo___kjfPm {
            transform: translateY(-2px);
        }
        
        @media (min-width:990px) {
            .logo___kjfPm {
                transform: translateY(-4px);
            }
        }
        
        .aurora-nav-link___28jb1 {
            text-decoration: none;
            outline: none;
            cursor: pointer;
            -webkit-text-decoration-skip: objects;
            text-decoration-skip: objects;
        }
        
        .aurora-nav-link___28jb1:active,
        .aurora-nav-link___28jb1:focus,
        .aurora-nav-link___28jb1:hover {
            outline-width: 0;
            text-decoration: none;
        }
        
        .seo-hidden-container___2XEpr {
            display: none;
            margin-top: 64px;
        }
        
        .icon-user___2rhuW {
            transition: color .3s;
            margin-right: 8px;
        }
        
        .subheadingM___1k3Ce {
            /* font-family: ProximaSemiBold; */
        }
        
        .bodyM___1L2FP,
        .subheadingM___1k3Ce {
            font-size: 14px;
            line-height: 20px;
        }
        
        .bodyM___1L2FP {
            /* font-family: ProximaRegular; */
        }
        
        .desktop-only--flex___mA2WQ {
            display: none!important;
        }
        
        @media (min-width:990px) {
            .desktop-only--flex___mA2WQ {
                display: flex!important;
            }
        }
        
        .mobile-only--flex___14FtS {
            display: flex!important;
        }
        
        @media (min-width:990px) {
            .mobile-only--flex___14FtS {
                display: none!important;
            }
        }
        
        .header-wrapper___3J7pG {
            position: fixed;
            left: 0;
            top: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            height: 64px;
            background-color: #fff;
            z-index: 10001;
            padding: 0 16px;
        }
        
        @media (min-width:768px) {
            .header-wrapper___3J7pG {
                padding: 0 24px;
            }
        }
        
        .header-wrapper___3J7pG * {
            box-sizing: border-box;
        }
        
        .menu-hover-area___1w5eu {
            align-self: stretch;
        }
        
        .menu-wrapper___2tRDB {
            display: flex;
            align-items: center;
        }
        
        .menu-wrapper___2tRDB:first-child {
            z-index: 2;
        }
        
        .menu-item-wrapper___2gwSM {
            display: flex;
        }
        
        .menu-item-wrapper___2gwSM:not(:last-child) {
            margin-right: 8px;
        }
        
        .menu-item___3nJJb {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #121316;
            transition: color .3s;
            cursor: pointer;
        }
        
        .menu-item___3nJJb.menu-item--profile-icon___3wExy {
            outline: none;
            cursor: pointer;
            -webkit-text-decoration-skip: objects;
            text-decoration-skip: objects;
            display: flex;
            color: #2153cc;
            text-decoration: none;
            padding: 0;
        }
        
        .menu-item___3nJJb.menu-item--profile-icon___3wExy:active,
        .menu-item___3nJJb.menu-item--profile-icon___3wExy:focus,
        .menu-item___3nJJb.menu-item--profile-icon___3wExy:hover {
            outline-width: 0;
            text-decoration: none;
        }
        
        @media (min-width:990px) {
            .menu-item___3nJJb.menu-item--profile-icon___3wExy {
                padding: 0 16px;
            }
        }
        
        .menu-item___3nJJb.menu-item--profile-icon___3wExy>span {
            color: #121316;
        }
        
        .menu-item___3nJJb.menu-item--profile-icon___3wExy:focus,
        .menu-item___3nJJb.menu-item--profile-icon___3wExy:hover {
            color: #072c9b;
        }
        
        .menu-item___3nJJb.menu-item--profile-icon___3wExy:focus>span,
        .menu-item___3nJJb.menu-item--profile-icon___3wExy:hover>span {
            color: #121316;
        }
        
        .menu-item___3nJJb.menu-item--has-triangle___issl_:hover svg {
            transform: rotate(180deg);
        }
        
        .label___h_F2N {
            position: relative;
            display: flex;
            align-items: center;
            padding: 18px 16px;
            border-radius: 8px;
            transition: background-color .3s;
        }
        
        .label___h_F2N:hover {
            background-color: #f4f4f5;
        }
        
        .label___h_F2N:after {
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #2153cc;
            border-radius: 3px 3px 0 0;
            content: "";
            z-index: 1;
            opacity: 0;
            transition: opacity .3s;
        }
        
        .logo-item___4ytGd {
            display: flex;
            align-items: center;
            height: 100%;
            margin-right: 8px;
        }
        
        .logo-item___4ytGd,
        .logo-item___4ytGd:focus,
        .logo-item___4ytGd:hover {
            color: #2153cc;
        }
        
        .button-sign-up___29cb1 {
            text-decoration: none;
            outline: none;
            cursor: pointer;
            -webkit-text-decoration-skip: objects;
            text-decoration-skip: objects;
            align-items: center;
            margin-left: 16px;
            padding: 10px 16px;
            border-radius: 8px;
            background-color: #2153cc;
            color: #fff;
            text-align: center;
            transition: background-color .3s, color .3s;
        }
        
        .button-sign-up___29cb1:active,
        .button-sign-up___29cb1:focus,
        .button-sign-up___29cb1:hover {
            outline-width: 0;
            text-decoration: none;
        }
        
        .button-sign-up___29cb1:hover {
            background-color: #0f3cb4;
        }
        
        .button-sign-up___29cb1:focus,
        .button-sign-up___29cb1:hover {
            color: #fff;
        }
        
        .icon___12XSx {
            transition: fill .3s;
            transition: transform .3s;
        }
        
        .text___2Inhw {
            margin-right: 1px;
        }
        
        .menu__item--lang___2w9zY {
            position: relative;
            align-self: center;
            padding: 12px 16px;
            border-radius: 8px;
        }
        
        .menu__item--lang___2w9zY:hover {
            background-color: #e8e8ea;
        }
        
        .flag-icon___1cAHJ {
            margin-right: 8px;
        }
        
        .icon___1Tkwg {
            transition: fill .3s;
            transition: transform .3s;
        }
        
        .button-burger___2ojD9 {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            outline: none;
            background: none;
            cursor: pointer;
            z-index: 2;
        }
        
        .button-burger___2ojD9::-moz-focus-inner {
            border: 0;
        }
        
        .button-burger__icon___1fAcF {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: space-between;
            width: 16px;
            height: 16px;
            padding: 0;
            transition: transform .6s cubic-bezier(.645, .045, .355, 1);
        }
        
        .button-burger___2ojD9 span {
            width: 16px;
            height: 2px;
            background: #2153cc;
            opacity: 1;
            transform: rotate(0);
            transition: .3s cubic-bezier(.645, .045, .355, 1);
            transform-origin: left center;
        }

        .container-fluid {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }
        /*! CSS Used fontfaces */
    </style>
@endsection

@section('content')
    <section id="main_content">
        <div class="container-wrapper ">
            <div class="container">
                <div class="row">
                    <div class="tablet-text-align-center col-xxs-12 col-xxs-offset-0 col-sm-8 col-lg-offset-0 col-lg-5 col-md-offset-0 col-md-5 col-sm-offset-2 col-xs-offset-2 col-xs-8">
                        <div class="vc_empty_space  space-md-56 space-sm-32" style="height: 64px"><span class="vc_empty_space_inner"></span></div>
                        <div class="wpb_text_column wpb_content_element ">
                            <div class="wpb_wrapper">
                                <h1 class="h-lg-56 h-md-48-56 h-sm-40-48">{{ $category_obj->name }} Design Online</h1>
                            </div>
                        </div>
                        <div class="vc_empty_space  space-md-24 space-sm-16" style="height: 24px"><span class="vc_empty_space_inner"></span></div>
                        <div class="wpb_text_column wpb_content_element ">
                            <div class="wpb_wrapper"> The menu design is a visit card that sets the tone of your restaurant and makes the first impression of it. Whether you run a fancy restaurant or a local cafe, you want to engage your visitors and turn them into repeat customers.
                                With Crello’s menu maker, every restaurant owner can create or renew a menu card in just a few minutes.</div>
                        </div>
                        <div class="vc_btn3-container vc_btn3-inline"><a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-rounded vc_btn3-style-btn-crello vc_btn3-color-btn-blue" href="https://crello.com/artboard/?newDesign=true&amp;width=21&amp;height=29.7&amp;group=EO&amp;format=Menu&amp;measureUnits=cm"
                                title="" data-categ="landingMenuMaker" data-value="joinButton1">Open in Editor</a></div>
                        <div class="wpb_text_column wpb_content_element ">
                            <div class="wpb_wrapper">
                                <p><span style="font-size: 14px; line-height: 21px; color: #91949c;">Free to use. No credit card required.</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxs-12 col-xxs-offset-0 col-sm-12 col-lg-offset-0 col-lg-7 col-md-offset-0 col-md-7 col-sm-offset-0">
                        <div class="wpb_single_image wpb_content_element vc_align_left   top-112">
                            <figure class="wpb_wrapper vc_figure">
                                <div class="vc_single_image-wrapper   vc_box_border_grey">
                                    <!-- <img loading="lazy" 
                                            srcset="https://crello-wordpress.s3.eu-west-1.amazonaws.com/create/wp-content/uploads/2020/11/cool-menu-examples-300x297.png.webp  300w,https://crello-wordpress.s3.eu-west-1.amazonaws.com/create/wp-content/uploads/2020/11/cool-menu-examples-1024x1013.png.webp  1024w,https://crello-wordpress.s3.eu-west-1.amazonaws.com/create/wp-content/uploads/2020/11/cool-menu-examples.png.webp  1536w"
                                            sizes="(max-width: 414px) 300px, (max-width: 720px) 600px, 1024px" 
                                            class="vc_single_image-img " 
                                            src="https://crello-wordpress.s3.eu-west-1.amazonaws.com/create/wp-content/uploads/2020/11/cool-menu-examples.png.webp"
                                            width="697" height="614" alt="cool menu design" title=""> -->
                                    <img loading="lazy" 
                                            class="vc_single_image-img " 
                                            src="{{ url('') }}"
                                            width="697" height="614" alt="cool menu design" title="">
                                </div>
                            </figure>
                        </div>
                        <div class="vc_empty_space  space-md-0 space-sm-0" style="height: 17px"><span class="vc_empty_space_inner"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-wrapper " id="three-million-users">
            <div class="container">
                <div class="row three-million-users margin-top-80-56-0">
                    <div class="col-sm-12">
                        <div class="vc_empty_space  space-md-48 space-sm-32" style="height: 66px"><span class="vc_empty_space_inner"></span></div>
                        <div class="wpb_text_column wpb_content_element ">
                            <div class="wpb_wrapper">
                                <h3 class="h-lg-64 h-md-40-48 h-sm-27-32" style="text-align: center;">
                                    <span style="color: #ffffff; text-shadow: 0px 10px 25px rgba(0, 0, 0, 0.5);">
                                        5 million users worldwide
                                    </span>
                                </h3>
                            </div>
                        </div>
                        <div class="vc_empty_space  space-md-24 space-sm-24" style="height: 32px"><span class="vc_empty_space_inner"></span></div>
                        <div class="vc_btn3-container  padding-44 vc_btn3-center"><a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-rounded vc_btn3-style-btn-crello vc_btn3-color-btn-yellow" href="https://crello.com/artboard/?newDesign=true&amp;width=21&amp;height=29.7&amp;group=EO&amp;format=Menu&amp;measureUnits=cm"
                                title="" data-categ="landingMenuMaker" data-value="joinButton10">Get started</a></div>
                            <div class="vc_empty_space  space-md-48 space-sm-32" style="height: 66px">
                            <span class="vc_empty_space_inner"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="vc_row-full-width vc_clearfix"></div>
        <div class="container">
            <div class="row margin-top-80-56-32">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="vc_column-inner">
                                <div class="wpb_text_column wpb_content_element ">
                                    <div class="wpb_wrapper">
                                        <h2 class="h-lg-40 h-md-40 h-sm-34-40" style="text-align: center;">30,000+ Ready-to-use {{ $category_obj->name }} Templates</h2>
                                        <p style="text-align: center;">Making {{ $category_obj->name }} designs never been easier</p>
                                    </div>
                                </div>
                                <div class="vc_empty_space" style="height: 32px"><span class="vc_empty_space_inner"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="crello-templates-grid-wrapper">
                        @foreach ($templates as $template)
                        <div class="template">
                            <a href="{{ route( 'template.productDetail', [
                                    'country' => $country,
                                    'slug' => $template->slug
                                ] ) }}">
                                <img loading="lazy" 
                                    src="{{ asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["carousel"] ) }}" 
                                    alt="{{ $template->title }}">
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <div class="vc_empty_space  space-md-56 space-sm-32" style="height: 64px"><span class="vc_empty_space_inner"></span></div>
                    <div class="vc_btn3-container  padding-44 vc_btn3-center"><a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-rounded vc_btn3-style-btn-crello vc_btn3-color-btn-blue" href="https://crello.com/inspiration/" title="" data-categ="landingMenuMaker" data-value="joinButton11">Browse all templates</a></div>
                    <div class="vc_empty_space  space-md-56 space-sm-48" style="height: 80px"><span class="vc_empty_space_inner"></span></div>
                </div>
            </div>
        </div>
    </section>
@endsection