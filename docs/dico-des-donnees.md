# Dictionnaire de données

## Post

| Champ | Type | Spécificités | Description |
| - | - | - | - |
| id | INT | PRIMARY KEY, UNSIGNED, NOT NULL, AUTO_INCREMENT | L'identifiant de notre article |
| title | varchar(150) | NOT NULL | Titre de l'article |
| resume | varchar(255) | NOT NULL | Cours passage de l'article |
| content | TEXT | NOT NULL | Contenu complet de l'article |
| author | ENTITY | NOT NULL | Id de l'auteur ayant écris l'article |
| category | ENTITY | NOT NULL | Id de la catégorie dont fait partie l'article |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Date de création de l'article |
| updated_at | TIMESTAMP | NULL | Date de modification de l'article |


## Author

| Champ | Type | Spécificités | Description |
| - | - | - | - |
| id | INT | PRIMARY KEY, UNSIGNED, NOT NULL, AUTO_INCREMENT | L'identifiant de notre auteur |
| name | varchar(50) | NOT NULL | Nom de l'auteur |
| image | varchar(255) | NOT NULL, DEFAULT 'user.jpg' | Nom de l'image de l'auteur |
| email | varchar(100) | NOT NULL | Adresse mail de l'auteur |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Date de création de l'auteur |
| updated_at | TIMESTAMP | NULL | Date de modification de l'auteur |

## Category

| Champ | Type | Spécificités | Description |
| - | - | - | - |
| id | INT | PRIMARY KEY, UNSIGNED, NOT NULL, AUTO_INCREMENT | L'identifiant de notre catégorie |
| name | varchar(50) | NOT NULL | Nom de la catégorie |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Date de création de la catégorie |
| updated_at | TIMESTAMP | NULL | Date de modification de la catégorie |

