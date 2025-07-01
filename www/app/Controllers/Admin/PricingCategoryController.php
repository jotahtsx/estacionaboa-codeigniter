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
        $this->categoryModel = new PricingCategoryModel();
    }

    public function index()
    {
        $categories = $this->categoryModel->findAll();

        return view('admin/pricing_categories/index', [
            'categories' => $categories,
            'active_page' => 'categorias',
            'titlePage' => 'Categorias de Precificação'
        ]);
    }

    public function create()
    {
        return view('admin/pricing_categories/create', [
            'active_page' => 'categorias',
            'titlePage' => 'Nova Categoria',
            'errors' => session('errors') ?? []
        ]);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoryModel->insert([
            'name' => $this->request->getPost('name')
        ]);

        return redirect()->to(base_url('admin/categorias'))->with('success', 'Categoria criada com sucesso.');
    }

    public function edit($id)
    {
        $category = $this->categoryModel->find($id);

        if (! $category) {
            return redirect()->to(base_url('admin/categorias'))->with('error', 'Categoria não encontrada.');
        }

        return view('admin/pricing_categories/edit', [
            'category' => $category,
            'active_page' => 'categorias',
            'titlePage' => 'Editar Categoria',
            'errors' => session('errors') ?? []
        ]);
    }

    public function update($id)
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoryModel->update($id, [
            'name' => $this->request->getPost('name')
        ]);

        return redirect()->to(base_url('admin/categorias'))->with('success', 'Categoria atualizada com sucesso.');
    }

    public function delete($id)
    {
        $this->categoryModel->delete($id);

        return redirect()->to(base_url('admin/categorias'))->with('success', 'Categoria removida com sucesso.');
    }
}
