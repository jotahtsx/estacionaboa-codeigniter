<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PricingCategoryModel;

/**
 * @property \CodeIgniter\HTTP\IncomingRequest $request
 */
class PricingCategoryController extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        // Instancia o modelo da categoria
        $this->categoryModel = new PricingCategoryModel();
    }

    public function index()
    {
        // Busca todas as categorias
        $categories = $this->categoryModel->findAll();

        return view('admin/pricing_categories/index', [
            'categories'  => $categories,
            'active_page' => 'categorias',
            'titlePage'   => 'Categorias de Precificação'
        ]);
    }

    public function create()
    {
        return view('admin/pricing_categories/create', [
            'active_page' => 'categorias',
            'titlePage'   => 'Nova Categoria',
            'errors'      => session('errors') ?? [] // Pega erros de validação anteriores
        ]);
    }

    public function store()
    {
        // Regras de validação para o campo 'name'
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]|is_unique[pricing_categories.name]', // Adicionado is_unique,
            'active' => 'required|in_list[0,1]', // Adicione a regra de validação para 'active'

        ];

        // Se a validação falhar, redireciona de volta com os erros
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Insere a nova categoria. O campo 'active' terá o valor padrão (true) definido na migration.
        $this->categoryModel->insert([
            'name' => $this->request->getPost('name'),
            'active' => $this->request->getPost('active'),

        ]);

        return redirect()->to(base_url('admin/categorias'))->with('success', 'Categoria criada com sucesso.');
    }

    public function edit($id)
    {
        // Busca a categoria pelo ID
        $category = $this->categoryModel->find($id);

        // Se a categoria não for encontrada, redireciona com mensagem de erro
        if (! $category) {
            return redirect()->to(base_url('admin/categorias'))->with('error', 'Categoria não encontrada.');
        }

        return view('admin/pricing_categories/edit', [
            'category'    => $category,
            'active_page' => 'categorias',
            'titlePage'   => 'Editar Categoria',
            'errors'      => session('errors') ?? []
        ]);
    }

    public function update($id)
    {
        $post = $this->request->getPost();

        $rules = [
            'name' => [
                'label'  => 'Nome da Categoria',
                'rules'  => 'required|min_length[3]|max_length[100]|is_unique[pricing_categories.name,id,{id}]',
                'errors' => [
                    'is_unique' => 'O nome da categoria informado já existe.'
                ]
            ],
            'id' => [
                'label' => 'ID da Categoria',
                'rules' => 'required|integer',
            ],
            'active' => 'required|in_list[0,1]',
        ];

        $dataToValidate = [
            'id'     => $id,
            'name'   => $post['name'],
            'active' => $post['active'],
        ];

        if (! $this->validateData($dataToValidate, $rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Os dados para atualização já estão corretos
        $this->categoryModel->update($id, [
            'name'   => $post['name'],
            'active' => $post['active'],
        ]);

        return redirect()->to(base_url('admin/categorias'))->with('success', 'Categoria atualizada com sucesso.');
    }

    public function delete($id)
    {
        // Deleta a categoria
        $this->categoryModel->delete($id);

        return redirect()->to(base_url('admin/categorias'))->with('success', 'Categoria removida com sucesso.');
    }
}
