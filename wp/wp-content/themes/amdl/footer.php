<footer class="footer">
    <div class="footer-infos section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="uppercase">plan du site</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item uppercase">AMDL</li>
                                <li class="list-group-item uppercase">La logistique au Maroc</li>
                                <li class="list-group-item uppercase">Zones logistiques</li>
                                <li class="list-group-item uppercase">Acteurs logistiques</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item uppercase">PME LOGIS</li>
                                <li class="list-group-item uppercase">MLA 2019</li>
                                <li class="list-group-item uppercase">PUBLICATIONS</li>
                                <li class="list-group-item uppercase">ANNONCES</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h2 class="uppercase">contact</h2>
                    <p class="bold uppercase title">Agence Marocaine de Développement
                        de la Logistique (AMDL)</p>
                    <p><span class="bold">Adresse</span> : 11, Rue Al Kayraouane (angle avenue d’Alger),
                        BP 4434 Tour Hassan, 10020, Rabat – Maroc</p>
                    <p><span class="bold">Téléphone</span> : + 212 (0) 5.38.00.92.93/94<br>
                        <span class="bold">Fax</span> : + 212 (0) 5.37.76.16.68</p>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3307.029854112241!2d-6.8293869849347315!3d34.017444627010875!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda76b85a7c5e8a9%3A0xd1dfef1555cb097d!2sAMDL!5e0!3m2!1sen!2sma!4v1555672322684!5m2!1sen!2sma" height="300" style="border:0" allowfullscreen></iframe></div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-menu section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <p class="copy-right">© 2019 - Site Web Officiel de l'AMDL</p>
                </div>
                <div class="col-md-7">
                    <div class="col-md-1"></div>
                    <div class="col-md-11 footer-menu-items">
                        <!-- <ul class="list-group">
                        <li class="list-group-item">Mentions légales</li>
                        <li class="list-group-item">Aide</li>
                        <li class="list-group-item">Politique de confidentialité</li>
                        <li class="list-group-item">Politique de cookies</li>
                        <li class="list-group-item">Termes et conditions</li>
                    </ul> -->
                        <?php
                        wp_nav_menu(array(
                            'theme_location'    => 'footer-menu',
                            'depth'             => 2,
                            'container'         => 'div',
                            'container_class'   => 'footer-menu-items',
                            'container_id'      => '',
                            'menu_class'        => 'list-group',
                            'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                            'walker'            => new WP_Bootstrap_Navwalker(),
                        ));
                        ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mediating">
                        <span class="uppercase">Réalisation </span>
                        <img src="<?php echo get_template_directory_uri(); ?>/img/logos/mediating.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>

</html>