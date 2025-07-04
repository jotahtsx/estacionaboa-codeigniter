<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PricingModel;
use App\Models\PricingCategoryModel;

/**
 * @property \CodeIgniter\HTTP\IncomingRequest $request
 */
class PricingController extends BaseController
{
    protected $pricingModel;
    protected $categoryModel; // Adicionado para injeção

    public function __construct()
    {
        $this->pricingModel = new PricingModel();
        $this->categoryModel = new PricingCategoryModel(); // Instancia o modelo da categoria
    }

    public function index()
    {
        // Busca as precificações, fazendo JOIN com categorias para mostrar o nome da categoria
        $pricings = $this->pricingModel
            ->select('pricings.*, pricing_categories.name as category_name')
            ->join('pricing_categories', 'pricing_categories.id = pricings.pricing_category_id')
            ->findAll();

        return view('admin/pricings/index', [
            'pricings'    => $pricings,
            'active_page' => 'precificacoes',
            'titlePage'   => 'Precificações'
        ]);
    }

    public function create()
    {
        // Busca apenas categorias ativas para a seleção no formulário
        $categories = $this->categoryModel->where('active', 1)->findAll();

        return view('admin/pricings/create', [
            'categories'  => $categories,
            'active_page' => 'precificacoes',
            'titlePage'   => 'Nova Precificação',
            'errors'      => session('errors') ?? []
        ]);
    }

    public function store()
    {
        $post = $this->request->getPost();

        // Sanitiza valores monetários (BR -> US) ANTES da validação
        $post['pricing_by_hour']      = $this->sanitizeCurrency($post['pricing_by_hour'] ?? '');
        $post['pricing_by_mensality'] = $this->sanitizeCurrency($post['pricing_by_mensality'] ?? '');

        $rules = [
            'pricing_category_id'  => 'required|integer|is_not_unique[pricing_categories.id]', // Valida se a categoria existe
            'pricing_by_hour'      => 'required|decimal|greater_than_equal_to[0]', // Adicionado 'greater_than_equal_to'
            'pricing_by_mensality' => 'required|decimal|greater_than_equal_to[0]', // Adicionado 'greater_than_equal_to'
            'capacity'             => 'required|integer|greater_than_equal_to[0]', // Capacidade não pode ser negativa
            'active'               => 'permit_empty|in_list[0,1]', // Permitir vazio (se checkbox não marcado) ou 0/1
        ];

        // Valida os dados do POST
        if (! $this->validateData($post, $rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Insere os dados processados
        $this->pricingModel->insert($post);

        return redirect()->to(base_url('admin/precificacoes'))->with('success', 'Precificação cadastrada com sucesso!');
    }

    public function edit($id)
    {
        // Busca a precificação e as categorias ativas
        $pricing       = $this->pricingModel->find($id);
        $categories    = $this->categoryModel->where('active', 1)->findAll();

        // Se a precificação não for encontrada, redireciona
        if (! $pricing) {
            return redirect()->to(base_url('admin/precificacoes'))->with('error', 'Precificação não encontrada.');
        }

        return view('admin/pricings/edit', [
            'pricing'     => $pricing,
            'categories'  => $categories,
            'active_page' => 'precificacoes',
            'titlePage'   => 'Editar Precificação',
            'errors'      => session('errors') ?? []
        ]);
    }

    public function update($id)
    {
        $post = $this->request->getPost();

        // Converte valores monetários para padrão americano (decimal com ponto)
        $post['pricing_by_hour']      = $this->sanitizeCurrency($post['pricing_by_hour'] ?? '');
        $post['pricing_by_mensality'] = $this->sanitizeCurrency($post['pricing_by_mensality'] ?? '');

        $rules = [
            'pricing_category_id'  => 'required|integer|is_not_unique[pricing_categories.id]',
            'pricing_by_hour'      => 'required|decimal|greater_than_equal_to[0]',
            'pricing_by_mensality' => 'required|decimal|greater_than_equal_to[0]',
            'capacity'             => 'required|integer|greater_than_equal_to[0]',
            'active'               => 'permit_empty|in_list[0,1]',
        ];

        // Valida os dados do POST
        if (! $this->validateData($post, $rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Atualiza a precificação
        $this->pricingModel->update($id, $post);

        return redirect()->to(base_url('admin/precificacoes'))->with('success', 'Precificação atualizada com sucesso!');
    }

    public function delete($id)
    {
        $this->pricingModel->delete($id);

        return redirect()->to(base_url('admin/precificacoes'))->with('success', 'Precificação removida com sucesso!');
    }

    /**
     * Converte valores monetários do formato BR (1.234,56) para US (1234.56)
     * Retorna null se o valor de entrada for vazio ou null.
     */
    private function sanitizeCurrency(string $value): ?string
    {
        if (empty($value) || $value === null) { // Adicionado verificação para $value === null
            return null;
        }

        $value = str_replace('.', '', $value); // Remove separador de milhar (ponto)
        return str_replace(',', '.', $value); // Troca vírgula decimal por ponto
    }
}