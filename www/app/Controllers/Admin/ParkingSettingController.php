<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ParkingSettingModel;

/**
 * @property \CodeIgniter\HTTP\IncomingRequest $request
 */

class ParkingSettingController extends BaseController
{
    protected $parkingSettingModel;

    public function __construct()
    {
        $this->parkingSettingModel = new ParkingSettingModel();
    }

    public function edit()
    {
        $config = $this->parkingSettingModel->first();

        return view('admin/settings/edit', [
            'config' => $config,
            'active_page' => 'configuracoes',
            'titlePage' => 'Configurações do sistema'
        ]);
    }

    public function update()
    {
        $id = $this->request->getPost('id');

        $data = $this->request->getPost([
            'legal_name',
            'trade_name',
            'cnpj',
            'state_registration',
            'phone_number',
            'zip_code',
            'address',
            'neighborhood',
            'number',
            'city',
            'state',
            'site_url',
            'instagram',
            'email',
            'ticket_footer_text',
        ]);

        $this->parkingSettingModel->update($id, $data);

        return redirect()->back()->with('success', 'Configurações atualizadas com sucesso.');
    }
}
