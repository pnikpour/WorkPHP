	
	$(document).ready(function() {
		$('#container').css('padding', '0px');
		$('#container').css('margin-right', 'auto');
		$('#container').css('margin-right', 'auto');
		$('#container').css('width', '800px');
		$('#bottomLine').animate({width: '+=100px'}, 'fast', function() {
			$('#topLine').animate({width: '+=100px'}, 'fast', function() {
				$('#leftLine').animate({height: '+=100px'}, 'fast', function() {
					$('#rightLine').animate({height: '+=100px'}, 'fast', function() {		
						$('#bottomLineBack').animate({width: '+=100px'}, 'fast', function() {
							$('#topLineBack').animate({width: '+=100px'}, 'fast', function() {
								$('#leftLineBack').animate({height: '+=100px'}, 'fast', function() {
									$('#rightLineBack').animate({height: '+=100px'}, 'fast', function() {
										$('#midLineBack').animate({height: '+=50px'}, 'fast', function() {
											$('#horizLineBack').animate({width: '+=50px'}, 'fast', function() {
												$('#horizLineFront').animate({width: '+=50px'}, 'fast', function() {
													$('#vertLineFront').animate({height: '+=50px'}, 'fast', function() {
														rotateDiag('#diagTopLeft');
														rotateDiag('#diagTopRight');
														rotateDiag('#diagTopMid');

														rotateDiag('#diagBottomLeft');
														rotateDiag('#diagBottomRight');
														rotateDiag('#diagBottomMid');

														rotateDiag('#diagMidLeft');
														rotateDiag('#diagMidRight');
														rotateDiag('#diagMidMid');
														
														drawHorizontalSupport('#horizLineTop');
														drawHorizontalSupport('#horizLineMid');
														drawHorizontalSupport('#horizLineBottom');

														drawVerticalSupport('#vertLineLeft');
														drawVerticalSupport('#vertLineRight');
														});
													});
												});
											});	
										});
									});
								});
							});
						});
					});
				});
			});
		});
	
	function drawHorizontalSupport(line) {
		$(line).animate({width: '+=100'}, 'fast');
	}
	
	function drawVerticalSupport(line) {
		$(line).animate({height: '+=100'}, 'fast');
	}
	
	function rotateDiag(line) {
		$(line).animate({height: '+=71px'}, 'fast', function() {
		$(line).animate({borderSpacing: 405}, {
				step: function(now, fx) {
					$(this).css('-webkit-transform', 'rotate('+now+'deg)');
			}, duration: 'fast'}, 'linear');
		});

	}
