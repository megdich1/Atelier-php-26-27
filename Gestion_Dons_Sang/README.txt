Mini-projet : Gestion des dons de sang
Students: NAME 1, NAME 2

1. Import the database:  sudo mariadb < don_sang.sql
2. DB user used by the app (config/config.php): admin / admin
   CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin';
   GRANT ALL PRIVILEGES ON don_sang.* TO 'admin'@'localhost';
3. Start the server:  php -S localhost:8000
4. Open: http://localhost:8000/auth/login.php
5. Login: megdich / 002812 (Admin)
