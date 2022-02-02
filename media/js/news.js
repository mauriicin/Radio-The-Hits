/*! Rádio TheHits - Todos os direitos reservados - by @_theFX */

news = {
	start: function() {
		$("article.news img").each(function(index) {
			src = $(this).attr('src');
			$(this).wrap('<a href="'+src+'" data-lightbox="image-'+index+'"></a>');
		});
	}
}

$(document).ready(function() {
	news.start();
})

window.fbAsyncInit = function() {
	FB.init({
		appId      : '736997406376081',
		xfbml      : true,
		version    : 'v2.2'
	});
};

(function(d, s, id){
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));