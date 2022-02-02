var puxaimg = {
    init: function () {
        puxaimg['atualiza']();
    },
    atualiza: function () {
        $['ajax']({
            type: 'GET',
            url: '/lib/musica.php',
            success: function (_0xa71bx3) {
                $('.puxamusica')['html'](_0xa71bx3);
                $('.geratt')['attr']('href', 'https://twitter.com/share?url=http://www.radiothehits.com/&via=radiothehits&text=Estou Ouvindo ' + _0xa71bx3 + ' na #TheHits!');
                $['ajax']({
                    url: 'http://itunes.apple.com/search',
                    data: {
                        term: _0xa71bx3,
                        media: 'music'
                    },
                    dataType: 'jsonp',
                    success: function (_0xa71bx4) {
                        if (_0xa71bx4['results']['length'] === 0) {
                            return
                        };
                        var _0xa71bx5 = _0xa71bx4['results'][0]['artworkUrl100'];
                        var _0xa71bx5 = _0xa71bx5['replace']('100x100', '2000x2000');
                        $('.r-img')['css']('background-image', 'url(' + _0xa71bx5 + ')');
                    }
                });
            }
        });
        $['ajax']({
            type: 'GET',
            url: '/lib/musica-prox.php',
            success: function (_0xa71bx3) {
                $('.puxamusica-prox')['html'](_0xa71bx3);
            }
        });
        setTimeout(function () {
            puxaimg['atualiza']()
        }, 500);
    }
};
$(document)['ready'](function () {
    puxaimg['init']()
});