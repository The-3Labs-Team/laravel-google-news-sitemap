<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">

    @foreach($items as $item)
        <url>
            <loc>{{ url($item->link) }}</loc>
            <news:news>
                <news:publication>
                    <news:name>
                        {{ $item->publicationName) }}
                    </news:name>
                    <news:language>
                        {{ $item->publicationLanguage) }}
                    </news:language>
                </news:publication>
                <news:publication_date>
                    {{ $item->publicationDate }}
                </news:publication_date>
                <news:title>
                    {{ $item->title }}
                </news:title>
            </news:news>
        </url>
    @endforeach
</urlset>
