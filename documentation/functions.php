<?php

class Docs {

	private static $docs = array();

	public static function add($function, $text, $sample = '', $params = '') {
		if($sample) {
			$sample = hyperlight($sample);
		}

		static::$docs[] = compact(array('function', 'text', 'sample', 'params'));
	}

	public static function list_all() {
		return static::$docs;
	}

}

/*
	has_posts
*/
$text = 'Checks if there are any published posts. Returns <code>true</code> if there are, <code>false</code> if not. Should be used in conjunction with <code><a href="#posts">posts()</a></code> like this:';

$sample = '<?php if(has_posts()): ?> 
<!-- We have posts, it\'s safe to loop. -->
<?php while(posts()): ?>
<!-- We can use article functions now: <?php echo article_title(); ?> -->
<?php endwhile; ?>
<?php endif; ?>';

Docs::add('has_posts', $text, $sample);

/*
	posts
*/
$text = 'Counts through every visible post, one, by one. Returns <code>true</code> when there is more posts to be listed or <code>false</code> when we are at the end. Should be used like this:';

$sample = '<?php while(posts()): ?>
<!-- Loop through the posts. -->
<?php endwhile; ?>';

Docs::add('posts', $text, $sample);

/*
	article_id
*/
$text = 'Returns the database-assigned ID of the current article, as a number. Used for uniquely identifying a post.';
Docs::add('article_id', $text);

/*
	article_title
*/
$text = 'Returns the title of the current article as a string, as set in the admin area.';
Docs::add('article_title', $text);

/*
	article_slug
*/
$text = 'Returns the slug of the current article. Should not be used in <code>posts.php</code> (you should use <code><a href="#article_url">article_url()</a></code> 	instead, which will correctly calculate the URL).';

Docs::add('article_slug', $text);

/*
	article_url
*/
$text = 'Returns a fully-built URL string, which serves as a permalink. Should be used like so:';

$sample = '<a href="<?php echo article_url(); ?>">
<?php echo article_title(); ?>
</a>';

Docs::add('article_url', $text, $sample);

/*
	article_description
*/
$text = 'Returns a short description, as set in the "description" field of the admin area.';
Docs::add('article_description', $text);

/*
	article_time
*/
$text = 'Returns a <a href="http://php.net/manual/en/function.time.php">UNIX timestamp</a> from when the post was added, which can be used to add custom timestamps. If you want to use the default timestamp, use <code><a href="#article_date">article_date()</a></code> instead.';

Docs::add('article_time', $text);

/*
	article_date
*/
$text = 'Returns a date-formatted version of <code><a href="#article_time">article_time()</a></code>. Default format is jS M, Y (24th January, 2012).';
Docs::add('article_date', $text);

/*
	article_html
*/
$text = 'Returns the content of the blog post, as a HTML string.';
Docs::add('article_html', $text);

/*
	article_css
*/
$text = 'If custom CSS was added, returns the custom CSS. Should be used like this: ';

$sample = '<?php if(article_css()): ?>
<style><?php echo article_css(); ?></style>
<?php endif; ?>';

Docs::add('article_css', $text, $sample);

/*
	article_js
*/
$text = 'Similar to <code>article_css()</code>, but with Javascript. Should be used like this: ';

$sample = '<?php if(article_js()): ?>
<script><?php echo article_js(); ?></script>
<?php endif; ?>';

Docs::add('article_js', $text, $sample);

/*
	article_status
*/
$text = 'Returns a string which contains the current status of the article. Can be either <b>draft</b>, <b>archived</b>, <b>published</b>.';
Docs::add('article_status', $text);

/*
	article_total_comments
*/
$text = 'Returns the total number of published comments for the current article.';
Docs::add('article_total_comments', $text);

/*
	article_author
*/
$text = 'Returns the name of the post author as a string.';
Docs::add('article_author', $text);

/*
	article_author_bio
*/
$text = 'Returns the biography of the current post author.';
Docs::add('article_author_bio', $text);

/*
	article_custom_fields
*/
$text = 'Checks whether an article has any custom fields attached to it. Returns <code>true</code> if there are custom fields, <code>false</code> if not.';
Docs::add('article_custom_fields', $text);

/*
	article_custom_field
*/
$params = '$key, $fallback = \'\'';

