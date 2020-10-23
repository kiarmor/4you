$(function() {
    "use strict";
    initPassword();
});

function initPassword() {
	$( document ).ready(function() {
		var click = false
		$('#getpin').click(function() {
			console.log('Click!')
			if (click) return;
			click = true
			$( this ).html('отправка...')
			$.ajax({
				url: '/getpin',
				method: 'POST',
				dataType: 'text',
				data: {
					'_token': $('#getpin').data('csrf')
				},
				success: data => {
					if (data == 'ok')
						$('#getpin').html('Отправлен!')
					else
						$('#getpin').html('Ошибка!')
					click = false
				},
				error: err => {
					console.log(err)
					click = false
				}
			})
		})
	})
}