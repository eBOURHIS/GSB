# phpmyadmin

Pour activer phpmyadmin : `phpmyadmin-ctl install`

# Modification pour mise en application

GestionVisiteur.php:32
GestionVisiteur.php:90
def.php:68
maFicheFrais.php:22

# Voir le site
Lauch in terminal : `sudo service apache2 start`
https://gsb-ppe1-laladu29.c9users.io

# Information schéma
```sql
SELECT COLUMN_NAME,COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='gsb_frais' AND TABLE_NAME='FicheFrais';
```