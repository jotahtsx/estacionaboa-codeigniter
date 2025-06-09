<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CompanyInfoModel;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * @property \CodeIgniter\HTTP\IncomingRequest $request
 */
class CompanyInfoController extends BaseController
{
    protected $companyInfoModel;

    public function __construct()
    {
        $this->companyInfoModel = new CompanyInfoModel();
    }

    /**
     * Exibe o formulário de informações da empresa (ou cria se não existir).
     *
     * @return string
     */
    public function index(): string
    {
        // Tenta encontrar o registro da empresa com ID 1 (assumimos que haverá apenas um)
        $companyInfo = $this->companyInfoModel->find(1);

        // Se não encontrar, inicializa um array vazio para evitar erros na view
        if (!$companyInfo) {
            $companyInfo = [
                'corporate_name'     => '',
                'trade_name'         => '',
                'cnpj'               => '',
                'state_registration' => '',
                'phone_main'         => '',
                'phone_optional'     => '',
                'email_contact'      => '',
                'website_url'        => '',
                'social_media_url'   => '',
                'address_zipcode'    => '',
                'address_street'     => '',
                'address_number'     => '',
                'address_complement' => '',
                'address_neighborhood' => '',
                'address_city'       => '',
                'address_state'      => '',
            ];
        }

        $data = [
            'titlePage'     => 'Configurações da Empresa',
            'companyInfo'   => $companyInfo,
            'active_page'   => 'empresa',
            'validation'    => \Config\Services::validation(),
        ];

        return view('company_info/company', $data);
    }

    /**
     * Salva ou atualiza as informações da empresa.
     * Este método é acionado por uma requisição POST do formulário.
     *
     * @return RedirectResponse
     */
    public function save(): RedirectResponse
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back()->with('error', 'Método de requisição inválido.');
        }

        $data = $this->request->getPost();
        if (! $this->companyInfoModel->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $this->companyInfoModel->errors());
        }
        $existingInfo = $this->companyInfoModel->find(1);

        if ($existingInfo) {
            if ($this->companyInfoModel->update(1, $data)) {
                return redirect()->to(base_url('configuracoes/empresa'))->with('success', 'Informações da empresa atualizadas com sucesso!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Erro ao atualizar as informações da empresa.');
            }
        } else {
            if ($this->companyInfoModel->insert($data)) {
                return redirect()->to(base_url('configuracoes/empresa'))->with('success', 'Informações da empresa salvas com sucesso!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Erro ao salvar as informações da empresa.');
            }
        }
    }
}