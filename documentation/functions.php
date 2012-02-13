<h2>Theme functions</h2>
<p>At its core, Anchor is HTML and CSS, with sprinkles of all-important PHP, to dynamically retrieve and serve all the data. Don&rsquo;t worry, though, it&rsquo;s pretty painless. Here is a comprehensive list of all the functions available to you and your Anchor theme.</p>

<small class="note"><b>Note:</b> these functions may not work as expected in Anchor 0.5 and lower, and may cause errors.</small></p>

<dl>

    <?php 
    $docs = array(
        'has_posts()' => 'Checks if there are any published posts. Returns <code>true</code> if there are, <code>false</code> if not. Should be used in conjunction with <code><a href="#posts">posts()</a></code> like this:
        
        ' . hyperlight('<?php if(has_posts()): ?> <!-- We have posts, it\'s safe to loop. -->
    <?php while(posts()): ?>
    <!-- We can use article functions now: <?php echo article_title(); ?> -->
    <?php endwhile; ?>
<?php endif; ?>'),
        
        'posts()' => 'Counts through every visible post, one, by one. Returns <code>true</code> when there is more posts to be listed or <code>false</code> when we are at the end. Should be used like this:' . hyperlight('<?php while(posts()): ?>
    <!-- Loop through the posts. -->
<?php endwhile; ?>'),
        
        'article_id()' => 'Returns the database-assigned ID of the current article, as a number. Used for uniquely identifying a post.',
        'article_title()' => 'Returns the title of the current article as a string, as set in the admin area.',
        'article_slug()' => 'Returns the slug of the current article. Should not be used in <code>posts.php</code> (you should use <code><a href="#article_url">article_url()</a></code> instead, which will correctly calculate the URL).',
        
        'article_url()' => 'Returns a fully-built URL string, which serves as a permalink. Should be used like so:' . hyperlight('<a href="<?php echo article_url(); ?>">
    <?php echo article_title(); ?>
</a>'),
        'article_description()' => 'Returns a short description, as set in the "description" field of the admin area.',
        'article_time()' => 'Returns a <a href="http://php.net/manual/en/function.time.php">UNIX timestamp</a> from when the post was added, which can be used to add custom timestamps. If you want to use the default timestamp, use <code><a href="#article_date">article_date()</a></code> instead.',
        'article_date()' => 'Returns a date-formatted version of <code><a href="#article_time">article_time()</a></code>. Default format is jS M, Y (24th January, 2012).',
        
        'article_html()' => 'Returns the content of the blog post, as a HTML string.',
        'article_css()' => 'If custom CSS was added, returns the custom CSS. Should be used like this: ' . hyperlight('<?php if(article_css()): ?>
            <style><?php echo article_css(); ?></style>
        <?php endif; ?>'),
        'article_js()' => 'Similar to <code>article_css()</code>, but with Javascript. Should be used like this: ' . hyperlight('<?php if(article_js()): ?>
            <script><?php echo article_js(); ?></script>
        <?php endif; ?>'),
        
        'article_status()' => 'Returns a string which contains the current status of the article. Can be either <b>draft</b>, <b>archived</b>, <b>published</b>.',
        'article_author()' => 'Returns the name of the post author as a string.',
        'article_author_bio()' => 'Returns the biography of the current post author.',
        'article_custom_fields()' => 'Checks whether an article has any custom fields attached to it. Returns <code>true</code> if there are custom fields, <code>false</code> if not.',
        'article_custom_field($key, $fallback = \'\')' => 'Retrieves a custom field with the key <code>$key</code>, with an optional fallback parameter (<code>$fallback</code>). Used like so: ' . hyperlight('<small class="attribution">
    Thanks to <?php echo article_custom_field(\'attribution\', \'Mike\'); ?>
</small>'),
        'customised()' => 'Returns <code>true</code> if an article has custom CSS or Javascript attached to it, <code>false</code> if not.',
        'include_comments()' => 'Includes the optional comment_form.php include (if it exists). If not, will include the ',
        'has_comments()' => 'Checks if there are comments attached to the post. Returns <code>true</code> if there are, <code>false</code> if not.',
        'total_comments()' => 'Returns an integer depicting the number of published comments.',
        'comments()' => 'A loop, similar to <code><a href="#posts">posts()</a></code>, which returns <code>true</code> if there are any subsequent comments, <code>false</code> if not. Should be used as such:' . hyperlight('<?php if(comments_open() and has_comments()): ?>
    <?php while(comments()): ?>
    <!-- We\'ve got comments, let\'s go. -->
    <?php endwhile; ?>
<?php endif; ?>'),
        'comment_id()' => 'Returns the ID of the current comment as an integer.',
        'comment_time()' => 'Returns a <a href="http://php.net/manual/en/function.time.php">UNIX timestamp</a> from when the post was added, which can be used to add custom timestamps. If you want to use the default timestamp, use <code><a href="#comment_date">comment_date()</a></code> instead.',
        'comment_date()' => 'Returns a date-formatted version of <code><a href="#comment_time">comment_time()</a></code>. Default format is jS M, Y (24th January, 2012).',
        'comment_name()' => 'Returns the name of the commenter as a string.',
        'comments_text()' => 'Returns the text body of the comment as a string.',
        'comments_open()' => 'Checks if comments are allowed. Returns <code>true</code> if there are, <code>false</code> if not.',
        'comment_form_notifications()' => 'Returns messages (if any) based on the input of a comment form. It is highly recommended you use this function within your comment form. Used like so: ' . hyperlight('<!-- Got error messages? If so, echo. -->
<?php echo comment_form_notifications(); ?>'),
        'comment_form_input_name($extra = \'\')' => 'Returns the HTML source of the name input, plus an optional parameter of <code>$extra</code>, which adds extra attributes. Used like so: ' . hyperlight('<?php
    echo comment_form_input_name(\'class="input red" placeholder="Your Name"\');
?>'),
        'comment_form_input_email($extra = \'\')' => 'Returns the HTML source of the email input, plus an optional parameter of <code>$extra</code>, which adds extra attributes. Used in the same manner as <code><a href="#comment_form_input_name">comment_form_input_name()</a></code>',
        'comment_form_input_text($extra = \'\')' => 'Returns the HTML source of the email textarea, plus an optional parameter of <code>$extra</code>, which adds extra attributes. Used in the same manner as <code><a href="#comment_form_input_name">comment_form_input_name()</a></code>',
        'comment_form_button($text = \'Post Comment\', $extra = \'\')' => 'Returns the HTML source of the submit button on the comment form, with two optional parameters of <code>$text</code>, which fills the button with custom text <code>$extra</code>, which adds extra attributes. Used in the same manner as <code><a href="#comment_form_input_name">comment_form_input_name()</a></code>',
        
        'base_url()' => 'Returns the relative path to the current Anchor install. If the install is at <code>http://my.site.org/anchor/</code>, it will return <code>/anchor/</code>.',
        'theme_url($append = \'\')' => 'Returns the full relative path to the theme, plus any extra paths appended with <code>$append</code>.',
        'current_url()' => 'Returns the current page URL. Similar to <code>$_SERVER[\'REQUEST_URI\'];</code>.',
        'admin_url($append = \'\')' => 'Returns the full relative path to the admin area, plus any extra paths appended with <code>$append</code>.',
        'search_url()' => 'Returns the full relative path to the search area.',
        'rss_url()' => 'Returns the full relative path to the search area.',
        
        'bind($page, $function)' => 'Bind a function to a page slug (<code>$page</code>). The <code>$page</code> parameter can either be a slug on its own ("about"), or a slug suffixed with an \'area name\' ("about.area"); that is, if there are multiple bind/recieve calls, this will avoid duplicate function calls. Used in conjunction with <code>recieve()</code> like such: ' . hyperlight('<?php bind(\'about\', function() {
    return \'This function only gets run on the about page!\'
}); ?>'),
        'recieve($name = \'\')' => 'When used in page.php, recieves any bind calls. The one parameter is <code>$name</code>, which is the same as <code>$page</code>. Used as such (see the <a href="#bind">previous example</a> for the <code>bind()</code> version): ' . hyperlight('<?php recieve(\'about\'); ?>'),
        'has_menu_items()' => 'Checks if there are any menu items (suprisingly). Returns <code>true</code> if there are, <code>false</code> if not.',
        'menu_items()' => 'Counts through every visible menu item, one, by one. Returns <code>true</code> when there is more posts to be listed or <code>false</code> when we are at the end. Should be used like this:' . hyperlight('<?php while(menu_items()): ?>
    <!-- Loop through the menu items. -->
<?php endwhile; ?>'),
        'menu_id()' => 'Returns the current menu item\'s ID',
        'menu_url()' => 'Returns the current menu item\'s URL',
        'menu_name()' => 'Returns the current menu item\'s name. This should be used instead of <code>menu_title()</code> to display.',
        'menu_title()' => 'Returns the current menu item\'s title. This should be used instead of <code>menu_title()</code> as a <code>title=""</code> attribute.',
        'menu_active()' => 'Checks if the menu item is active. Returns <code>true</code> if there are, <code>false</code> if not.',
        
        'site_name()' => 'Returns the name of the Anchor site, as set in the metadata area of the admin panel.',
        'site_description()' => 'Returns the description of the Anchor site, as set in the metadata area of the admin panel.',
        'twitter_account()' => 'Returns the name of the Twitter account, as set in the metadata area of the admin panel.',
        'twitter_url()' => 'Returns the full URL path of the Twitter account, based on <code>twitter_account()</code>.',
        
        'page_id()' => 'Returns the current page\'s ID.',
        'page_url()' => 'Returns the current page\'s relative URL.',
        'page_name()' => 'Returns the current page\'s name. Should not be used to display; instead, use <code>page_title()</code>.',
        'page_title($fallback = \'\')' => 'Returns the current page title, with a fallback (<code>$fallback</code>), in the event of a missing page error.',
        'page_content()' => 'Returns the content of the current page, as a HTML string.',
        'page_active()' => 'Checks if the current page is active. Returns <code>true</code> if there are, <code>false</code> if not.',
        'page_status()' => 'Returns a string which contains the status of the current page. Can be either <b>draft</b>, <b>archived</b>, <b>published</b>.',

        'has_search_results()' => 'Checks if there are any search results. Returns <code>true</code> if there are, <code>false</code> if not.',
        'total_search_results()' => 'Returns an integer depicting the number of search results.',
        'search_results()' => 'Counts through every search result, one, by one. Returns <code>true</code> when there is more posts to be listed or <code>false</code> when we are at the end. Should be used like this:' . hyperlight('<?php while(search_results()): ?>
    <!-- Loop through the search results. -->
<?php endwhile; ?>'),
        'search_term()' => 'Returns a safely-encoded version of the user\'s current search term.',
        
        'user_authed()' => 'Checks if the user is logged in and authorised. Returns <code>true</code> if there are, <code>false</code> if not.',
        'user_authed_id()' => 'Returns the ID of the currently logged-in user.',
        'user_authed_name()' => 'Returns the name of the currently logged-in user.',
        'user_authed_email()' => 'Returns the email address of the currently logged-in user. Not recommended for display usage.',
        'user_authed_role()' => 'Returns the role of the currently logged-in user. Can be <b>administrator</b>, <b>editor</b>, or <b>user</b>.',
        'user_authed_real_name()' => 'Returns the real name of the currently logged-in user, as set in the admin panel.',
    );
    
    
    foreach($docs as $id => $content): ?>
    
    <dt id="<?php echo preg_replace('/\([^>]*\)/', '', $id); ?>"><code><?php echo $id; ?></code></dt>
        <dd><?php echo $content; ?></dd>
    <?php endforeach; ?>
</dl>