<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PricingModel;

/**
 * @property \CodeIgniter\HTTP\IncomingRequest $request
 */
class PricingController extends BaseController
{
    protected $pricingModel;

    public function __construct()
    {
        $this->pricingModel = new PricingModel();
    }

    public function index()
    {
        $pricings = $this->pricingModel->findAll();

        return view('admin/pricings/index', [
            'pricings'    => $pricings,
            'active_page' => 'precificacoes',
            'titlePage'   => 'Precificações',
        ]);
    }

    public function create()
    {
        return view('admin/pricings/create', [
            'active_page' => 'precificacoes',
            'titlePage'   => 'Cadastrar Precificação',
            'errors'      => session('errors'),
        ]);
    }

    public function store()
    {
        $rules = [
            'pricing_category'      => 'required',
            'pricing_by_hour'       => 'required|decimal',
            'pricing_by_mensality'  => 'required|decimal',
            'capacity'              => 'required|integer',
            'active'                => 'permit_empty|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost([
            'pricing_category',
            'pricing_by_hour',
            'pricing_by_mensality',
            'capacity',
            'active',
        ]);

        $this->pricingModel->insert($data);

        return redirect()->to(base_url('admin/precificacoes'))->with('success', 'Precificação cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $pricing = $this->pricingModel->find($id);

        if (! $pricing) {
            return redirect()->back()->with('errors', ['Registro não encontrado.']);
        }

        return view('admin/pricings/edit', [
            'pricing'     => $pricing,
            'active_page' => 'precificacoes',
            'titlePage'   => 'Editar Precificação',
            'errors'      => session('errors'),
        ]);
    }

    public function update($id)
    {
        $rules = [
            'pricing_category'      => 'required',
            'pricing_by_hour'       => 'required|decimal',
            'pricing_by_mensality'  => 'required|decimal',
            'capacity'              => 'required|integer',
            'active'                => 'permit_empty|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost([
            'pricing_category',
            'pricing_by_hour',
            'pricing_by_mensality',
            'capacity',
            'active',
        ]);

        $this->pricingModel->update($id, $data);

        return redirect()->to(base_url('admin/precificacoes'))->with('success', 'Precificação atualizada com sucesso!');
    }

    public function delete($id)
    {
        $this->pricingModel->delete($id);

        return redirect()->to(base_url('admin/precificacoes'))->with('success', 'Precificação removida com sucesso!');
    }
}
