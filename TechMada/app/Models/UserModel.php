<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'employes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['email', 'password', 'nom', 'prenom', 'actif', 'role', 'departement_id', 'date_embauche'];
    protected $useTimestamps = false;

    /**
     * Rechercher un utilisateur par email
     */
    public function getUserByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Créer un nouvel utilisateur
     * Le mot de passe est TOUJOURS hashé avec password_hash()
     */
    public function createUser(string $email, string $password, string $nom, string $prenom): bool
    {
        if (empty($password)) {
            throw new \Exception('Le mot de passe ne peut pas être vide');
        }

        // password_hash est OBLIGATOIRE
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if (empty($hashed_password)) {
            throw new \Exception('Erreur lors du hachage du mot de passe');
        }

        // Utiliser une transaction pour s'assurer que l'insertion de l'utilisateur
        // et l'initialisation des soldes sont atomiques.
        $this->db->transStart();

        $insertId = $this->insert([
            'email'          => $email,
            'password'       => $hashed_password,
            'nom'            => $nom,
            'prenom'         => $prenom,
            'actif'          => 1,
            'role'           => 'employe',
            'date_embauche'  => date('Y-m-d'),
        ]);

        if (! $insertId) {
            $this->db->transComplete();
            return false;
        }

        // Par défaut : Congé annuel (type_conge_id = 1) => 30 jours
        //             Congé maladie  (type_conge_id = 2) => 15 jours
        $annee = (int) date('Y');

        $soldesTable = $this->db->table('soldes');
        $soldesTable->insert([
            'employe_id'     => $insertId,
            'type_conge_id'  => 1,
            'annee'          => $annee,
            'jours_attribues' => 30,
            'jours_pris'      => 0,
        ]);

        $soldesTable->insert([
            'employe_id'     => $insertId,
            'type_conge_id'  => 2,
            'annee'          => $annee,
            'jours_attribues' => 15,
            'jours_pris'      => 0,
        ]);

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    /**
     * Vérifier les identifiants avec password_verify() obligatoire
     * Retourne null si email/password invalide
     */
    public function verifyCredentials(string $email, string $password): ?array
    {
        if (empty($email) || empty($password)) {
            return null;
        }

        $user = $this->getUserByEmail($email);

        // Vérifier avec password_verify() qui est obligatoire
        if ($user && password_verify($password, $user['password']) && $user['actif'] == 1) {
            return $user;
        }

        return null;
    }

    /**
     * Récupérer un utilisateur actif par ID
     */
    public function getActiveUserById(int $id)
    {
        return $this->where('id', $id)
                    ->where('actif', 1)
                    ->first();
    }

    /**
     * Vérifier si un email existe déjà
     */
    public function emailExists(string $email): bool
    {
        return $this->where('email', $email)->countAllResults() > 0;
    }
}
