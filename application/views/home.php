<?php View::make('layout/header'); ?>

<hgroup role="banner">
	<h1>Make blogging beautiful.</h1>
	<h2>Anchor is a content management system, written in PHP5, built for art-directed posts. <a href="/download" title="Grab the latest version of Anchor (155kb, version 0.5a)">Get it now &raquo;</a></h2>
</hgroup>

<section id="content">
	<ul class="features">
		<li>
			<img src="/assets/img/extensible.gif" alt="Anchor is crazy easy to modify.">
			<h1>Extensible.</h1>
			<p>Every website is unique, and Anchor knows that. That’s why there’s a powerful, yet simple theming engine behind Anchor, just waiting to give your posts that unique touch.</p>
		</li>
		
		<li>
			<img src="/assets/img/open-source.gif" alt="Anchor&rsquo;s source code is completely available for anyone.">
			<h1>Open&ndash;source.</h1>
			<p>Since the beginning, Anchor has been written and maintained by an amazing <a href="//github.com/anchorcms/anchor-cms">community</a> of web designers and developers, all working to produce a great product, for free.</p>
		</li>

		<li>
			<img src="/assets/img/simple.gif" alt="Anchor was written for your grandma to use.">
			<h1>Simple.</h1>
			<p>Want to write a blog post? Anchor won’t get in your way. With its simple, uncluttered admin interface, you can be writing blog posts with no distractions. Just like you wanted.</p>
		</li>
	</ul>
</section>

<?php View::make('layout/footer'); ?>