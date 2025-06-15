<?php

namespace App\Models;

use CodeIgniter\Model;

class ParkingSettingModel extends Model
{
    protected $table            = 'parking_settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'legal_name', 'trade_name', 'cnpj', 'state_registration', 'phone_number',
        'zip_code', 'address', 'number', 'city', 'state', 'site_url', 'instagram',
        'email', 'ticket_footer_text'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'legal_name'         => 'required|max_length[255]',
        'trade_name'         => 'required|max_length[255]',
        'cnpj'               => 'required|exact_length[18]',
        'state_registration' => 'permit_empty|max_length[30]',
        'phone_number'       => 'required|max_length[20]',
        'zip_code'           => 'required|exact_length[8]',
        'address'            => 'required|max_length[255]',
        'number'             => 'required|max_length[10]',
        'city'               => 'required|max_length[100]',
        'state'              => 'required|exact_length[2]',
        'site_url'           => 'permit_empty|valid_url|max_length[255]',
        'instagram'          => 'permit_empty|max_length[255]',
        'email'              => 'required|valid_email|max_length[255]',
        'ticket_footer_text' => 'required|max_length[65535]',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    // ** Cache **
    protected $cache;
    protected $settingsId = 1;

    public function __construct()
    {
        parent::__construct();
        $this->cache = \Config\Services::cache();
    }

    /**
     * Obtém todas as configurações do sistema.
     * Tenta do cache primeiro. Se não, busca do DB (ID 1) e armazena.
     * @return array|null Um array associativo com todas as configurações ou null se não houver.
     */
    public function getAllSettings(): ?array
    {
        $cacheKey = 'parking_system_settings_all';
        $settings = $this->cache->get($cacheKey);

        if ($settings === null) {
            $settings = $this->find($this->settingsId);
            if ($settings) {
                $this->cache->save($cacheKey, $settings, 3600);
            }
        }
        return $settings;
    }

    /**
     * Atualiza as configurações existentes.
     * @param array $data Um array associativo com os dados a serem atualizados.
     * @return bool True se a atualização foi bem-sucedida, false caso contrário.
     */
    public function updateSettings(array $data): bool
    {
        if (!$this->validate($data)) {
            return false;
        }

        $result = $this->update($this->settingsId, $data);

        if ($result) {
            $this->cache->delete('parking_system_settings_all');
        }
        return (bool) $result;
    }

    public function clearAllSettingCache()
    {
        $this->cache->delete('parking_system_settings_all');
    }
}