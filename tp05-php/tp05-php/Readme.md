
## Activité 1 : Comprendre une base de données relationnelle

**1. Que représente une ligne de cette table ?**
Une ligne représente un étudiant (un enregistrement) avec toutes ses informations.

**2. Que représente une colonne ?**
Une colonne représente une information (un champ) que l'on stocke pour chaque étudiant, par exemple le nom, l'âge ou la moyenne.

**3. Pourquoi chaque étudiant possède-t-il un identifiant ?**
Pour l'identifier de façon unique. Deux étudiants peuvent avoir le même nom ou le même âge, mais jamais le même identifiant.

**4. Pourquoi une base de données peut-elle être plus pratique pour rechercher et modifier des données ?**
Parce qu'on peut chercher avec des critères (`WHERE`), trier (`ORDER BY`), modifier une seule ligne sans toucher aux autres, et plusieurs utilisateurs peuvent l'utiliser en même temps.

---

## Activité 2 : Créer la base et la table avec SQL

**1. Pourquoi `id` est-il une clé primaire ?**
Pour identifier chaque ligne de façon unique. Une clé primaire ne peut pas être vide ni en double.

**2. Pourquoi `nom` est-il déclaré `NOT NULL` ?**
Parce que le nom est obligatoire : on ne veut pas d'étudiant sans nom.

**3. Que signifie `AUTO_INCREMENT` ?**
MySQL génère automatiquement l'identifiant : 1, puis 2, puis 3, etc. On n'a pas besoin de le saisir.

**4. Pourquoi la moyenne n'est-elle pas stockée dans une colonne de type texte ?**
Avec un nombre (`DECIMAL`), on peut faire des calculs (`AVG`, `MAX`), des comparaisons (`moyenne >= 10`) et un tri correct. Avec du texte, le tri serait faux (par exemple `"10"` viendrait avant `"2"`).

**5. Que se passe-t-il si l'on tente d'insérer `NULL` dans une colonne obligatoire ?**
MySQL refuse l'insertion et renvoie une erreur (*Integrity constraint violation : Column cannot be null*).

---

## Activité 3 : Insérer des étudiants avec INSERT

**Travail demandé (requêtes) :**

```sql
-- 1. Insérer un quatrième étudiant
INSERT INTO etudiants (nom, prenom, age, formation, moyenne)
VALUES ('Trabelsi', 'Sara', 21, 'Informatique', 15.50);

-- 2. Afficher uniquement les noms et prénoms
SELECT nom, prenom FROM etudiants;

-- 3. Moyenne supérieure ou égale à 10
SELECT * FROM etudiants WHERE moyenne >= 10;

-- 4. Trier par moyenne décroissante
SELECT * FROM etudiants ORDER BY moyenne DESC;
```

**1. Quel est le rôle de `INSERT INTO` ?**
Ajouter une nouvelle ligne (un nouvel enregistrement) dans une table.

**2. Quel est le rôle de `SELECT` ?**
Lire et afficher des données de la table.

**3. À quoi sert la clause `WHERE` ?**
Elle filtre les lignes : on garde seulement celles qui respectent une condition.

**4. À quoi sert `ORDER BY` ?**
Trier les résultats selon une ou plusieurs colonnes (`ASC` croissant, `DESC` décroissant).

**5. Quelle différence existe entre `SELECT *` et la sélection de colonnes précises ?**
`SELECT *` récupère toutes les colonnes. Choisir des colonnes précises est plus clair, plus léger et récupère seulement ce dont on a besoin.

---

## Activité 4 : Modifier et supprimer avec SQL

**Travail demandé (requêtes) :**

```sql
UPDATE etudiants SET formation = 'Réseaux' WHERE id = 1;
UPDATE etudiants SET moyenne = 12.75 WHERE id = 1;
DELETE FROM etudiants WHERE id = 4;
SELECT * FROM etudiants;   -- vérification après chaque opération
```

