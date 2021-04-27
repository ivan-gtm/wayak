@extends('layouts.admin')

@section('title', 'Plantillas Formato Listo')

@section('css')
    <style>
        ul.jqtree-tree {
            list-style: none outside;
            margin-left: 0;
            margin-bottom: 0;
            padding: 0;
        }

            ul.jqtree-tree.jqtree-dnd {
                touch-action: none;
            }

            ul.jqtree-tree ul.jqtree_common {
                list-style: none outside;
                margin-left: 12px;
                margin-right: 0;
                margin-bottom: 0;
                padding: 0;
                display: block;
            }

            ul.jqtree-tree li.jqtree-closed > ul.jqtree_common {
                display: none;
            }

            ul.jqtree-tree li.jqtree_common {
                clear: both;
                list-style-type: none;
            }

            ul.jqtree-tree .jqtree-toggler {
                border-bottom: none;
                color: #333;
                text-decoration: none;
                vertical-align: middle;
            }

            ul.jqtree-tree .jqtree-toggler:hover {
                    color: #000;
                    text-decoration: none;
                }

            ul.jqtree-tree .jqtree-toggler.jqtree-closed {
                    background-position: 0 0;
                }

            ul.jqtree-tree .jqtree-toggler.jqtree-toggler-left {
                    margin-right: 0.5em;
                }

            ul.jqtree-tree .jqtree-toggler.jqtree-toggler-right {
                    margin-left: 0.5em;
                }

            ul.jqtree-tree .jqtree-element {
                cursor: pointer;
                position: relative;
                display: flex;
            }

            ul.jqtree-tree .jqtree-title {
                color: #1c4257;
                vertical-align: middle;
                margin-left: 1.5em;
            }

            ul.jqtree-tree .jqtree-title.jqtree-title-folder {
                    margin-left: 0;
                }

            ul.jqtree-tree li.jqtree-folder {
                margin-bottom: 4px;
            }

            ul.jqtree-tree li.jqtree-folder.jqtree-closed {
                    margin-bottom: 1px;
                }

            ul.jqtree-tree li.jqtree-ghost {
                position: relative;
                z-index: 10;
                margin-right: 10px;
            }

            ul.jqtree-tree li.jqtree-ghost span {
                    display: block;
                }

            ul.jqtree-tree li.jqtree-ghost span.jqtree-circle {
                    border: solid 2px #0000ff;
                    border-radius: 100px;
                    height: 8px;
                    width: 8px;
                    position: absolute;
                    top: -4px;
                    left: -6px;
                    box-sizing: border-box;
                }

            ul.jqtree-tree li.jqtree-ghost span.jqtree-line {
                    background-color: #0000ff;
                    height: 2px;
                    padding: 0;
                    position: absolute;
                    top: -1px;
                    left: 2px;
                    width: 100%;
                }

            ul.jqtree-tree li.jqtree-ghost.jqtree-inside {
                    margin-left: 48px;
                }

            ul.jqtree-tree span.jqtree-border {
                position: absolute;
                display: block;
                left: -2px;
                top: 0;
                border: solid 2px #0000ff;
                border-radius: 6px;
                margin: 0;
                box-sizing: content-box;
            }

            ul.jqtree-tree li.jqtree-selected > .jqtree-element,
            ul.jqtree-tree li.jqtree-selected > .jqtree-element:hover {
                background-color: #97bdd6;
                background: linear-gradient(#bee0f5, #89afca);
                text-shadow: 0 1px 0 rgba(255, 255, 255, 0.7);
            }

            ul.jqtree-tree .jqtree-moving > .jqtree-element .jqtree-title {
                outline: dashed 1px #0000ff;
            }

        ul.jqtree-tree.jqtree-rtl {
            direction: rtl;
        }

        ul.jqtree-tree.jqtree-rtl ul.jqtree_common {
                margin-left: 0;
                margin-right: 12px;
            }

        ul.jqtree-tree.jqtree-rtl .jqtree-toggler {
                margin-left: 0.5em;
                margin-right: 0;
            }

        ul.jqtree-tree.jqtree-rtl .jqtree-title {
                margin-left: 0;
                margin-right: 1.5em;
            }

        ul.jqtree-tree.jqtree-rtl .jqtree-title.jqtree-title-folder {
                    margin-right: 0;
                }

        ul.jqtree-tree.jqtree-rtl li.jqtree-ghost {
                margin-right: 0;
                margin-left: 10px;
            }

        ul.jqtree-tree.jqtree-rtl li.jqtree-ghost span.jqtree-circle {
                    right: -6px;
                }

        ul.jqtree-tree.jqtree-rtl li.jqtree-ghost span.jqtree-line {
                    right: 2px;
                }

        ul.jqtree-tree.jqtree-rtl li.jqtree-ghost.jqtree-inside {
                    margin-left: 0;
                    margin-right: 48px;
                }

        ul.jqtree-tree.jqtree-rtl span.jqtree-border {
                right: -2px;
            }

        span.jqtree-dragging {
            color: #fff;
            background: #000;
            opacity: 0.6;
            cursor: pointer;
            padding: 2px 8px;
        }

        /* ----- */
        h1 {
            font-size: 20px;
            margin-bottom: 16px;
        }

        h3 {
            font-size: 16px;
            font-weight: bold;
            margin: 16px 0 8px 0;
        }

        p {
            margin-bottom: 8px;
        }

        ul {
            margin-bottom: 8px;
        }

        #tree1 {
            background-color: #ccc;
            padding: 8px 16px;
            margin-bottom: 16px;
        }

        #tree1.block-style {
                background-color: #fafafa;
            }

        #nav {
            margin: 16px 0;
        }

        #nav .next {
                float: right;
            }

        .jqtree-tree .jqtree-loading > div .jqtree-title:after {
            content: url(spinner.gif);
            margin-left: 8px;
        }

        #tree1.jqtree-loading:after {
            content: url(spinner.gif);
        }

        pre {
            background-color: #333;
        }

        #scroll-container {
            height: 200px;
            overflow-y: scroll;
            -ms-user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
                    user-select: none;
            margin-bottom: 16px;
        }

        .block-style ul.jqtree-tree {
                margin-left: 0;
            }

        .block-style ul.jqtree-tree ul.jqtree_common {
                    margin-left: 2em;
                }

        .block-style ul.jqtree-tree .jqtree-element {
                    margin-bottom: 8px;
                    background-color: #ddd;
                    padding: 8px;
                }

        .block-style ul.jqtree-tree .jqtree-element .jqtree-title {
                        margin-left: 0;
                    }

        .block-style ul.jqtree-tree li.jqtree-selected > .jqtree-element,
                    .block-style ul.jqtree-tree li.jqtree-selected > .jqtree-element:hover {
                        background: #97bdd6;
                        text-shadow: none;
                    }
    </style>
@endsection


@section('content')

        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Categories Manager</h1>
            </div>
            <div class="col-12">
                <div id="tree1"></div>
                <button onclick="saveJSON()">SAVE JSON</button>
                <div id="json_string"></div>
            </div>
        </div>
        
    
    <script src="http://mbraak.github.io/jqTree/static/bower_components/jquery/dist/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="http://mbraak.github.io/jqTree/tree.jquery.js"></script>
    <script src="http://mbraak.github.io/jqTree/static/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        var data = {!! $data !!};
        
        $('#tree1').tree({
            data: data,
            // autoOpen: true,
            dragAndDrop: true,
            // autoOpen: 0
        }).on(
            'tree.move',
            function(event)
            {
                event.preventDefault();
                // do the move first, and _then_ POST back.
                event.move_info.do_move();
                // $.post('your_url', {tree: $(this).tree('toJson')});
                // json = $(this).tree('toJson');
                saveJSON();
            }
        );

        function saveJSON(){
            console.log( $('#tree1').tree('toJson') );
        }
        
    </script>
  @endsection