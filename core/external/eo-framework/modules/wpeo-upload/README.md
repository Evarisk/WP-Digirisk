# wpeo-upload

Script complet PHP ainsi que CSS/JS pour gérer les medias et la galerie d'un élement "POST (CPT) de WordPress dans vos développement de plugin, WPEO_Upload est inclus dans [EO-Framework](https://github.com/Eoxia/eo-framework).

# Docs WPEO Upload 1.0.x

Gestion de l'upload de ressource dans WordPress en utilisant wp.media.

WPEO Upload est dépendant de:
* [EO-Framework](https://github.com/Eoxia/eo-framework) >= 1.x.x

## Fonctionnalités

* Shortcode
* Upload de fichier dans tous les POST (CPT) de WordPress
* Upload de plusieurs fichiers dans les POST (CPT) de WordPress
* Galerie de navigation avec différentes actions:
  * Changer l'image en vignette (\_thubmnail_id)
  * Uploader une ressource (image, audio, application...)
  * Dissocier une ressource (image, audio, application...)
* Gestion des mimes types.

# Shortcode

Le shortcode __[wpeo_upload]__ permet d'utiliser WPEO Upload directement dans vos templates.

Les différents paramètres:
* __id__ (integer)          : Le post ID. *defaut: 0*
* __title__ (string)        : Le titre de la galerie (popup). *default: "Téléverser un média".
* __mode__ (string)         : Mode édition, ou vue. *default: "edit". Peut être "edit" ou "view".
* __field_name__ (string)   : Le champ ou vas être enregistrer les ID des ressources. *defaut: thumbnail_id*
* __model_name__ (string)   : Obligatoire pour **WPEO_Model**. *defaut: \\eoxia\\Post_Class*
* __custom_class__ (string) : Utiles si vous devez utiliser plusieurs fois le bouton dans un même template pour le même POST. *defaut: empty*
* __size__ (string)         :  Comme les tailles de WordPress: thumbnail, medium, full. *defaut: thumbnail*
* __single__ (string)       :  Si vous voulez pouvoir uploader plusieurs ressources pour cet élément ou pas. *défaut: true*
* __mime_type__ (string)    :  Permet de définir le mime_type des fichiers à upload et de filtrer la vue de wp.media. *defaut: image*. Peut être "application", "image", "audio", ...

## En savoir plus sur WPEO_Model

**WPEO_Model** est inclus dans [EO-Framework](https://github.com/Eoxia/eo-framework). Voir la doc   [WPEO_Model](https://github.com/Eoxia/eo-framework/edit/master/modules/wpeo-model), ce n'est pas obligatoire pour utiliser WPEO_Upload.

## Exemple d'utilisation

### Association d'une seule image dans le champ 'thumbnail_id' pour le *POST* 1.

__[wpeo_upload id=1]__

### Association de plusieurs image dans le champ associated_document['images'] pour le *POST* 1

__[wpeo_upload id=1 single="false" field_name="images"]__

### Association d'une seule image dans le champ 'thumbnail_id' pour le *POST* 1 en utilisant l'objet *Model_Class* dans le namespace *namespace*.

_Attention_: le double backslashes n'est pas une erreur. C'est obligatoire pour faire passer le paramètre au shortcode. La méthode PHP s'occupe de remplacer le double blaskslashes par un slashes, dans notre cas: \\namespace\\Model_Class devient /namespace/Model_Class.

__[wpeo_upload id=1 model_name="\\\namespace\\\Model_Class"]__

# Le paramètre boolean "single"

Single permet de définir si l'élément peut contenir plusieurs ressources ou au contraire, uniquement une seule.

## SI true

Le POST ne peut contenir qu'une __seule__ ressource qui sera enregistrée dans __thumbnail_id__.

## SI false

Le POST peut contenir __plusieurs__ dans une meta qui sera défini par __field_name__. Attention, le champ par défaut __thumbnail_id__ de WordPress ne permet pas d'enregister un tableau d'ID.
Pour utiliser le paramètre __single__ à __false__, il faut obligatoirement définir le paramètre __field_name__.

# Peut-on avoir plusieurs ressources dans un seul élement ?
Oui. Il est important de comprendre que si __single__ est à __false__ vous pouvez enregistrer plusieurs ressources sur l'élément. Seulement vous ne pouvez pas définir __plusieurs__ shortcodes pour un élement.

# La galerie

La galerie s'ouvre après avoir effectuer un deuxième clic sur le bouton "upload" après avoir envoyé une ressource.

Si votre mime_type est de type "image", vous aurez un aperçu de vos images dans la galerie.
Sinon, pour tout autre mime_type, l'aperçu ne sera pas disponible.

# Le bouton "upload" généré par le shortcode

[image_du_bouton_a_faire]

Description à faire

# Utiliser WPEO_Upload sans shortcode

Toutes les fonctions qui suivent se trouve dans l'objet __wpeo-upload.class.php__ dans le dossier *class*

Le paramètre **$model_name** est expliqué dans la documentation de [WPEO_Model](https://github.com/Eoxia/wpeo_model/).

## Associer une ressource au thumbnail pour un element

WPEO_Upload_Class::g()->set_thumbnail( $data );

Le tableau $data doit contenir:

* integer $id L'ID de l'élement ou la ressource sera associé. (Ne peut pas être vide)
* integer $file_id L'ID de la ressource.
* string $model_name Le modèle à utiliser.

## Associer une ressource au tableau associated_document['image']

WPEO_Upload_Class::g()->associate_file( $data );

Le tableau $data doit contenir:

* integer $id L'ID de l'élement ou la ressource sera associé. (Ne peut être vide)
* integer $file_id L'ID de la ressource. (Ne peut être vide)
* string **$model_name** Le modèle à utiliser. [WPEO_Model](https://github.com/Eoxia/wpeo_model/).
* string **$field_name** Le nom du champ de la meta ou sera enregistré les ressources. Ce champ doit être défini dans la définition de votre modèle. Voir [WPEO_Model](https://github.com/Eoxia/wpeo_model/).

## Dissocier une ressource au tableau associated_document['image']

WPEO_Upload_Class::g()->dissociate_file( $data );

Le tableau $data doit contenir:

* integer $id L'ID de l'élement ou la ressource sera dissocié. (Ne peut être vide)
* integer $file_id L'ID de la ressource. (Ne peut être vide)
* string **$model_name** Le modèle à utiliser. [WPEO_Model](https://github.com/Eoxia/wpeo_model/).
* string **$field_name** Le nom du champ de la meta ou sera enregistré les ressources. Ce champ doit être défini dans la définition de votre modèle. Voir [WPEO_Model](https://github.com/Eoxia/wpeo_model/).

## Récupéres le template de la galerie pour un élement

WPEO_Upload_Class::g()->display_gallery( $data );

Le tableau $data doit contenir:

* integer $id L'ID de l'élement ou la ressource sera dissocié. (Ne peut être vide)
* string **$model_name** Le modèle à utiliser. [WPEO_Model](https://github.com/Eoxia/wpeo_model/).
* string **$field_name** Le nom du champ de la meta ou sera enregistré les ressources. Ce champ doit être défini dans la définition de votre modèle. Voir [WPEO_Model](https://github.com/Eoxia/wpeo_model/).
* string $size La taille de la ressource affichée. Peut être thumbnail, medium ou full. Par défaut thumbnail.
* boolean $single Voir le point de cette documentation # Le paramètre boolean "single". Par défaut false.
* string $mime_type Permet de définir le mime_type des fichiers à upload et de filtrer la vue de wp.media. *defaut: empty*

# TODO

* WPEO_Upload 2.0.0: Utilise wp.media pour utiliser pleinement toutes les fonctionnalitées de WordPress. Pas de date définie pour cette tâche.
* Faire le point: Le bouton "upload" généré par le shortcode
