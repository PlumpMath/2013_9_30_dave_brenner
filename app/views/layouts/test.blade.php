<head>
    @foreach ($assets as $asset)
        {{ $asset->src }}
    @endforeach
	<style>
		{{ $style }}
	</style>
</head>
<body>
	{{ $content }}
</body>