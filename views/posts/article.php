<table>
	<tr>
		<th>&nbsp;</th>
		<th>ACF</th>
		<th>CMB2</th>
		<th>WordPress API</th>
	</tr>
	<tr>
		<th>Title</th>
		<td><?php ( function_exists( 'the_field' ) ? the_field( 'title' ) : '' ) ?></td>
		<td><?php echo get_post_meta( get_the_ID(), 'cmb2_article_title', true ) ?></td>
		<td><?php echo get_post_meta( get_the_ID(), 'article-title', true ) ?></td>
	</tr>
	<tr>
		<th>Description</th>
		<td><?php ( function_exists( 'the_field' ) ? the_field( 'description' ) : '' ) ?></td>
		<td><?php echo get_post_meta( get_the_ID(), 'cmb2_article_description', true ) ?></td>
		<td><?php echo get_post_meta( get_the_ID(), 'article-description', true ) ?></td>
	</tr>
</table>
