# webtcv

WebTCV est un projet inspiré de l'excellent outil TCV (Table à Cartes Virtuelle). L'idée de départ est de faire à peu près la même chose mais en mode web.
Afin malgrès tout de rendre la solution compatible avec l'ensemble des OS et de Navigateurs du marché, le choix a été fait de proposer une interface utilisateur en FLASH (solution de rendu vectoriel de ADOBE) avec appels à des scripts externes en PHP. Les scripts PHP renvoient un résultat vers FLASH en XML qui est parsé nativement.
Côté serveur cette solution nécessite un serveur APACHE avec PHP et les librairies CURL.

# Dans la branche trunk/webtcv :
l'ensemble du client webtcv avec la version flash compilée et les scripts php qui lui permettent de "discuter" avec VLM.

## index.php :
Page de connexion. Les infos postées sont récupérées et soumises au site VLM via CURL afin "d'ouvrir" une session et de récupérer les infos du bateau.

## webtcv.php
page d'appel du client flash avec passage de paramètres

## sous branche xml
GeoCalc.class.php est une classe développée à partir du code C++ de Steven Brendtro

# Dans la branche trunk src_openlaszlo :
le code source du flash développé avec OpenLaslzo. 

C'est une page de login mais je ne stocke pas le mot de passe, uniquement le cookie que me donne VLM et que je récupère en CURL.
Il y a un choix de la version, la version non compilée contient en plus un début d'implémentation de GoogleMaps, la version mobile n'est pas finalisée pour le moment.

Il est possible d'envisager une petite mise en place en béta sur VLM mais il faudrait faire des modifs car il y a pas mal d'urls en dur dans cette version ...
Si les utilisateurs de VLM pouvaient y avoir accès, je suis persuadé que cette interface ne fera pas l'unanimité mais comme c'est une évolution de l'interface web, cela peut etre une base concrète de réflexion et il y aura sans doute de bonnes propositions d'idées ...
