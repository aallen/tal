$ = jQuery;
var episodes = [];

function pubDate(date) {
    if (typeof date === 'undefined') {
        date = new Date();
    }

    var pieces = date.toString().split(' '),
        offsetTime = pieces[5].match(/[-+]\d{4}/),
        offset = (offsetTime) ? offsetTime : pieces[5],
        parts = [
            pieces[0] + ',',
            pieces[2],
            pieces[1],
            pieces[3],
            pieces[4],
            offset
        ];

    return parts.join(' ');
}

function getEpisodes() {
    $('.node-episode').each(function(index) {
        el = $(this);
        episodes.push({
            number: parseInt(el.find('.field-name-field-episode-number').text()),
            date: pubDate(new Date(el.find('.date-display-single').text() + ' 12:00:00')),
            title: el.find('header h2 a.goto').text(),
            link: 'https://www.thisamericanlife.org' + el.find('header h2 a.goto').attr('href'),
            description: el.find('.content .field-name-body').text().trim()
        });
    });

    episodes = episodes.sort(function(a, b) {
        return a.number > b.number ? -1 : a.number < b.number ? 1 : 0;
    });

    episodes = Array.from(new Set(episodes.map(a => a.number)))
        .map(number => {
            return episodes.find(a => a.number === number)
        });
}

var loading = true;
setInterval(function() {
    var pager = $('.pager.ignore');
    if (pager.length && loading) {
        pager.click();
    } else {
        loading = false;
        getEpisodes();
    }
}, 2000);