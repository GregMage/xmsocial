<small>
	<div class="xmsocial_ratingblock">
		<div id="unit_long<{$image.id}>">
			<div id="unit_ul<{$image.id}>" class="xmsocial_unit-rating">
				<div class="xmsocial_current-rating" style="width:<{$image.rating.size}>;"><{$image.rating.text}></div>
				<div>
					<a class="xmsocial_r1-unit rater" href="rate.php?op=<{$save}>&amp;img_id=<{$image.id}>&rating=1&amp;source=1" title="<{$smarty.const._MA_WGGALLERY_RATING1}>" rel="nofollow">1</a>
				</div>
				<div>
					<a class="xmsocial_r2-unit rater" href="rate.php?op=<{$save}>&amp;img_id=<{$image.id}>&rating=2&amp;source=1" title="<{$smarty.const._MA_WGGALLERY_RATING2}>" rel="nofollow">2</a>
				</div>
				<div>
					<a class="xmsocial_r3-unit rater" href="rate.php?op=<{$save}>&amp;img_id=<{$image.id}>&rating=3&amp;source=1" title="<{$smarty.const._MA_WGGALLERY_RATING3}>" rel="nofollow">3</a>
				</div>
				<div>
					<a class="xmsocial_r4-unit rater" href="rate.php?op=<{$save}>&amp;img_id=<{$image.id}>&rating=4&amp;source=1" title="<{$smarty.const._MA_WGGALLERY_RATING4}>" rel="nofollow">4</a>
				</div>
				<div>
					<a class="xmsocial_r5-unit rater" href="rate.php?op=<{$save}>&amp;img_id=<{$image.id}>&rating=5&amp;source=1" title="<{$smarty.const._MA_WGGALLERY_RATING5}>" rel="nofollow">5</a>
				</div>
			</div>
			<div>
				<{$image.rating.text}>
			</div>
		</div>
	</div>
</small>