<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MonthlyPayerModel; // Importe o Model que acabamos de criar

/**
 * @property \CodeIgniter\HTTP\IncomingRequest $request
 */
class MonthlyPayerController extends BaseController
{
    protected $monthlyPayerModel;

    public function __construct()
    {
        // Instancia o Model para que possamos usá-lo nos métodos
        $this->monthlyPayerModel = new MonthlyPayerModel();
    }

    /**
     * Exibe a lista de todos os mensalistas.
     */
    public function index()
    {
        $data = [
            'titlePage'     => 'Mensalistas',
            'active_page'   => 'mensalistas',
            'monthlyPayers' => $this->monthlyPayerModel->findAll(),
        ];

        return view('admin/monthly_payers/index', $data);
    }

    /**
     * Exibe o formulário para cadastrar um novo mensalista.
     */
    public function create()
    {
        $data = [
            'titlePage'   => 'Cadastrar Mensalista',
            'active_page' => 'mensalistas',
        ];
        return view('admin/monthly_payers/create', $data);
    }

    /**
     * Salva um novo mensalista no banco de dados.
     */
    public function store()
    {
        // Regras de validação baseadas na sua migration
        $rules = [
            'first_name'   => 'required|min_length[3]|max_length[100]',
            'last_name'    => 'required|min_length[3]|max_length[100]',
            'birth_date'   => 'required|valid_date[Y-m-d]',
            'cpf'          => 'required|exact_length[14]|is_unique[monthly_payers.cpf]',
            'rg'           => 'required|max_length[20]|is_unique[monthly_payers.rg]',
            'email'        => 'required|valid_email|max_length[100]|is_unique[monthly_payers.email]',
            'phone'        => 'required|max_length[20]',
            'zip_code'     => 'required|exact_length[10]',
            'street'       => 'required|max_length[255]',
            'number'       => 'required|max_length[20]',
            'neighborhood' => 'required|max_length[100]',
            'city'         => 'required|max_length[100]',
            'state'        => 'required|exact_length[2]',
            'complement'   => 'permit_empty|max_length[255]',
            'active'       => 'required|in_list[0,1]',
            'due_day'      => 'required|integer|greater_than[0]|less_than[32]',
            'notes'        => 'permit_empty|max_length[65535]',
        ];

        // Pega todos os dados do POST
        $post = $this->request->getPost();

        // Valida os dados da requisição
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        // Prepara os dados para salvar
        $data = [
            'first_name'   => $post['first_name'],
            'last_name'    => $post['last_name'],
            'birth_date'   => $post['birth_date'],
            'cpf'          => $post['cpf'],
            'rg'           => $post['rg'],
            'email'        => $post['email'],
            'phone'        => $post['phone'],
            'zip_code'     => $post['zip_code'],
            'street'       => $post['street'],
            'number'       => $post['number'],
            'neighborhood' => $post['neighborhood'],
            'city'         => $post['city'],
            'state'        => $post['state'],
            'complement'   => $post['complement'],
            'active'       => $post['active'],
            'due_day'      => $post['due_day'],
            'notes'        => $post['notes'],
        ];

        // Salva os dados usando o Model
        $this->monthlyPayerModel->save($data);

        // Redireciona para a página de listagem com mensagem de sucesso
        return redirect()->to(url_to('admin_mensalistas'))->with('success', 'Mensalista cadastrado com sucesso!');
    }

    /**
     * Exibe o formulário para editar um mensalista existente.
     * @param int $id ID do mensalista a ser editado
     */
    public function edit($id)
    {
        // Busca o mensalista pelo ID
        $monthlyPayer = $this->monthlyPayerModel->find($id);

        // Se o mensalista não for encontrado, exibe erro 404
        if (empty($monthlyPayer)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'titlePage'    => 'Editar Mensalista',
            'active_page'  => 'mensalistas',
            'monthlyPayer' => $monthlyPayer,
        ];
        return view('admin/monthly_payers/edit', $data);
    }

    /**
     * Atualiza um mensalista existente no banco de dados.
     * @param int $id ID do mensalista a ser atualizado
     */
    public function update($id)
    {
        $post = $this->request->getPost();

        // Regras de validação para atualização
        $rules = [
            'first_name'   => 'required|min_length[3]|max_length[100]',
            'last_name'    => 'required|min_length[3]|max_length[100]',
            'birth_date'   => 'required|valid_date[Y-m-d]',
            'cpf'          => "required|exact_length[14]|is_unique[monthly_payers.cpf,id,{$id}]", // CPF único, ignorando o próprio ID
            'rg'           => "required|max_length[20]|is_unique[monthly_payers.rg,id,{$id}]",
            'email'        => "required|valid_email|max_length[100]|is_unique[monthly_payers.email,id,{$id}]",
            'phone'        => 'required|max_length[20]',
            'zip_code'     => 'required|exact_length[10]',
            'street'       => 'required|max_length[255]',
            'number'       => 'required|max_length[20]',
            'neighborhood' => 'required|max_length[100]',
            'city'         => 'required|max_length[100]',
            'state'        => 'required|exact_length[2]',
            'complement'   => 'permit_empty|max_length[255]',
            'active'       => 'required|in_list[0,1]',
            'due_day'      => 'required|integer|greater_than[0]|less_than[32]',
            'notes'        => 'permit_empty|max_length[65535]',
        ];

        // Valida os dados da requisição
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        // Prepara os dados para atualização
        $dataToUpdate = [
            'first_name'   => $post['first_name'],
            'last_name'    => $post['last_name'],
            'birth_date'   => $post['birth_date'],
            'cpf'          => $post['cpf'],
            'rg'           => $post['rg'],
            'email'        => $post['email'],
            'phone'        => $post['phone'],
            'zip_code'     => $post['zip_code'],
            'street'       => $post['street'],
            'number'       => $post['number'],
            'neighborhood' => $post['neighborhood'],
            'city'         => $post['city'],
            'state'        => $post['state'],
            'complement'   => $post['complement'],
            'active'       => $post['active'],
            'due_day'      => $post['due_day'],
            'notes'        => $post['notes'],
        ];

        // Atualiza os dados usando o Model
        $this->monthlyPayerModel->update($id, $dataToUpdate);

        // Redireciona para a página de listagem com mensagem de sucesso
        return redirect()->to(url_to('admin_mensalistas'))->with('success', 'Mensalista atualizado com sucesso!');
    }

    /**
     * Deleta um mensalista do banco de dados (exclusão física).
     * @param int $id ID do mensalista a ser deletado
     */
    public function delete($id)
    {
        $this->monthlyPayerModel->delete($id);
        return redirect()->to(url_to('admin_mensalistas'))->with('success', 'Mensalista removido com sucesso!');
    }
}