<?php View::make('layout/header'); ?>

<hgroup role="banner">
	<h1>Documentation</h1>
</hgroup>

<section id="content">

	<?php View::make('docs/menu'); ?>
	
	<div class="primary">
		<h2>So, you want to use Anchor.</h2>
		<p>Great! It&rsquo;s a simple, quick process to get Anchor installed on a server. Firstly, though, you should read <a href="/docs/requirements">the requirements</a> to make sure you are able to install.</p>

		<p>I&rsquo;ll just wait here while you go do that.</p>

		<h3>I&rsquo;m good to go.</h3>
		<p>That&rsquo;s good news; I&rsquo;ve been getting a bit bored here. Right, then. Let&rsquo;s go!</p>

		<h3>Uploading</h3>
		<ol>
		    <li>Grab the <a href="/download">latest copy of Anchor</a>, and put it on your Desktop or something.</li>
		    <li>Open your <a href="http://filezilla-project.org/">FTP client</a>, and create the folder you want to install Anchor in (if it already exists, just open the folder).</li>
		    <li>Drag the files from your desktop into the folder you just selected.</li>
		    <li>Rename the <code>htaccess.txt</code> file to <code>.htaccess</code> for clean URLs.</li>
		    <li>If you&rsquo;re installing on a subdirectory, change the line from <code># RewriteBase /</code> to <code>RewriteBase /path/to/anchor</code> (where the path is the path to Anchor, of course).</li>
		</ol>

		<h3>That&rsquo;s done. Now what?</h3>
		<p>This one&rsquo;s a doddle. Simply navigate your way to the folder you just uploaded (in your web browser; if you uploaded it to <code>/public_html/anchor</code>, it&rsquo;ll probably be at <code>yoursite.com/anchor</code>, for example), and click "Run the install". Then, follow the steps.</p>
		<small>Making sure you know the MySQL details beforehand always helps, and is required by the installer. If you don&rsquo;t know them, please speak to your webhost.</small>
	</div>
</section>

<?php View::make('layout/footer'); ?>