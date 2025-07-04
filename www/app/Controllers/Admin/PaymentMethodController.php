<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PaymentMethodModel;

/**
 * @property \CodeIgniter\HTTP\IncomingRequest $request
 */
class PaymentMethodController extends BaseController
{
    protected $paymentMethodModel;

    public function __construct()
    {
        $this->paymentMethodModel = new PaymentMethodModel();
    }

    /**
     * Exibe a lista de todas as formas de pagamento.
     */
    public function index()
    {
        $data = [
            'titlePage'      => 'Formas de Pagamento',
            'active_page'    => 'pagamentos', // Para marcar o menu na sidebar
            'paymentMethods' => $this->paymentMethodModel->findAll(), // Busca todas as formas de pagamento
        ];

        return view('admin/payment_methods/index', $data);
    }

    /**
     * Exibe o formulário para criar uma nova forma de pagamento.
     */
    public function create()
    {
        $data = [
            'titlePage'   => 'Cadastrar Forma de Pagamento',
            'active_page' => 'pagamentos', // Para marcar o menu na sidebar
        ];
        return view('admin/payment_methods/form', $data);
    }

    /**
     * Salva uma nova forma de pagamento no banco de dados.
     */
    public function store()
    {
        // Define as regras de validação para os campos
        $rules = [
            'name'        => 'required|min_length[3]|max_length[100]|is_unique[payment_methods.name]',
            'description' => 'permit_empty|max_length[255]',
            'active'      => 'required|in_list[0,1]',
        ];

        // Valida os dados da requisição
        if (! $this->validate($rules)) {
            // Se a validação falhar, redireciona de volta com os erros e dados antigos
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Prepara os dados para salvar
        $data = [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'active'      => $this->request->getPost('active'),
        ];

        // Salva os dados usando o Model
        $this->paymentMethodModel->save($data);

        // Redireciona para a página de listagem com mensagem de sucesso
        return redirect()->to(base_url('admin/pagamentos'))->with('success', 'Forma de pagamento criada com sucesso.');
    }

    /**
     * Exibe o formulário para editar uma forma de pagamento existente.
     * @param int $id ID da forma de pagamento a ser editada
     */
    public function edit($id)
    {
        // Busca a forma de pagamento pelo ID
        $paymentMethod = $this->paymentMethodModel->find($id);

        // Se a forma de pagamento não for encontrada, exibe erro 404
        if (empty($paymentMethod)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'titlePage'     => 'Editar Forma de Pagamento',
            'active_page'   => 'pagamentos', // Para marcar o menu na sidebar
            'paymentMethod' => $paymentMethod, // Passa os dados da forma de pagamento para a view
        ];
        return view('admin/payment_methods/form', $data);
    }

    /**
     * Atualiza uma forma de pagamento existente no banco de dados.
     * @param int $id ID da forma de pagamento a ser atualizada
     */
    public function update($id)
    {
        $post = $this->request->getPost();

        // Regras de validação, incluindo a validação de unicidade do nome
        $rules = [
            'name'        => [
                'label'  => 'Nome da Forma de Pagamento',
                'rules'  => "required|min_length[3]|max_length[100]|is_unique[payment_methods.name,id,{$id}]", // Note: {id} para ignorar o próprio registro
                'errors' => [
                    'is_unique' => 'O nome da forma de pagamento informado já existe.'
                ]
            ],
            'description' => 'permit_empty|max_length[255]',
            'active'      => 'required|in_list[0,1]',
        ];

        // Prepara os dados para validação
        $dataToValidate = [
            'name'        => $post['name'],
            'description' => $post['description'],
            'active'      => $post['active'],
        ];

        // Valida os dados
        if (! $this->validateData($dataToValidate, $rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Prepara os dados para atualização (apenas os campos que serão alterados)
        $dataToUpdate = [
            'name'        => $post['name'],
            'description' => $post['description'],
            'active'      => $post['active'],
        ];

        // Atualiza os dados usando o Model
        $this->paymentMethodModel->update($id, $dataToUpdate);

        // Redireciona para a página de listagem com mensagem de sucesso
        return redirect()->to(base_url('admin/pagamentos'))->with('success', 'Forma de pagamento atualizada com sucesso.');
    }

    /**
     * Deleta uma forma de pagamento do banco de dados
     * @param int $id ID da forma de pagamento a ser deletada
     */
    public function delete($id)
    {
        $this->paymentMethodModel->delete($id);
        return redirect()->to(base_url('admin/pagamentos'))->with('success', 'Forma de pagamento removida com sucesso.');
    }
}