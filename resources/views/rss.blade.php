<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">

    @foreach($items as $item)
        <url>
            <loc>{{ url($item->link) }}</loc>
            <news:news>
                <news:publication>
                    <news:name>
                        {!! The3LabsTeam\GoogleNewsFeed\Helpers\Cdata::out($item->publicationName) !!}
                    </news:name>
                    <news:language>
                        {!! The3LabsTeam\GoogleNewsFeed\Helpers\Cdata::out($item->publicationLanguage) !!}
                    </news:language>
                </news:publication>
                <news:publication_date>
                    {!! The3LabsTeam\GoogleNewsFeed\Helpers\Cdata::out($item->publicationDate ) !!}
                </news:publication_date>
                <news:title>
                    {!! The3LabsTeam\GoogleNewsFeed\Helpers\Cdata::out($item->title) !!}
                </news:title>
            </news:news>
        </url>
    @endforeach

</urlset>