**1. Quel est le rôle de `UPDATE` ?**
Modifier les valeurs d'une ou plusieurs lignes existantes.

**2. Quel est le rôle de `DELETE` ?**
Supprimer une ou plusieurs lignes d'une table.

**3. Pourquoi faut-il vérifier attentivement la clause `WHERE` ?**
Sans `WHERE` (ou avec une mauvaise condition), `UPDATE` ou `DELETE` s'applique à **toutes** les lignes, et on peut perdre ou abîmer toutes les données.

**4. Pourquoi vaut-il mieux utiliser un identifiant plutôt qu'un nom pour modifier un étudiant ?**
L'identifiant est unique, donc on modifie exactement la bonne ligne. Un nom peut exister plusieurs fois (homonymes) et on risque de modifier plusieurs étudiants.

---

## Activité 5 : Créer la connexion PDO

**1. Quel est le rôle de `new PDO(...)` ?**
Créer la connexion entre PHP et la base de données avec le DSN, l'utilisateur et le mot de passe.

**2. À quoi sert `require_once` ?**
À inclure un fichier (ici `connexion.php`) une seule fois, même si on l'appelle plusieurs fois. Si le fichier est introuvable, le script s'arrête.

**3. Pourquoi utilise-t-on `__DIR__` pour construire le chemin du fichier ?**
`__DIR__` donne le dossier du fichier actuel. Le chemin reste correct quel que soit l'endroit d'où le script est lancé.

**4. Pourquoi ne doit-on pas afficher les détails techniques d'une erreur de connexion aux utilisateurs ?**
Ces détails (nom de la base, utilisateur, chemins, structure) peuvent aider un pirate. L'utilisateur voit seulement un message simple.

**5. Pourquoi les identifiants de connexion doivent-ils rester confidentiels ?**
Avec eux, quelqu'un peut accéder à la base, lire, modifier ou supprimer toutes les données. C'est pourquoi on ne les publie pas dans un dépôt public.

---

## Activité 6 : Lire les étudiants depuis PHP

**1. Quel est le rôle de `$pdo->query()` ?**
Exécuter une requête SQL simple (sans paramètres) et retourner le résultat.

**2. Que retourne `fetchAll()` ?**
Un tableau contenant toutes les lignes du résultat. Chaque ligne est un tableau associatif (clé = nom de colonne).

**3. Pourquoi utilise-t-on `foreach` ?**
Pour parcourir le tableau ligne par ligne et afficher une ligne HTML `<tr>` pour chaque étudiant.

**4. Pourquoi utilise-t-on `htmlspecialchars()` lors de l'affichage des chaînes ?**
Pour transformer les caractères spéciaux (`<`, `>`, `"`...) en texte inoffensif. Cela protège contre les attaques XSS (injection de code HTML ou JavaScript).

**5. Quelle différence existe entre les données stockées dans la base et le HTML généré ?**
La base contient les données brutes et durables. Le HTML est seulement un affichage temporaire fabriqué par PHP à chaque chargement de page.

---

## Activité 7 : Ajouter un étudiant avec un formulaire

**1. Pourquoi la validation HTML ne suffit-elle pas ?**
Elle se fait dans le navigateur, donc l'utilisateur peut la contourner (outils du navigateur, requête envoyée à la main).

**2. Pourquoi faut-il vérifier les données côté serveur ?**
Parce que le serveur ne doit jamais faire confiance aux données reçues. C'est la seule vérification fiable avant d'écrire dans la base.

**3. Pourquoi `id` n'apparaît-il pas dans le formulaire ?**
Parce qu'il est généré automatiquement par `AUTO_INCREMENT`. L'utilisateur n'a pas à le choisir.

**4. Comment vérifier que l'étudiant a réellement été ajouté à la base ?**
En regardant la liste dans `liste.php`, ou en faisant `SELECT * FROM etudiants;` dans MySQL / phpMyAdmin.

---

## Activité 8 : Utiliser une requête préparée

