<?

error_reporting(0);

$ar=array();
$g=scandir('./images');
foreach($g as $x)
{
    if(is_dir($x))$ar[$x]=scandir($x);
    else $ar[]=$x;
}

unset($ar['.'], $ar['..']);

foreach($ar as $k => $v){
	$images[] = $v;
}

$winning_img = array('Go_Further.jpg');

$count = count($images);

foreach($images as $k => $v){
	if(in_array($v, $winning_img)){
		$winning_id[] = $k;
		$winning_item = '<li class="item" data-point="'.$k.'"><img src="./images/'.$v.'"></li>';
	}
	$col .= '<li class="item" data-point="'.$k.'"><img src="./images/'.$v.'"></li>';
}

?>

<!-- <link rel="stylesheet" href="ford-fonts/ford-fonts.css" />
<link rel="stylesheet" href="site/fonts/stylesheet.css" />

<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" type="text/css" media="only screen and (max-width: 1080px)" href="style-mobile.css" />
<link rel="stylesheet" type="text/css" media="only screen and (orientation: portrait)" href="style-portrait.css" /> -->

<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>

<script type="text/javascript" src="js/jquery-ui/jquery-ui.js"></script>
<link rel="stylesheet" href="js/jquery-ui/jquery-ui.css" />

<script type="text/javascript" src="js/datetimepicker/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="js/datetimepicker/jquery.datetimepicker.css" />

<!-- <script type="text/javascript" src="js/jquery.slimscroll.min.js"></script> -->

<!-- <script type="text/javascript" src="js/fireworks.js"></script>
 -->
<style type="text/css">

body {
	width: 100%;
	height: 100%;
	overflow: hidden;
	margin: 0;
	padding: 0;
	cursor: none;
}

#Break {
	display: inline-block;
	width: 100%;
}

.Spinners {
	position: relative;
	width: 100%;
	height: 100%;
	margin: 0 auto;
	text-align: center;
	background-color: #002f54;
}

.Spinners::before{
	background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(0,52,120,.5));
	background: -webkit-linear-gradient(bottom, rgba(255,255,255,0) 0%, rgba(0,52,120,.5));
	background: -o-linear-gradient(bottom, rgba(255,255,255,0) 0%, rgba(0,52,120,.5));
	background: -ms-linear-gradient(bottom, rgba(255,255,255,0) 0%, rgba(0,52,120,.5));
	background: linear-gradient(to top, rgba(255,255,255,0) 0%, rgba(0,52,120,.5));

	height: 33%;
	width: 100%;
	top: 0;
	left: 0;
	position: absolute;
	display: block;
	content: '';
	white-space: nowrap;
	z-index: 10;
}


.Spinners::after{
	background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(0,52,120,.5));
	background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(0,52,120,.5));
	background: -o-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(0,52,120,.5));
	background: -ms-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(0,52,120,.5));
	background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(0,52,120,.5));

	height: 33%;
	width: 100%;
	position: absolute;
	display: block;
	content: '';
	bottom: 0;
	left: 0;
	z-index: 10;
}

.Spinners ul {
	width: 33%;
	padding: 0;
	margin: 0;
	text-align: center;
	display: inline-block;
	list-style: none;
	white-space: nowrap;
	position: relative;
}

.Spinners ul li {
	border: 3px solid #ccc;
	margin: -3px;
	height: 33%;
	background-color: #fff;
}

.Spinners ul li img {
	max-height: 100%;
	max-width: 100%;
}

.Arrow {
	position: absolute;
	height: 10%;
	width: 10%;
	display: block;
	top: 50%;
	margin: 0 3px;
	margin-top: -2.5%;
	z-index: 10;
	max-width: 10%;
	max-height: 10%;
	background-size: contain;
	background-repeat: no-repeat;
}

.Left {
	background-image: url(site/arrow-left.png);
	background-position: center left;
	left: 0;
}

.Right {
	background-image: url(site/arrow-right.png);
	background-position: center right;
	right: 0;
}


</style>

<script type="text/javascript">
$(document).ready(function(){

	$.fn.randomize = function(selector){
		var $elems = selector ? $(this).find(selector) : $(this).children(),
			$parents = $elems.parent();

		$parents.each(function(){
			$(this).children(selector).sort(function(){
				return Math.round(Math.random()) - 0.5;
			// }). remove().appendTo(this); // 2014-05-24: Removed `random` but leaving for reference. See notes under 'ANOTHER EDIT'
			}).detach().appendTo(this);
		});

		return this;
	};

	shuffle = function(o){ //v1.0
		for(var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
		return o;
	};

	$('ul').randomize();

	$('body').on('keypress', this, function(event) {
		if( event.which == 13 ){
			spin(event);
		}
	});

	$('body').on('click', this, function(event) {
		spin(event);
	});

	var odds = 0;

	function spin(event_fired){
		$('body').off('click');
		$('body').off('keypress');

		$.ajax({
			type: "POST",
			url: "spin-ajax.php",
			data: {get_odds: 'yes'},
		}).done(function(msg) {
			odds = msg;
			console.log(odds);

			setTimeout(function(){
				$('body').on('keypress', this, function(event) {
					if( event.which == 13 ){
						spin(event);
					}
				});

				$('body').on('click', this, function(event) {
					spin(event);
				});
			}, 12000);

			var speed = 3500;
			var difference = $('li').outerHeight();
			var i = 3;

			$('ul').randomize();

			var results = [];
			$('ul').each(function(){
				results.push($(this).find('li:eq(1)').data('point'));
			});

			$.unique(results);

			var winning_id = <?= json_encode($winning_id) ?>;
			shuffle(winning_id);

			if(odds == 1){
				$('ul#one').find('li[data-point="'+winning_id[0]+'"]').first().insertAfter($('ul#one').find('li:eq(0)'));
				$('ul#two').find('li[data-point="'+winning_id[0]+'"]').first().insertAfter($('ul#two').find('li:eq(0)'));
				$('ul#three').find('li[data-point="'+winning_id[0]+'"]').first().insertAfter($('ul#three').find('li:eq(0)'));
				console.log($('ul#one').find('li[data-point="'+winning_id[0]+'"]'));
			}
			else if(results.length == 1){
				$('ul#three').children('li:eq(1)').insertAfter($('ul#three').children('li:eq(2)'));
			}

			$('ul').each(function(){
				var height = $(this).outerHeight();
				difference = difference * i;
				$(this).css('top', '-'+ (height - difference));

				speed =  speed * 1.5;
				$(this).stop().animate({
					'top' : 0,
				}, speed, 'easeOutCubic');
			});
		});
	}

});
</script>

<div class="Spinners">

	<div class="Left Arrow"></div>
	<div class="Right Arrow"></div>

	<ul id="one">
		<?= $col.$col.$col.$col.$col.$col.$col.$col.$col.$col ?>
	</ul>

	<ul id="two">
		<?= $col.$col.$col.$col.$col.$col.$col.$col.$col.$col ?>
	</ul>

	<ul id="three">
		<?= $col.$col.$col.$col.$col.$col.$col.$col.$col.$col ?>
	</ul>
	<div id="Break"></div>
</div>