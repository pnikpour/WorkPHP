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

$('document').ready(function() {

//	$('.color').change(function() {
//		hex = $('.color').val();
//		$('body').css('backgroundColor', hex);
//		$('.button').css('backgroundColor', hex);
//	});

	$('.button').mouseover(function() {
		$(this).animate({backgroundColor: '#D0D0D0'}, 'fast');
	});

	$('.button').mouseleave(function() {
		$(this).animate({backgroundColor: 'blue'}, 'fast');
	});

});
