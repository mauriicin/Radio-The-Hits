<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Chat da equipe</h3>
	</div>
	<div class="panel-body">
		<div id="chat">
			<div class="messages">
				<center class="chat-load"><small>Carregando [...]</small></center>
			</div>

			<div class="box-enviar">
				<form action="javascript:chat.send();" method="post" class="chat-form">
					<input type="text" class="form-control enviar-msg" id="inputDefault" placeholder="Digite sua mensagem...">
					<button type="submit" class="btn btn-info chat-send">Enviar</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script>nick_chat = '<?=$_SESSION["login"];?>';</script>

<script>

chat = {
    last: 0,
    interval: 0,
    update: function (first) {
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: '/acp/lib/chat_update.php?last=' + chat.last,
            success: function (html) {
                $(".chat-load").remove();
                i = 0;
                while (i < html.length) {
                    dados = html[i];

                    if (chat.last != dados['id']) {
                        chat.addMsg(dados['id'], dados['nick'], dados['cargo'], dados['msg'], dados['avatar']);
                        chat.last = dados['id'];
                    }

                    i++;
                }
                clearTimeout(chat.interval);
                chat.interval = setTimeout(function () {
                    chat.update('no');
                }, 2500);
            }
        });
    },
    addMsg: function (id, nick, cargo, msg, avatar) {
        msg_add = '<div class="msg">';
        msg_add += '<div id="img" style="background:url('+avatar+') no-repeat center center;"></div>';
        msg_add += '<div id="infos"><span style="font-size:13px;"><b>' + nick + '</b> - ' + cargo + ':</span><br>';
        msg_add += msg;
        msg_add += '</div><br></div>';
        $(".messages").prepend(msg_add);
    },
    addInfo: function (info) {
        info_add = ' <div class="well well-sm">';
        info_add += info;
        info_add += '</div>';
        $(".messages").prepend(info_add);
    },
    send: function () {
        msg = $(".enviar-msg").val();
        $(".enviar-msg, .chat-send").attr('disabled', true).removeClass('red');
        if (msg == '') {
            $(".enviar-msg, .chat-send").attr('disabled', false);
            $(".chat-form").addClass("has-error");
            setTimeout('$(".chat-form").removeClass("has-error")', 1000);
        }
        if (msg != '' && msg != '/regras' && msg != '/regras ') {
            $.ajax({
                type: 'POST',
                data: {
                    'msg': msg
                },
                dataType: "JSON",
                url: '/acp/lib/chat_enviar.php',
                success: function (html) {
                    if (html.concluido == true) {
                        $(".enviar-msg").val('').attr('disabled', false);
                        $(".chat-send").attr('disabled', false);
                    }
                    if (html.erro == true) {
                        $(".enviar-msg").val('').attr('disabled', false);
                        $(".chat-send").attr('disabled', false);
                        chat.addInfo(html.erro_msg);
                    }
                    clearTimeout(chat.interval);
                    chat.update('no');
                }
            });
        }
        if (msg == '/regras' || msg == '/regras ') {
            cmd = '<b>Regras do chat:</b><br>';
            cmd += '- Não floode e nÃ£o desrespeite qualquer membro.';
            chat.addInfo(cmd);

            $(".enviar-msg").val('').attr('disabled', false);
            $(".chat-send").attr('disabled', false);
        }
    },
    start: function () {
        chat.update('yes');
    }
}
$(document).ready(function () {
    $('.messages').slimScroll({
        height: '336px'
    });
    chat.start();
})

</script>