<hgroup role="banner">
    <h1>Documentation</h1>
</hgroup>

<section id="content">
    <?php include_once 'includes/sidebar.php'; ?>
    
    <div class="primary">
        <?php if(!fetch('documentation/' . $url[1] . '.php')) fetch('documentation/start.php'); ?>
    </div>
</section>