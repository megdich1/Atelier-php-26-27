<?php

const FICHIER_UTILISATEURS = __DIR__ . '/data/utilisateurs.php';

function charger_utilisateurs(): array
{
    if (!file_exists(FICHIER_UTILISATEURS)) {
        // Premier lancement : on crée un compte admin par défaut (mot de passe : admin123)
        $utilisateurs = ['admin' => password_hash('admin123', PASSWORD_DEFAULT)];
        sauvegarder_utilisateurs($utilisateurs);
        return $utilisateurs;
    }
    return require FICHIER_UTILISATEURS;
}

function sauvegarder_utilisateurs(array $utilisateurs): void
{
    if (!is_dir(dirname(FICHIER_UTILISATEURS))) {
        mkdir(dirname(FICHIER_UTILISATEURS), 0755, true);
    }
    $code = "<?php\nreturn " . var_export($utilisateurs, true) . ";\n";
    file_put_contents(FICHIER_UTILISATEURS, $code, LOCK_EX);
}