<?= '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL ?>
<rss version="2.0">
    <channel>
        <title><![CDATA[{{ $title }}]]></title>
        <link><![CDATA[{{ $link }}]]></link>
        <description><![CDATA[{{ $description }}]]></description>
        <language>{{ $language }}</language>
        <pubDate>{{ $pub_date }}</pubDate>
        @foreach($items as $item)
            <item>
                <title><![CDATA[{{ $item['title'] }}]]></title>
                <link>{{ $item['url'] }}</link>
                <description><![CDATA[{!! ! empty($item['content']) ? $item['content'] : ''  !!}]]></description>
                <author><![CDATA[{{ $title }}]]></author>
                <guid>{{ $item['id'] }}</guid>
                <pubDate>{{ $item['created_at']->toRssString() }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>
