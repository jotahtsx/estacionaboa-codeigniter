<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MonthlyPaymentModel;
use App\Models\MonthlyPayerModel;
use App\Models\PricingModel;

/**
 * @property \CodeIgniter\HTTP\IncomingRequest $request
 */
class MonthlyPaymentController extends BaseController
{
    protected $monthlyPaymentModel;
    protected $monthlyPayerModel;
    protected $pricingModel;

    public function __construct()
    {
        $this->monthlyPaymentModel = new MonthlyPaymentModel();
        $this->monthlyPayerModel = new MonthlyPayerModel();
        $this->pricingModel = new PricingModel();
    }

    public function index()
    {
        $builder = $this->monthlyPaymentModel->builder();
        $builder->select('monthly_payments.*, monthly_payers.first_name, monthly_payers.last_name, monthly_payers.cpf, pricings.pricing_by_mensality, pricing_categories.name as category_name');
        $builder->join('monthly_payers', 'monthly_payers.id = monthly_payments.monthly_payer_id');
        $builder->join('pricings', 'pricings.id = monthly_payments.pricing_id');
        $builder->join('pricing_categories', 'pricing_categories.id = pricings.pricing_category_id');
        $monthlyPayments = $builder->get()->getResultArray();

        // Já tem tudo, só formatar os nomes etc
        foreach ($monthlyPayments as &$payment) {
            $payment['monthly_payer_name'] = $payment['first_name'] . ' ' . $payment['last_name'];
            $payment['pricing_value'] = $payment['pricing_value'] ?? $payment['pricing_by_mensality'];
            $payment['payment_date'] = $payment['payment_date'] ?? null;
            $payment['active'] = $payment['active'] ?? 1;
        }

        $data = [
            'titlePage' => 'Mensalidades',
            'monthlyPayments' => $monthlyPayments,
            'active_page' => 'mensalidades',
        ];

        return view('admin/monthly_payments/index', $data);
    }


    public function create()
    {
        $monthlyPayers = (new \App\Models\MonthlyPayerModel())
                            ->where('active', 1)
                            ->findAll();

        $pricingsModel = new \App\Models\PricingModel();

        // Faz join com categorias para pegar o nome da categoria junto
        $pricings = $pricingsModel
                    ->select('pricings.*, pricing_categories.name as category_name')
                    ->join('pricing_categories', 'pricing_categories.id = pricings.pricing_category_id')
                    ->where('pricings.active', 1)
                    ->findAll();

        $data = [
            'titlePage'     => 'Cadastrar Mensalidade',
            'active_page'   => 'mensalidades',
            'monthlyPayers' => $monthlyPayers,
            'pricings'      => $pricings,
        ];

        return view('admin/monthly_payments/create', $data);
    }

    public function store()
    {
        $request = service('request');
        $data = $request->getPost();

        // Corrige o valor monetário para formato decimal (ex: "1.234,56" => "1234.56")
        if (isset($data['pricing_value'])) {
            $data['pricing_value'] = str_replace(['.', ','], ['', '.'], $data['pricing_value']);
        }

        $validationRules = [
            'monthly_payer_id' => 'required|integer',
            'pricing_id'       => 'required|integer',
            'due_day'          => 'required|integer|greater_than[0]|less_than_equal_to[31]',
            'pricing_value'    => 'required|decimal',
            'due_date'         => 'required|valid_date',
            'status'           => 'required|in_list[pendente,pago,atrasado]',
            'active'           => 'required|in_list[0,1]', 
        ];

        $validation = \Config\Services::validation();
        $validation->setRules($validationRules);

        if (!$validation->run($data)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Insere no banco com todos os campos necessários
        $this->monthlyPaymentModel->insert([
            'monthly_payer_id' => $data['monthly_payer_id'],
            'pricing_id'       => $data['pricing_id'],
            'due_day'          => $data['due_day'],          // <== campo incluído
            'amount'           => $data['pricing_value'],    // valor convertido já
            'due_date'         => $data['due_date'],
            'status'           => $data['status'],
            'active'           => 1,                         // pode deixar fixo se quiser
        ]);

        return redirect()->route('admin_mensalidades')->with('success', 'Mensalidade cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $data['monthlyPayment'] = $this->monthlyPaymentModel->find($id);

        if (!$data['monthlyPayment']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Mensalidade não encontrada');
        }

        $data['monthlyPayers'] = $this->monthlyPayerModel->where('active', 1)->findAll();
        $data['pricings'] = $this->pricingModel->where('active', 1)->findAll();

        return view('admin/monthly_payments/edit', $data);
    }

    public function update($id)
    {
        $post = $this->request->getPost();

        if (!$this->monthlyPaymentModel->update($id, $post)) {
            return redirect()->back()->withInput()->with('errors', $this->monthlyPaymentModel->errors());
        }

        return redirect()->to('/admin/monthly-payments')->with('success', 'Mensalidade atualizada com sucesso!');
    }

    public function delete($id)
    {
        if (!$this->monthlyPaymentModel->delete($id)) {
            return redirect()->back()->with('error', 'Erro ao deletar a mensalidade');
        }

        return redirect()->to('/admin/monthly-payments')->with('success', 'Mensalidade deletada com sucesso!');
    }
}
