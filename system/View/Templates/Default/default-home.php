<?php include "header.php"; ?>
<div class="main">
    <main class="two_column">
        <section class="logo_left">
            <a href="<?php echo $this->ViewData['rootURL']; ?>">
                <img src="<?php echo $this->ViewData['templateDirectory']; ?>/images/logo.png" style="border: none;" />
            </a>
        </section>

        <section class="fill">
            <nav>
                <?php echo $this->Navigation(); ?>
            </nav>

            <section class="content vcenter">
                <?php echo $this->ShowErrors(); ?>
                <?php echo $this->ViewData['body']; ?>

            </section>
        </section>
    </main>
</div>
<?php include "footer.php"; ?>