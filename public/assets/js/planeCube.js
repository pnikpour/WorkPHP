//**************************************************************************
// This file is part of the BlueberryPHP project.
// 
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
// 
// Programmer: Parsa Nikpour 
// Date: 16 June 2014
// Description:  
// 
//**************************************************************************

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

