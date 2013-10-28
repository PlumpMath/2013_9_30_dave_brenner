<!DOCTYPE html>
    <!--[if IE 7 ]>    <html class="no-js ie7"> <![endif]-->
    <!--[if (gt IE 7)|!(IE)]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="cleartype" content="on">
        @foreach ($assets as $asset)
            {{ $asset->src }}
        @endforeach
    </head>
    <body>
        {{ $content }}
    </body>
</html>
