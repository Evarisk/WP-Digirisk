# JavaScript WordPress Framework 1.0.0

## Modal

* Ouverture du modal en AJAX
* Action à la fermeture d'une modal
* Gestion des boutons dans le footer de la modal
* Gestion des actions sur les boutons personnalisé
* Gestion des filtres WordPress

### /core/assets/js/modal.lib.js

Ce fichier écoutes ses différents évènements:

```JS
jQuery( document ).on( 'keyup', window.eoxiaJS.modal.keyup );
jQuery( document ).on( 'click', '.wpeo-modal-event', window.eoxiaJS.modal.open );
jQuery( document ).on( 'click', '.wpeo-modal .modal-container', window.eoxiaJS.modal.stopPropagation );
jQuery( document ).on( 'click', '.wpeo-modal .modal-close', window.eoxiaJS.modal.close );
jQuery( document ).on( 'click', 'body', window.eoxiaJS.modal.close );
```

* keyup: Permet de fermer la modal avec la **touche "Echap"** (par défaut). Cette touche est personnalisable en rajoutant l'attribut **data-close-key** sur le bouton déclencheur.
* click(.wpeo-modal-event): Cet évènement est **l'élément déclencheur** pour ouvrir la modal.
* click(.wpeo-modal .modal-container): Cet évènement **stop la propagation** de l'évènement *clic*. Il fait en sorte que la modal ne se ferme pas quand on clic dessus à l'évènement click(body).
* click(.wpeo-modal .modal-close): Cet évènement permet de **fermer la modal** quand on click sur la croix.

Il est important de comprendre que la **modal** est générée dynamiquement dans le DOM (cf ligne 80) en JS. Une fois la modal **fermée**, celle-ci est supprimé du DOM.

### L'élement déclencheur

```html
<a id="modal-opener"
   class="wpeo-button button-main wpeo-modal-event"
   data-title="Modal #1"
   data-action="test"><i class="button-icon fa fa-hand-pointer-o"></i> <span>Cliquer pour ouvrir la modal #1</span></a>
```

* La classe wpeo-modal-event est obligatoire. Comme on a pu le voir plus haut, l'évènement qui déclenche l'ouverture de la popup écoutes cette classe.
* L'attribut data-title permet de définir le titre de la popup.
* L'attribut data-action permet de définir l'action AJAX WordPress.

### Définir le contenu de la popup

Le contenu de la popup est renvoyé par l'action AJAX.
