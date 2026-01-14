# TP - POKEDEX

## A réaliser: 
- Stoker les pokemons dans une table de la base de données
    - Doctrine (création d'entité, migrations)
	- Client HTTP https://pokeapi.co/api/v2/pokemon
	- Command Symfony
- Stoker les pokemons d'un pokedex par utilisateur
	- On ne peut pas avoir 2 fois le même pokemon dans un pokedex
	- maximum de 20 pokemons par personne

- On doit pouvoir s'authentifier avec un role ROLE_USER ou ROLE_ADMIN
    - Doctrine (création d'entité, migrations, fixtures)

- Pouvoir créer des pokemons via un formulaire (uniquement par un utilisateur ADMIN)

- Interface WEB
  - Login
  - Listing des pokemons
  - Afficher le pokedex de l'utilisateur connecté
  - Formulaire d'ajout de pokemon (Uniquement pour l'admin)
  - Formulaire d'ajout dans un pokedex (par utilisateur)
  - Affichage de la page de détail d'un pokemon
  		- affichage son experience de base (base_experience) et ses capacités (abilities)
  		- https://pokeapi.co/api/v2/pokemon/kakuna


## Point de départ: 
  - Skeleton symfony
  	- Twig 
  	- Bootstrap https://getbootstrap.com/docs/5.3/examples/

## Pour la BDD 
	pokemon (id, label)
	pokedex (id, user_id, pokemon_id)


### Bonus:
 - Création de services
 - Ajout de log applicatif
 - Ajout de contraintes sur les paramètres d'url
 - Utilisation de php-cs-fixer
 - Usage de DTO (client API, Paramètres d'URL)
 - Usage d'un Makefile
