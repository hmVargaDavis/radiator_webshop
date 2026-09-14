<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
        <image:image>
            <image:loc>{{ asset('images/hero/hero-radiator.jpg') }}</image:loc>
            <image:title>22K panelradiátor Budapest</image:title>
            <image:geo_location>Budapest, Hungary</image:geo_location>
        </image:image>
    </url>
    <url>
        <loc>{{ url('/radiatorok') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.95</priority>
    </url>
    <url>
        <loc>{{ url('/szallitas') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>{{ url('/csomag-tartalma') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ url('/velemenyek') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.65</priority>
    </url>
    <url>
        <loc>{{ url('/kapcsolat') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/api/katalogus.json') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>{{ url('/llms.txt') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.4</priority>
    </url>
    @foreach($products as $product)
    <url>
        <loc>{{ route('products.show', $product->slug) }}</loc>
        <lastmod>{{ optional($product->updated_at)->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
        @if($product->image)
        <image:image>
            <image:loc>{{ $product->image_url }}</image:loc>
            <image:title>{{ $product->name }}</image:title>
            <image:caption>{{ $product->meta_description ?: $product->short_description }}</image:caption>
            <image:geo_location>Budapest, Hungary</image:geo_location>
        </image:image>
        @endif
    </url>
    <url>
        <loc>{{ route('products.json', $product->slug) }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.55</priority>
    </url>
    @endforeach
</urlset>
