/*! Rádio TheHits - Todos os direitos reservados - by @_theFX */

panel = {
	read_w: function(id) {
		$.ajax({
			url: 'lib/warning_read.php?id='+id,
			type: 'GET'
		}).done(function() {
			$("#btn-read-"+id).replaceWith('<button class="btn btn-default f-right">Você já leu este aviso</button>');
		});
	},
	start: function() {
		(($("body").hasClass('login'))) ? panel.page = 'login' : panel.page = 'panel';

		if(panel.page == 'panel') {
			$('.chart').easyPieChart({
				lineWidth: 12,
				size: 180,
				scaleColor: '#F5F7F8',
				lineCap: 'square',
				trackColor: '#EAEBEC'
			});

			$("input[type='file']").uniform();
			$(".chosen-select").chosen()
		}
	}
}

$(document).ready(function() {
	panel.start();
})

$(".form-submit").submit(function(event) {
	form_empty = false;

	if($(this).hasClass('form-full')) {
		$(this).find('input[type="text"]').each(function(index, el) {
			if($(this).val() == '') {
				form_empty = true;
			}
		});

		$(this).find('input[type="password"]').each(function(index, el) {
			if($(this).val() == '') {
				form_empty = true;
			}
		});

		$(this).find('textarea').each(function(index, el) {
			if($(this).val() == '') {
				form_empty = true;
			}
		});
	}

	if(form_empty) {
		$(this).effect('shake');
		event.preventDefault();
	} else {
		$(this).animate({'opacity': 0.5});
		submit = $(this).find('[type="submit"]');
		submit.attr('disabled', true);
	}
});

function deletar(button) {
	link = $(button).attr('rel');

	r = confirm("Tem certeza de que deseja deletar este registro?");

	if(r == true) {
		$.post('admin.php'+link, {}, function(html) {
			alert("Deletado!");
			location.reload();
		});
	}
}

function advert(button) {
	link = $(button).attr('rel');

	r = confirm("Tem certeza de que deseja advertir este usuário?");

	if(r == true) {
		$.post('admin.php'+link, {}, function(html) {
			alert("Advertido!");
			location.reload();
		});
	}
}

function ban(button) {
	link = $(button).attr('rel');

	motivo = prompt("Motivo do banimento:");
	data = prompt("Banido até quando? (DD/MM/AAAA)");

	if(motivo != null && data != null && motivo != '' && data != '') {
		$.post('admin.php'+link, {'motivo': motivo, 'data': data}, function(html) {
			alert("Banido!");
			location.reload();
		});
	}
}

function unban(button) {
	link = $(button).attr('rel');

	r = confirm("Tem certeza que deseja desbanir este usuário?");

	if(r == true) {
		$.post('admin.php'+link, {}, function(html) {
			alert("Desbanido!");
			location.reload();
		});
	}
}

function alerta(button) {
	link = $(button).attr('rel');

	alerta = prompt("Alerta:");

	if(alerta != null && alerta != '') {
		$.post('admin.php'+link, {'alerta': alerta}, function(html) {
			alert("Enviado!");
			location.reload();
		});
	}
}