**1. Quel est le rôle de `prepare()` ?**
Envoyer la structure de la requête SQL au serveur avec des paramètres à la place des valeurs.

**2. Quel est le rôle de `execute()` ?**
Exécuter la requête préparée en donnant les vraies valeurs pour les paramètres.

**3. À quoi correspondent `:nom`, `:prenom` et les autres paramètres nommés ?**
Ce sont des emplacements réservés (*placeholders*). Ils sont remplacés de façon sécurisée par les valeurs passées à `execute()`.

**4. Pourquoi ne faut-il pas construire la requête SQL en concaténant directement les données du formulaire ?**
Parce qu'un utilisateur malveillant peut écrire du code SQL dans le champ : c'est l'**injection SQL**. Il pourrait lire, modifier ou supprimer des données.

**5. Une requête préparée remplace-t-elle la validation des données ? Justifiez.**
Non. La requête préparée protège contre l'injection SQL, mais elle ne vérifie pas que les données sont correctes (par exemple un âge négatif ou une moyenne de 50 passeraient quand même). Il faut les deux.

---

## Activité 9 : Rechercher un étudiant avec GET

**1. Pourquoi GET est-il adapté à une recherche ?**
Parce qu'une recherche ne modifie rien dans la base. Avec GET, le critère apparaît dans l'URL : on peut l'ajouter aux favoris, la partager et recharger la page.

**2. Quel est le rôle de `LIKE` ?**
Comparer une colonne avec un motif, donc chercher une partie d'un texte et pas seulement une valeur exacte.

**3. À quoi servent les caractères `%` dans cette requête ?**
Ils remplacent n'importe quelle suite de caractères. `%abc%` veut dire « contient abc » (au début, au milieu ou à la fin).

**4. Pourquoi utiliser une requête préparée même pour une recherche ?**
Car la valeur vient de l'utilisateur. Sans requête préparée, elle pourrait provoquer une injection SQL.

---

## Activité 10 : Modifier un étudiant

**1. Pourquoi l'identifiant doit-il être vérifié ?**
Il vient de l'URL, donc l'utilisateur peut le changer ou écrire n'importe quoi (texte, valeur négative...). On vérifie que c'est un entier valide.

**2. Pourquoi faut-il vérifier que l'étudiant existe ?**
L'identifiant peut être valide mais ne correspondre à aucun étudiant (par exemple `id=999`). Sans vérification, on aurait des erreurs en affichant le formulaire.

**3. Pourquoi l'identifiant ne doit-il pas être modifiable comme les autres champs ?**
C'est la clé primaire : il identifie la ligne. Le changer casserait l'identification de l'étudiant et pourrait créer des conflits.

**4. Pourquoi faut-il utiliser une requête préparée pour `UPDATE` ?**
Les nouvelles valeurs viennent du formulaire (donc de l'utilisateur). La requête préparée évite l'injection SQL.

---

## Activité 11 : Supprimer un étudiant

**1. Pourquoi la suppression est-elle une opération à protéger ?**
Elle est définitive : une fois la ligne supprimée, on ne peut pas la récupérer. Il faut éviter les suppressions par erreur ou par une personne non autorisée.

**2. Pourquoi ne faut-il pas supprimer une ligne uniquement à partir du nom ?**
Plusieurs étudiants peuvent avoir le même nom, donc on risque d'en supprimer plusieurs. L'identifiant est unique.

**3. Pourquoi privilégier POST pour déclencher la suppression ?**
Un lien GET peut être déclenché par erreur (clic, préchargement du navigateur, robot d'indexation). POST est utilisé pour les actions qui modifient les données et ne s'exécute qu'avec l'envoi d'un formulaire.

**4. Comment vérifier qu'une ligne a été supprimée ?**
Recharger la liste et vérifier que l'étudiant n'apparaît plus, ou utiliser `rowCount()` après `execute()` (si le résultat est supérieur à 0, une ligne a été supprimée).
