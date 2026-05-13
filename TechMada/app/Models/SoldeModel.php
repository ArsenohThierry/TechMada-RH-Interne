<?php

namespace App\Models;

use CodeIgniter\Model;

class SoldeModel extends Model
{
    protected $table            = 'soldes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

public function getJoursRestants(int $employe_id, int $type_conge_id): int
{
    $result = $this->select('jours_attribues - jours_pris AS jours_restants', false)
                   ->where('employe_id',    $employe_id)
                   ->where('type_conge_id', $type_conge_id)
                   ->where('annee',         (int) date('Y'))
                   ->first();

    return $result ? (int) $result['jours_restants'] : 0;
}

    /**
     * Retourne la ligne de solde pour un employé/type/année ou null
     */
    public function getSolde(int $employe_id, int $type_conge_id, ?int $annee = null): ?array
    {
        $annee = $annee ?? (int) date('Y');
        return $this->where('employe_id', $employe_id)
                    ->where('type_conge_id', $type_conge_id)
                    ->where('annee', $annee)
                    ->first() ?: null;
    }

    /**
     * Incrémente `jours_pris` de la ligne de solde (utilise une opération SQL pour être atomique)
     */
    public function incrementJoursPris(int $solde_id, int $jours): bool
    {
        if ($jours <= 0) return false;

        $db = \Config\Database::connect();
        $builder = $db->table($this->table);

        return (bool) $builder->set('jours_pris', "jours_pris + {$jours}", false)
                              ->where('id', $solde_id)
                              ->update();
    }
}
