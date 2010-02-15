<?php
//  ------------------------------------------------------------------------ //
//                      XOOPSCARE - MODULE FOR XOOPS 2                		 //
//                  Copyright (c) 2007, 2008 Instant Zero                    //
//                     <http://www.instant-zero.com/>                        //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

$help = <<<endhelp
<a href="http://xoops.instant-zero.com" target="_blank">XoopsCare</a> est un module dont le but est de vous aider � maintenir votre site web facilement et <b>automatiquement</b>
Bien que nous ayons apport� tous nos soins � ce module, <b>utilisez-le � vos risques et p�rils !</b>

Avec le module vous pouvez :
1/ Maintenir votre base de donn�es
2/ Ex�cuter vos propres requ�tes SQL
3/ Ex�cuter du code Php
4/ Nettoyer les r�pertoire templates_c et cache
5/ Supprimer les commentaires contenant du SPAM
6/ Nettoyer les sessions

Pour chacune de ces actions, vous pouvez d�finir s'il faut le faire ou pas et quand le faire (vous pouvez le programmer)

En outre, vous pouvez enregistrer les actions r�alis�es par le module et (si vous en disposez) et utiliser des CRON pour
maintenir votre site.

Si vous avez la possibilit� d'appeler le module par un CRON, alors il vous suffit d'appeler le script <i>cron.php</i> pr�sent
� la racine du module et de lui passer un mot de passe que vous avez rentr� dans l'administration du module.
	Faites le comme ceci : http://www.example.com/modules/xoopscare/cron.php?password=mypassword
<b>Si vous utilisez un CRON mais que vous n'avez pas rentr� de mot de passe, le module ne fera rien</b>, ceci dans le but
de prot�ger votre site d'une utilisation abusive par d'autres personnes.

Si vous n'avez pas la possibilit� d'utiliser un CRON, vous pouvez activer le bloc du module quelque part sur votre site
(o� vous voulez) et le module ex�cutera ses taches automatiquement et lorsque c'est n�cessaire.
Astuce : Vous pouvez utiliser du cache sur le bloc.

La premi�re chose � faire est de se rendre dans l'administration du module et de r�gler les pr�f�fences.

Dans la premi�re partie, <b>Pr�f�rences g�n�rales</b>, entrez le mot de passe pour le CRON si vous utilisez un CRON.
Si vous souhaitez cr�er un fichier log, alors remplissez la zone intitul�e <i>Fichier Log</i>.
Note, il est recommand�, pour des raisons de s�curit�, de donner une extension <u>.php</u> � ce fichier.

Dans la partie intitul�e <b>Maintenance de la base de donn�es</b>, entrez un d�lai en jours pour maintenir votre base de donn�es.
Si vous r�glez ce d�lai � 0 alors le module ne fera rien.
Le processus de cette action consiste � v�rifier, r�parer, analyser et optimiser toutes les tables utilis�es par votre site Xoops.

Dans la partie intitul�e <b>Requ�tes</b>, rentrez tout d'abord un d�lai puis (mais uniquement si vous souhaitez vous en servir),
entrez quelques requ�tes SQL � ex�cuter.
Note, le module n'applique aucune modification � vos requ�tes, il les prend une par une et les ex�cute.

Vous pouvez faire la m�me chose que dans le point pr�c�dent mais pour lancer du code Php dans la partie intitul�e <b>Code Php</b>

La partie qui s'appelle <b>Cache et Templates_c</b> vous donne la possibilit� de nettoyer les r�pertoires cache et templates_c
(pr�sents � la racine de votre site).

La partie <b>Sessions</b> vous offre la possibilit� de nettoyer votre table des sessions � un certain d�lai.


Finalement, avec la partie intitul�e <b>Commentaires spam�s</b>, vous pouvez supprimer tous les spam de votre site.
Cette fonctionnalit� du module marche conjointement avec la partie <i>Options des mots � censurer</i> de Xoops.
Premi�rement, depuis les pr�f�rences de votre site, vous devez activer la censure des mots ind�sirables, entrer les mots
� censurer et choisir un mot qui les remplacera.
Par d�faut, les mots censur�s sont remplac� par #OOPS#.
Le module XoopsCare cherchera les commentaires qui contienent ce mot de remplacement dans le titre et/ou le contenu des
commentaires et appliquera vos pr�f�rences � ces commentaires.
En plus, le module peut extraire les adresses IP des spammeurs et ajouter leur adresse IP automatiquement � la liste
de vos adresses IP � banir.
Finalement, vous pouvez choisir l'action � mettre en oeuvre sur les commentaires spamm�s, les conserver, ne pas les
publier, les cacher ou les supprimer.


Si vous utilisez un CRON pour nettoyer votre site, alors le d�lai entr� pour chaque action n'est pas utilis� mais doit
�tre sup�rieur � 0.


<a href="http://www.instant-zero.com" target="_blank">Faites nous savoir si vous aimez le module</a>

endhelp;
?>
