<?php include "header.php"; ?>
<div class="main">
    <main class="one_column">
        <section class="logo_top">
            <a href="<?php echo $this->ViewData['rootURL']; ?>">
                <img src="<?php echo $this->ViewData['templateDirectory']; ?>/images/logo.png" style="border: none;" />
            </a>
            <nav>
                <?php echo $this->Navigation(); ?>
            </nav>
        </section>

        <section class="fill">

            <section class="content vcenter">
                <?php echo $this->ShowErrors(); ?>
                <?php echo $this->ViewData['body']; ?>

            </section>
        </section>
    </main>
</div>
<?php include "footer.php"; ?>