<div id="text"><?=$text['text']?>
	<div id="mean"></div>
</div>

<div id="pages">
	<form action="" method="POST"> 
		<? if ($text['pages']['num_act'] > 0) { ?>
			<span class="page"><input type="submit" name="page" value="1"></span> 
				<? if ($text['pages']['num_act'] > 1) { ?>
					<span class="page"><input type="submit" name="page" value="<?=$text['pages']['num_act']?>"></span> 
				<? } ?>
		<? } ?>
		<span class="page"><?=$text['pages']['num_act']+1?></span> 
		<? if ($text['pages']['num_act'] != $text['pages']['num']-1) { ?>		
			<? if ($text['pages']['num_act'] != $text['pages']['num']-2) { ?>		
				<span class="page"><input type="submit" name="page" value="<?=$text['pages']['num_act']+2?>"></span> 
			<? } ?>
			<span class="page"><input type="submit" name="page" value="<?=$text['pages']['num']?>"></span> 
		<? } ?>
	</form>
</div>

<script type="text/javascript">
	let words = <?=json_encode($text['words'])?>;
	let pages = <?=json_encode($text['pages'])?>;
</script>

<script src="<?=ROOT?>script/jquery.js"></script>
<script type="text/javascript">
	let result = false;
	let resultFalse = '';

	$(document).ready(function(){
		$('.word').click(function() {
			let word = $(this).text();
			show (word);
			if (result) {
				$('#mean').text(result);
			} else {
				$('#mean').text(resultFalse);
			}
			result = false;
			word = false;
		});
	});

	function show (word) {
		word = word.toLowerCase();
		if (!words[word]) {
			ajaxSend(word);
		} else {
			result = words[word];
		}
	};

	function ajaxSend (word) {
		$.ajax({
		async: false,
		url: '<?=ROOT?>ajax/word',
		type: 'POST',
		data: word,
		timeout: 800,
		success: function(res){
			result = res;
		},
		error: function(jqXHR, textStatus) {
			if (textStatus === 'timeout') {
				result = 'false';
			}
		}});
	};
</script>