$text = 'Retrieves a custom field with the key <code>$key</code>, with an optional fallback parameter (<code>$fallback</code>). Used like so: ';

$sample = '<small class="attribution">
Thanks to <?php echo article_custom_field(\'attribution\', \'Mike\'); ?>
</small>';

Docs::add('article_custom_field', $text, $sample, $params);

/*
	customised
*/
$text = 'Returns <code>true</code> if an article has custom CSS or Javascript attached to it, <code>false</code> if not.';
Docs::add('customised', $text);

/*
	has_comments
*/
$text = 'Checks if there are comments attached to the post. Returns <code>true</code> if there are, <code>false</code> if not.';
Docs::add('has_comments', $text);

/*
	total_comments
*/
$text = 'Returns an integer depicting the number of published comments.';
Docs::add('total_comments', $text);

/*
	comments
*/
$text = 'A loop, similar to <code><a href="#posts">posts()</a></code>, which returns <code>true</code> if there are any subsequent comments, <code>false</code> if not. Should be used as such:';

$sample = '<?php if(comments_open() and has_comments()): ?>
<?php while(comments()): ?>
<!-- We\'ve got comments, let\'s go. -->
<?php endwhile; ?>
<?php endif; ?>';

Docs::add('comments', $text, $sample);

/*
	comment_id
*/
$text = 'Returns the ID of the current comment as an integer.';
Docs::add('comment_id', $text);

/*
	comment_time
*/
$text = 'Returns a <a href="http://php.net/manual/en/function.time.php">UNIX timestamp</a> from when the post was added, which can be used to add custom timestamps. If you want to use the default timestamp, use <code><a href="#comment_date">comment_date()</a></code> instead.';
Docs::add('comment_time', $text);

/*
	comment_date
*/
$text = 'Returns a date-formatted version of <code><a href="#comment_time">comment_time()</a></code>. Default format is jS M, Y (24th January, 2012).';
Docs::add('comment_date', $text);

/*
	comment_name
*/
$text = 'Returns the name of the commenter as a string.';
Docs::add('comment_name', $text);

/*
	comments_text
*/
$text = 'Returns the text body of the comment as a string.';
Docs::add('comments_text', $text);

/*
	comments_open
*/
$text = 'Checks if comments are allowed. Returns <code>true</code> if there are, <code>false</code> if not.';
Docs::add('comments_open', $text);

/*
	comment_form_notifications
*/
$text = 'Returns messages (if any) based on the input of a comment form. It is highly recommended you use this function within your comment form. Used like so: ';

$sample = '<!-- Got error messages? If so, echo. -->
<?php echo comment_form_notifications(); ?>';

Docs::add('comment_form_notifications', $text, $sample);

/*
	comment_form_input_name
*/
$text = 'Returns the HTML source of the name input, plus an optional parameter of <code>$extra</code>, which adds extra attributes. Used like so: ';

$sample = '<?php
echo comment_form_input_name(\'class="input red" placeholder="Your Name"\');
?>';

$params = '$extra = \'\'';

Docs::add('comment_form_input_name', $text, $sample, $params);

/*
	comment_form_input_email
*/
$text = 'Returns the HTML source of the email input, plus an optional parameter of <code>$extra</code>, which adds extra attributes. Used in the same manner as <code><a href="#comment_form_input_name">comment_form_input_name()</a></code>';

$params = '$extra = \'\'';

Docs::add('comment_form_input_email', $text, '', $params);

/*
	comment_form_input_text
*/
$text = 'Returns the HTML source of the email textarea, plus an optional parameter of <code>$extra</code>, which adds extra attributes. Used in the same manner as <code><a href="#comment_form_input_name">comment_form_input_name()</a></code>';

$params = '$extra = \'\'';

Docs::add('comment_form_input_text', $text, '', $params);

/*
	comment_form_button
*/
$text = 'Returns the HTML source of the submit button on the comment form, with two optional parameters of <code>$text</code>, which fills the button with custom text <code>$extra</code>, which adds extra attributes. Used in the same manner as <code><a href="#comment_form_input_name">comment_form_input_name()</a></code>';

$params = '$text = \'Post Comment\', $extra = \'\'';

Docs::add('comment_form_button', $text, '', $params);

/*
	base_url
*/
$text = 'Returns the relative path to the current Anchor install. If the install is at <code>http://my.site.org/anchor/</code>, it will return <code>/anchor/</code>.';
Docs::add('base_url', $text);

/*
	theme_url
*/
$text = 'Returns the full relative path to the theme, plus any extra paths appended with <code>$append</code>.';

$params = '$append = \'\'';

Docs::add('theme_url', $text, '', $params);

/*
	current_url
*/
$text = 'Returns the current page URL. Similar to <code>$_SERVER[\'REQUEST_URI\'];</code>.';
Docs::add('current_url', $text);

/*
	admin_url
*/
$text = 'Returns the full relative path to the admin area, plus any extra paths appended with <code>$append</code>.';

$params = '$append = \'\'';

Docs::add('admin_url', $text, '', $params);

/*
	search_url
*/
$text = 'Returns the full relative path to the search area.';
Docs::add('search_url', $text);

/*
	rss_url
*/
$text = 'Returns the full relative path to the rss feed.';
Docs::add('rss_url', $text);

/*
	bind
*/
$text = 'Bind a function to a page slug (<code>$page</code>). The <code>$page</code> parameter can either be a slug on its own ("about"), or a slug suffixed with an \'area name\' ("about.area"); that is, if there are multiple bind/recieve calls, this will avoid duplicate function calls. Used in conjunction with <code>recieve()</code> like such: ';

$sample = '<?php bind(\'about\', function() {
return \'This function only gets run on the about page!\'
}); ?>';

