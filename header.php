<?php
if(!file_exists('constant.php')) {
    //
    require_once('Functions.class.php');
    require_once('Install.class.php');
    require_once('i18n.php');
    global $i18n;
    $install = new Install();

    /*   initialisation des langues ( nécéssaire pour installation )   (extrait de feu install.php)  */
    $lang = 'en';
    $installDirectory = dirname(__FILE__).'/install';
    
    // N'affiche que les langues du navigateur
    // @TODO: il faut afficher toutes les langues disponibles
    //        avec le choix par défaut de la langue préférée
    $languageList = Translation::getHttpAcceptLanguages();
    if (!empty($lang)) {
        // L'utilisateur a choisi une langue, qu'on incorpore dans la liste
        array_unshift($languageList, $lang);
        $liste = array_unique($languageList);
    }
    unset($i18n); //@TODO: gérer un singleton et le choix de langue / liste de langue
    $currentLanguage = i18n_init($languageList, $installDirectory);
    
    $languageList = array_unique($i18n->languages);


    /*   définition de la configuration à partir des varibales d'environnement  */
    $_DATA = array(
        'install_changeLngLeed' => $_ENV["LEED_LANG"],
        'root' => $install->getDefaultRoot(),
        'mysqlHost' =>$_ENV["MYSQL_HOSTNAME"],
        'mysqlLogin' => $_ENV["MYSQL_USER"],
        'mysqlMdp' => $_ENV["MYSQL_PASSWORD"],
        'mysqlBase' => $_ENV["MYSQL_DATABASE"],
        'mysqlPrefix' => 'leed_',
        'login' => $_ENV["LEED_LOGIN"],
        'password' => $_ENV["LEED_PW"],
        'installButton' => 'install',
    );

    $_POST = array_merge($_POST,$_DATA);  // fusion avec la variable POST car utilisé à travers celle-ci pour certaines variables comme 'root' 

    $installActionName = 'installButton';
    $install->launch($_DATA, $installActionName);

    header('location: '); //renvoie sur la landing page
    exit();
}
require_once('common.php');

?>
