<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>林格贝尔在线办公系统</title>
        <link href="/Public/img/title.ico" rel="SHORTCUT ICON" />
        <link rel="stylesheet" type="text/css" href="/Public/bootstrap/css/bootstrap.css" media="all">
        <link rel="stylesheet" type="text/css" href="/Public/bootstrap/css/bootstrapValidator.css" media="all">
        <link rel="stylesheet" type="text/css" href="/Public/bootstrap/css/font-awesome.css" media="all">
        <link rel="stylesheet" type="text/css" href="/Public/bootstrap/css/docs.min.css" media="all">
        <link rel="stylesheet" type="text/css" href="/Public/bootstrap/css/path.css" media="all">
        <script type="text/javascript" src="/Public/js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="/Public/bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript" src="/Public/bootstrap/js/bootstrapValidator.js"></script>
        <!--<script type="text/javascript" src="/Public/css/smart.css"></script>-->
        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="popover"]').popover();
            });
            function windowopen(url) {
                var openUrl = url;//弹出窗口的url
                var iWidth = 800; //弹出窗口的宽度;
                var iHeight = 600; //弹出窗口的高度;
                var iTop = (window.screen.availHeight - 30 - iHeight) / 2; //获得窗口的垂直位置;
                var iLeft = (window.screen.availWidth - 10 - iWidth) / 2; //获得窗口的水平位置;
                window.open(openUrl, "", "height=" + iHeight + ", width=" + iWidth + ", top=" + iTop + ", left=" + iLeft);
                return false;
            }
            function loadF(flag){
                if(flag == 1)
                    $("#zhezhao").show();
                else
                    $("#zhezhao").hide();
            }
        </script>
        <style>
            body{
                background: #eee;
                background-image: url("/Public/img/furley_bg.png");
            }
            .btn-toolbar{
                font-size: 0;
                margin-top: 10px;
                margin-bottom: 10px;
            }
            .table{
                background-color: white;
            }
            #zhezhao{
                height:100%;
                width:100%;
                position: absolute;
                left:0;
                top:0;
                background-color: gainsboro;
                filter:alpha(opacity=50);
                -moz-opacity:0.5;
                -khtml-opacity: 0.5;
                opacity: 0.5;
                padding-top:200px;
                z-index: 10000;
                display: none;
                font:30px black;
            }
        </style>
    </head>
    <body>
        <div id="zhezhao">
            <center><i class="icon-spinner"></i></center>
        </div>
        <div class="container-fluid">