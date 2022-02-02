function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1)
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length)
        }
    }
    return ""
}
$(".play, .pause").click(function () {
    var player = document.getElementById("player");
    if ($(this).attr("class") === "pause") {
        document.cookie = "pausePlayer=";
        $(".pause").addClass("play").removeClass("pause");
        player.volume = 0
    } else {
        player.load();
        player.volume = (getCookie('volume')) ? getCookie('volume') : 0.01;
        $(".play").addClass("pause").removeClass("play");
    }
});

$("#gostei").click(function () {
    if ($(this).attr("class") !== "votado") {
        $(this).addClass("votado");
        $("#naogostei").addClass("votado");
        $("#resultado_like").fadeIn();
        setTimeout(function () {
            $("#resultado_like").fadeOut()
        }, 3000);
        setTimeout(function () {
            $("#naogostei,#gostei").removeClass("votado")
        }, 120000)
    } else {
        $("#ja_votou").fadeIn();
        setTimeout(function () {
            $("#ja_votou").fadeOut()
        }, 3000)
    }
});