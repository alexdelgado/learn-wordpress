<table>
	<tr>
		<td>
			<label for="article-title">Title:</label>
		</td>
		<td>
			<input type="text" name="article_title" id="article-title" value="<?php echo $title ?>" class="regular-text">
		</td>
	</tr>
	<tr>
		<td>
			<label for="article-description">Description:</label>
		</td>
		<td>
			<input type="text" name="article_description" id="article-description" value="<?php echo $description ?>" class="regular-text">
		</td>
	</tr>
	<tr>
		<td>
			<label for="article-description">Radio:</label>
		</td>
		<td>
			<input type="hidden" name="cb" value="">
			<label>
				<input type="checkbox" name="cb[1]" id="cb1" value="cb1" <?php if( isset($cb[1]) ) { checked($cb[1], 'cb1', true); } ?>>
				<span>one</span>
			</label>
			<label>
				<input type="checkbox" name="cb[2]" id="cb2" value="cb2" <?php if(isset($cb[2]) && $cb[2] == 'cb2') { echo 'checked="checked"'; } ?>>
				<span>two</span>
			</label>
			<label>
				<input type="checkbox" name="cb[3]" id="cb3" value="cb3" <?php if(isset($cb[3]) && $cb[3] == 'cb3') { echo 'checked="checked"'; } ?>>
				<span>three</span>
			</label>
		</td>
	</tr>
</table>