$params = '$page, $function';

Docs::add('bind', $text, $sample, $params);

/*
	recieve
*/
$text = 'When used in page.php, recieves any bind calls. The one parameter is <code>$name</code>, which is the same as <code>$page</code>. Used as such (see the <a href="#bind">previous example</a> for the <code>bind()</code> version):';

$sample = '<?php recieve(\'about\'); ?>';

$params = '$name = \'\'';

Docs::add('recieve', $text, $sample, $params);

/*
	is_homepage
*/
$text = 'Returns <code>true</code> if the current page is the default homepage page and <code>false</code> if not.';
Docs::add('is_homepage', $text);

/*
	is_postspage
*/
$text = 'Returns <code>true</code> if the current page is the posts listings page and <code>false</code> if not.';
Docs::add('is_postspage', $text);

/*
	is_debug
*/
$text = 'Returns <code>true</code> if the site is running in a debug mode and <code>false</code> if not.';
Docs::add('is_debug', $text);

/*
	execution_time
*/
$text = 'Returns the total page execution time in seconds';
Docs::add('execution_time', $text);

/*
	memory_usage
*/
$text = 'Returns the peak memory usage in kilobytes';
Docs::add('memory_usage', $text);

/*
	db_profile
*/
$text = 'Returns a html table with a list of all database queries used to generate the current page.';
Docs::add('db_profile', $text);

/*
	has_menu_items
*/
$text = 'Checks if there are any menu items (suprisingly). Returns <code>true</code> if there are, <code>false</code> if not.';
Docs::add('has_menu_items', $text);

/*
	menu_items
*/
$text = 'Counts through every visible menu item, one, by one. Returns <code>true</code> when there is more posts to be listed or <code>false</code> when we are at the end. Should be used like this:';

$sample = '<?php while(menu_items()): ?>
<!-- Loop through the menu items. -->
<?php endwhile; ?>';

Docs::add('menu_items', $text, $sample);

/*
	menu_id
*/
$text = 'Returns the current menu item\'s ID';
Docs::add('menu_id', $text);

/*
	menu_url
*/
$text = 'Returns the current menu item\'s URL';
Docs::add('menu_url', $text);

/*
	menu_name
*/
$text = 'Returns the current menu item\'s name. This should be used instead of <code>menu_title()</code> to display.';
Docs::add('menu_name', $text);

/*
	menu_title
*/
$text = 'Returns the current menu item\'s title. This should be used instead of <code>menu_title()</code> as a <code>title=""</code> attribute.';
Docs::add('menu_title', $text);

/*
	menu_active
*/
$text = 'Checks if the menu item is active. Returns <code>true</code> if there are, <code>false</code> if not.';
Docs::add('menu_active', $text);

/*
	site_name
*/
$text = 'Returns the name of the Anchor site, as set in the metadata area of the admin panel.';
Docs::add('site_name', $text);

