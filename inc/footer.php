<footer>

    <div class="footerNav">

        <nav class="navfooterbloc">
            <h2>Contacts</h2>
            <address>
                
            <a class="maillink" href="mailto:info@wetground.be" target="_blank">info@wetground.be</a>

                <a class="phonelink" href="tel:+32488191471">+32(0)488/19.14.71</a>
                <div class="situationlink">rue de la Constitution, 13<br> 1030 Schaerbeek - Belgium</div>
            </address>
        </nav>
        <nav class="navfooterbloc">
            <h2>Menu</h2>
            <?php echo $menuMain_view ?>
        </nav>
    </div>

   <!-- <nav id="menuRS" class="nav-rs">
        <?php/*
        foreach ($menuRS as $item) {
            echo "<a href=" . $item->page . " title='" . $item->titre . "' target='_blank'><div class='rs " . $item->titre . "'></div></a>";
        }*/
        ?>
    </nav>-->
    <img class="footer-logo" src="<?= $repImgDeco ?>logo.svg" alt="">

</footer>