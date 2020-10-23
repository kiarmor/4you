$(function() {
    "use strict";
    initCalculator();
});

function initCalculator () {
	$( document ).ready(function() {
		var moneys = parseInt($('.input-moneys').val())
		var rate = $('option:selected', $('.period-change')).data('rate');
		function updateObject(rateObj, resultMoneysObj, rate, resultMoneys) {
			rateObj.html(`+${rate}%`)
			resultMoneysObj.html(`${resultMoneys}$`)
		}

		$('.input-moneys').bind("change keyup input click", function() {
			if (this.value.match(/[^0-9]/g))
				this.value = this.value.replace(/[^0-9]/g, '');
		})

		$('.input-moneys').on('change', function() {
			moneys = parseInt($( this ).val());
			updateObject($('.rate'),
						 $('.moneys'),
						 rate, (rate / 100 * moneys).toFixed(2))
		})

		$('.add-m').click(function() {
			moneys += 10
			$( this ).parent('span').parent('div').children('input').val(moneys)
			updateObject($('.rate'),
						 $('.moneys'),
						 rate, (rate / 100 * moneys).toFixed(2))
		})

		$('.take-m').click(function() {
			if (moneys - 10 >= 0) {
				moneys -= 10
				$( this ).parent('span').parent('div').children('input').val(moneys)
				updateObject($('.rate'),
						 	 $('.moneys'),
							 rate, (rate / 100 * moneys).toFixed(2))
			}
		})

		$('.period-change').on('change', function() {
			let option = $("option:selected", this);
			rate = option.data('rate')
			updateObject($('.rate'),
						 $('.moneys'),
						 rate, (rate / 100 * moneys).toFixed(2))
		});
	});
}