$(document).ready(function() {
	var $toggleButton = $('.toggle-button'),
		$menuWrap = $('.menu-wrap'),
		$navBox = $('.nav-box'),
		$editButton = $('.edit-button'),
		$doneButton = $('.done-button'),
		$plus = $('.plus'),
		$minus = $('.minus'),
		$red = $('.red'),
		$orange = $('.orange'),
		$yellow = $('.yellow'),
		$green = $('.green'),
		$blue = $('.blue'),
		$purple = $('.purple'),
		$brown = $('.brown'),
		$color = $('.color'),
		$subHeading = $('.settings-sub-heading'),
		$cancel = $('.cancel'),
		$checklistplus = $('.checklists-plus');
	
	$toggleButton.on('click', function() {
		$(this).toggleClass('button-open');
		$menuWrap.toggleClass('menu-show');
		$navBox.toggleClass('sidebar-open');
	});

	$editButton.on('click', function() {
		$(this).toggleClass('invis-edit');
		$doneButton.toggleClass('invis-done');
		$plus.toggleClass('invis-plus');
		$minus.toggleClass('invis-done');
	});
	$doneButton.on('click', function() {
		$(this).toggleClass('invis-done');
		$editButton.toggleClass('invis-edit');
		$plus.toggleClass('invis-plus');
		$minus.toggleClass('invis-done');
	});

	$red.on('click', function() {
		$color.removeClass('active-color');
		$(this).addClass('active-color');
		$subHeading.css('color', '#FF0000');
	});
	$orange.on('click', function() {
		$color.removeClass('active-color');
		$(this).addClass('active-color');
		$subHeading.css('color', '#FFA200');
	});
	$yellow.on('click', function() {
		$color.removeClass('active-color');
		$(this).addClass('active-color');
		$subHeading.css('color', '#FFDD00');
	});
	$green.on('click', function() {
		$color.removeClass('active-color');
		$(this).addClass('active-color');
		$subHeading.css('color', '#00E636');
	});
	$blue.on('click', function() {
		$color.removeClass('active-color');
		$(this).addClass('active-color');
		$subHeading.css('color', '#2699FB');
	});
	$purple.on('click', function() {
		$color.removeClass('active-color');
		$(this).addClass('active-color');
		$subHeading.css('color', '#CC00FF');
	});
	$brown.on('click', function() {
		$color.removeClass('active-color');
		$(this).addClass('active-color');
		$subHeading.css('color', '#9A7777');
	});
	
	$plus.on('click', function() {
		document.getElementById('myForm').style.display = "block";
	});
	$cancel.on('click', function() {
		document.getElementById('myForm').style.display = "none";
	});
	
	$checklistplus.on('click', function() {
		document.getElementById('myForm').style.display = "block";
	});
});