/*
	site_description
*/
$text = 'Returns the description of the Anchor site, as set in the metadata area of the admin panel.';
Docs::add('site_description', $text);

/*
	twitter_account
*/
$text = 'Returns the name of the Twitter account, as set in the metadata area of the admin panel.';
Docs::add('twitter_account', $text);

/*
	twitter_url
*/
$text = 'Returns the full URL path of the Twitter account, based on <code>twitter_account()</code>.';
Docs::add('twitter_url', $text);

/*
	page_id
*/
$text = 'Returns the current page\'s ID.';
Docs::add('page_id', $text);

/*
	page_url
*/
$text = 'Returns the current page\'s relative URL.';
Docs::add('page_url', $text);

/*
	page_name
*/
$text = 'Returns the current page\'s name. Should not be used to display; instead, use <code>page_title()</code>.';
Docs::add('page_name', $text);

/*
	page_title
*/
$text = 'Returns the current page title, with a fallback (<code>$fallback</code>), in the event of a missing page error.';

$params = '$fallback = \'\'';

Docs::add('page_title', $text, '', $params);

/*
	page_content
*/
$text = 'Returns the content of the current page, as a HTML string.';
Docs::add('page_content', $text);

/*
	page_active
*/
$text = 'Checks if the current page is active. Returns <code>true</code> if there are, <code>false</code> if not.';
Docs::add('page_active', $text);

/*
	page_status
*/
$text = 'Returns a string which contains the status of the current page. Can be either <b>draft</b>, <b>archived</b>, <b>published</b>.';
Docs::add('page_status', $text);

/*
	has_search_results
*/
$text = 'Checks if there are any search results. Returns <code>true</code> if there are, <code>false</code> if not.';
Docs::add('has_search_results', $text);

/*
	total_search_results
*/
$text = 'Returns an integer depicting the number of search results.';
Docs::add('total_search_results', $text);

/*
	search_results
*/
$text = 'Counts through every search result, one, by one. Returns <code>true</code> when there is more posts to be listed or <code>false</code> when we are at the end. Should be used like this:';

$sample = '<?php while(search_results()): ?>
<!-- Loop through the search results. -->
<?php endwhile; ?>';

Docs::add('search_results', $text, $sample);

/*
	search_term
*/
$text = 'Returns a safely-encoded version of the user\'s current search term.';
Docs::add('search_term', $text);

/*
	user_authed
*/
$text = 'Checks if the user is logged in and authorised. Returns <code>true</code> if there are, <code>false</code> if not.';
Docs::add('user_authed', $text);

/*
	user_authed_id
*/
$text = 'Returns the ID of the currently logged-in user.';
Docs::add('user_authed_id', $text);

/*
	user_authed_name
*/
$text = 'Returns the name of the currently logged-in user.';
Docs::add('user_authed_name', $text);

/*
	user_authed_email
*/
$text = 'Returns the email address of the currently logged-in user. Not recommended for display usage.';
Docs::add('user_authed_email', $text);

/*
	user_authed_role
*/
$text = 'Returns the role of the currently logged-in user. Can be <b>administrator</b>, <b>editor</b>, or <b>user</b>.';
Docs::add('user_authed_role', $text);

/*
	user_authed_real_name
*/
$text = 'Returns the real name of the currently logged-in user, as set in the admin panel.';
Docs::add('user_authed_role', $text);


?>
<h2>Theme functions</h2>

<p>At its core, Anchor is HTML and CSS, with sprinkles of all-important PHP, to dynamically retrieve and serve all the data. Don&rsquo;t worry, though, it&rsquo;s pretty painless. Here is a comprehensive list of all the functions available to you and your Anchor theme.</p>

<p><small class="note"><b>Note:</b> these functions may not work as expected in Anchor 0.6 and lower, and may cause errors.</small></p>

<dl>
<?php foreach(Docs::list_all() as $doc): extract($doc); ?>
	<dt>
		<a name="<?php echo $function; ?>"></a>
		<code>
			<?php echo $function; ?><?php if($params): ?>(<?php echo $params; ?>)<?php endif; ?>
		</code>
	</dt>
	<dd><?php echo $text; ?></dd>
	<?php if($sample): ?>
	<dd><?php echo $sample; ?></dd>
	<?php endif; ?>
<?php endforeach; ?>
</dl>