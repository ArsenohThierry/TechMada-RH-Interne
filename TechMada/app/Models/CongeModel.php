<?php

namespace App\Models;

use CodeIgniter\Model;

class CongeModel extends Model
{
    protected $table = 'conges';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['employe_id', 'type_conge_id', 'date_debut', 'date_fin', 'nb_jours', 'motif', 'statut', 'commentaire_rh', 'traite_par'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];


    public function getAllByEmploye(int $employe_id): array
    {
        return $this->select('conges.*, types_conge.libelle AS type_conge_libelle')
            ->join('types_conge', 'types_conge.id = conges.type_conge_id')
            ->where('conges.employe_id', $employe_id)
            ->orderBy('conges.created_at', 'DESC')
            ->findAll();
    }


    /**
     * Insère une nouvelle demande de congé.
     * Retourne l'id inséré, ou false si échec.
     */
    public function insertConge(array $data): int|false
    {
        $row = [
            'employe_id' => $data['employe_id'],
            'type_conge_id' => $data['type_conge_id'],
            'date_debut' => $data['date_debut'],
            'date_fin' => $data['date_fin'],
            'nb_jours' => $data['nb_jours'],
            'motif' => $data['motif'] ?? null,
            'statut' => 'en_attente',   // toujours en_attente à la soumission
            'commentaire_rh' => null,
            'traite_par' => null,
        ];

        $this->insert($row);

        $id = $this->getInsertID();
        return $id > 0 ? $id : false;
    }

    public function getAllAvecFiltres(?string $statut = null, ?int $dept = null): array
    {
        $builder = $this->select('conges.*, 
                              employes.nom AS employe_nom, 
                              employes.prenom AS employe_prenom,
                              departements.nom AS departement,
                              types_conge.libelle AS type_conge_libelle')
            ->join('employes', 'employes.id = conges.employe_id')
            ->join('types_conge', 'types_conge.id = conges.type_conge_id')
            ->join('departements', 'departements.id = employes.departement_id', 'left')
            ->orderBy('conges.created_at', 'DESC');

        if ($statut)
            $builder->where('conges.statut', $statut);
        if ($dept)
            $builder->where('employes.departement_id', $dept);

        return $builder->findAll();
    }
}