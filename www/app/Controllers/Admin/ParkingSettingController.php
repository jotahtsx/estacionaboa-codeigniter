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
            'titlePage' => 'Configurações do sistema',
            'errors' => session('errors') ?? []
        ]);
    }

    public function update()
    {
        $id = $this->request->getPost('id');

        $rules = [
            'legal_name'         => 'required',
            'trade_name'         => 'required',
            'cnpj'               => 'required',
            'state_registration' => 'required',
            'phone_number'       => 'required',
            'zip_code'           => 'required',
            'address'            => 'required',
            'neighborhood'       => 'required',
            'number'             => 'required',
            'city'               => 'required',
            'state'              => 'required',
            'email'              => 'required|valid_email',
            'ticket_footer_text' => 'required'
        ];

        $fieldNames = [
            'legal_name'         => 'Razão Social',
            'trade_name'         => 'Nome Fantasia',
            'cnpj'               => 'CNPJ',
            'state_registration' => 'Inscrição Estadual',
            'phone_number'       => 'Telefone',
            'zip_code'           => 'CEP',
            'address'            => 'Endereço',
            'neighborhood'       => 'Bairro',
            'number'             => 'Número',
            'city'               => 'Cidade',
            'state'              => 'Estado',
            'email'              => 'E-mail',
            'ticket_footer_text' => 'Texto do rodapé do ticket'
        ];

        if (! $this->validate($rules)) {
            $errors = $this->validator->getErrors();

            foreach ($errors as $field => &$message) {
                if (isset($fieldNames[$field])) {
                    $message = str_replace($field, $fieldNames[$field], $message);
                }
            }

            return redirect()->back()->withInput()->with('errors', $errors);
        }

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
