<?php
    $feedUrl = 'http://feed.thisamericanlife.org/talpodcast';

    $localFile = file_get_contents('./tal.json');
    if ($localFile) {
        $jsonFile = $localFile;
    } else {
        $feedContent = file_get_contents($feedUrl);
        echo $feedContent;
    }

    /**
     * Start XML output
     */

    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\r\n";
?>
<rss xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:anchor="https://anchor.fm/xmlns">
	<channel>
		<title>This American Life</title>
        <description>This American Life is a weekly public radio show, heard by 2.2 million people on more than 500 stations. Another 2.5 million people download the weekly podcast. It is hosted by Ira Glass, produced in collaboration with Chicago Public Media, delivered to stations by PRX The Public Radio Exchange, and has won all of the major broadcasting awards.</description>
        <language>en</language>
        <copyright>Copyright 1995-<?php echo date("Y"); ?> This American Life</copyright>
        <itunes:author>This American Life</itunes:author>
        <itunes:subtitle>This American Life is a weekly public radio show, heard by 2.2 million people on more than 500 stations. Another 2.5 million people download the weekly podcast.</itunes:subtitle>
        <itunes:owner> <itunes:email>rich@thislife.org</itunes:email> </itunes:owner>
        <itunes:category text="Society &amp; Culture" />
        <itunes:category text="Arts" />
        <itunes:category text="News"> <itunes:category text="Politics" />
        </itunes:category>
        <itunes:image href="https://files.thisamericanlife.org/sites/all/themes/thislife/img/tal-name-1400x1400.png" />
        <atom10:link xmlns:atom10="http://www.w3.org/2005/Atom" rel="self" type="application/rss+xml" href="http://feed.thisamericanlife.org/talpodcast" /><feedburner:info uri="talpodcast" /><atom10:link xmlns:atom10="http://www.w3.org/2005/Atom" rel="hub" href="http://pubsubhubbub.appspot.com/" /><feedburner:feedFlare href="http://www.podnova.com/add.srf?url=http%3A%2F%2Ffeed.thisamericanlife.org%2Ftalpodcast" src="http://www.podnova.com/img_chicklet_podnova.gif">Subscribe with Podnova</feedburner:feedFlare><feedburner:feedFlare href="http://www.netvibes.com/subscribe.php?url=http%3A%2F%2Ffeed.thisamericanlife.org%2Ftalpodcast" src="//www.netvibes.com/img/add2netvibes.gif">Subscribe with Netvibes</feedburner:feedFlare><feedburner:feedFlare href="https://add.my.yahoo.com/rss?url=http%3A%2F%2Ffeed.thisamericanlife.org%2Ftalpodcast" src="http://us.i1.yimg.com/us.yimg.com/i/us/my/addtomyyahoo4.gif">Subscribe with My Yahoo!</feedburner:feedFlare><feedburner:feedFlare href="http://feedly.com/#subscription/feed/http://feed.thisamericanlife.org/talpodcast" src="http://s3.feedly.com/feedburner/feedly.png">Subscribe with Feedly</feedburner:feedFlare><feedburner:feedFlare href="https://www.subtome.com/#/subscribe?feeds=http%3A%2F%2Ffeed.thisamericanlife.org%2Ftalpodcast" src="http://www.subtome.com/subtome-feedburner.png">Subscribe with SubToMe</feedburner:feedFlare><feedburner:feedFlare href="http://fusion.google.com/add?feedurl=http%3A%2F%2Ffeed.thisamericanlife.org%2Ftalpodcast" src="http://buttons.googlesyndication.com/fusion/add.gif">Subscribe with Google</feedburner:feedFlare>

<?php
    $episodes = json_decode( $jsonFile, true );
    foreach($episodes  as $episode) {
?>
        <item>
            <title><?php echo $episode['number'].': '.$episode['title']?></title>
            <link><?php echo $episode['link']?></link>
            <description><?php echo $episode['description']?></description>
            <pubDate><?php echo $episode['date']?></pubDate>
            <guid isPermaLink="false"><?php echo $episode['number']?></guid>
            <enclosure url="<?php echo 'http://assets.thisamericanlife.co/podcasts/' . $episode['number'] . '.mp3' ?>" type="audio/mpeg" />
            <itunes:author>This American Life</itunes:author>
            <itunes:image href="<?php echo 'http://assets.thisamericanlife.co/images/' . $episode['number'] . '.jpg' ?>" />
            <itunes:subtitle><?php echo $episode['description']?></itunes:subtitle>
            <itunes:summary><?php echo $episode['description']?></itunes:summary>
        </item>
<?php
    }
?>
    </channel>
</rss>