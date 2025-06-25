<?php

namespace App\Controllers;

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

        return view('settings/edit', ['config' => $config]);
    }

    public function update()
    {
        $id = $this->request->getPost('id');

        $data = $this->request->getPost([
            'trade_name',
            'cnpj',
            'state_registration',
            'phone_number',
            'zip_code',
            'address',
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
