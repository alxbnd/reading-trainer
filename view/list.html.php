<div class="headText">in base: <?=count($list)?> words</div>

<ul class="list">
	<?
		$path = ROOT.'dictionary/';
		foreach ($list as $word) {
			echo '<li><a href="'.$path.'word/'.$word.'">' . $word . '</a></li>';
		}
	?>
</ul>

<script type="text/javascript">let words = <?=json_encode($list)?></script>