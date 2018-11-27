# wpeo-util

L'équipe [Eoxia](https://eoxia.com) utilises WPEO_Util pour tous les plugins suivants: [DigiRisk](https://), [WPShop](https://) et [Task Manager](https://).

WPEO_Util gère le "boot" de tous ses plugins ainsi que leurs modules et externals.

## Fonctionnalités

* Singleton
* Inclusion de module et external
* Gestion des vues
* Gestion JSON/CSV
* Autres

## Pourquoi ?



# Pour commencer

Nous utilisons la notion de **module** pour séparer les différentes fonctionnalités de nos plugins.
Nous avons également comme principe de séparer nos fonctions de nos fichiers selon leurs thèmes:
* Les actions se trouverons dans le dossier 'action'
* Les classes se trouverons dans le dossier 'class'
* Les vues se trouverons dans le dossier 'view'
* Ainsi de suite...

## Modules

Les modules représentent une fonctionnalité dans un plugin.

Les modules sont des bouts de code qui permette d'effecuter une fonctionnalité précise dans vos plugins.

## Singleton

Singleton_Util

## Modules

Les modules représentent une fonctionnalité dans un plugin.

## *.config.json

Les configurations des modules/externals se trouvent dans le fichier .json. Un module ne peut pas boot sans ce fichier.

Les bases de ce fichier JSON sont:

```json
{
  "slug": "mon-module",
  "path": "modules/mon-module"
}
```

**slug** et **path** sont des paramètres obligatoires. Sans ceci WPEO_Util ne bootera pas votre module.

## Externals

Les externals sont comme ce projet, il sont développé comme des modules, seulement ils sont là pour ajouter des fonctionnalités externes à vos plugins.

## Gestion des vues

View_Util

## Gestion JSON/CSV

JSON_Util, CSV_Util

# Docs WPEO Util 1.x.x

## Créer un plugin WordPress avec WPEO_Util

## Créer un module pour un plugin WordPress

## Application exemple

# TODO

* Explication
* Exemple
* Documentation
