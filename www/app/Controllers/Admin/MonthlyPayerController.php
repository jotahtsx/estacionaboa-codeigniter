<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MonthlyPayerModel;

/**
 * @property \CodeIgniter\HTTP\IncomingRequest $request
 */
class MonthlyPayerController extends BaseController
{
    protected $monthlyPayerModel;

    public function __construct()
    {
        $this->monthlyPayerModel = new MonthlyPayerModel();
    }

    public function index()
    {
        $data = [
            'titlePage'     => 'Mensalistas',
            'active_page'   => 'mensalistas',
            'monthlyPayers' => $this->monthlyPayerModel->findAll(),
        ];

        return view('admin/monthly_payers/index', $data);
    }

    public function create()
    {
        $data = [
            'titlePage'   => 'Cadastrar Mensalista',
            'active_page' => 'mensalistas',
        ];

        return view('admin/monthly_payers/create', $data);
    }

        public function store()
    {
    $post = $this->request->getPost();

    $post['cpf']           = isset($post['cpf']) ? preg_replace('/\D/', '', $post['cpf']) : '';
    $post['vehicle_plate'] = isset($post['vehicle_plate']) ? strtoupper($post['vehicle_plate']) : '';
    $post['state']         = isset($post['state']) ? strtoupper($post['state']) : '';

    $rules = [
        'first_name' => [
            'rules' => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required'   => 'O campo Nome é obrigatório.',
                'min_length' => 'O Nome deve ter no mínimo 3 caracteres.',
                'max_length' => 'O Nome deve ter no máximo 100 caracteres.',
            ],
        ],
        'last_name' => [
            'rules' => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required'   => 'O campo Sobrenome é obrigatório.',
                'min_length' => 'O Sobrenome deve ter no mínimo 3 caracteres.',
                'max_length' => 'O Sobrenome deve ter no máximo 100 caracteres.',
            ],
        ],
        'birth_date' => [
            'rules' => 'required|valid_date[Y-m-d]',
            'errors' => [
                'required'   => 'O campo Data de Nascimento é obrigatório.',
                'valid_date' => 'A Data de Nascimento deve estar no formato AAAA-MM-DD.',
            ],
        ],
        'cpf' => [
            'rules' => 'required|exact_length[11]|is_unique[monthly_payers.cpf]',
            'errors' => [
                'required'     => 'O campo CPF é obrigatório.',
                'exact_length' => 'O CPF deve conter exatamente 11 dígitos (sem pontos ou traços).',
                'is_unique'    => 'Este CPF já está em uso.', // <- esta mensagem deve funcionar
            ],
        ],
        'rg' => 'required|max_length[20]|is_unique[monthly_payers.rg]',
        'email' => 'required|valid_email|max_length[100]|is_unique[monthly_payers.email]',
        'phone' => [
            'rules' => 'required|max_length[20]',
            'errors' => [
                'required'   => 'O campo Telefone é obrigatório.',
                'max_length' => 'O campo Telefone deve ter no máximo 20 caracteres.',
            ],
        ],
        'zip_code' => [
            'rules' => 'required|exact_length[9]',
            'errors' => [
                'required'     => 'O campo CEP é obrigatório.',
                'exact_length' => 'O CEP deve ter exatamente 9 caracteres (formato: 00000-000).',
            ],
        ],
        'street' => [
            'rules' => 'required|max_length[255]',
            'errors' => [
                'required'   => 'O campo Rua é obrigatório.',
                'max_length' => 'A Rua deve ter no máximo 255 caracteres.',
            ],
        ],
        'number' => [
            'rules' => 'required|max_length[20]',
            'errors' => [
                'required'   => 'O campo Número é obrigatório.',
                'max_length' => 'O Número deve ter no máximo 20 caracteres.',
            ],
        ],
        'neighborhood' => [
            'rules' => 'required|max_length[100]',
            'errors' => [
                'required'   => 'O campo Bairro é obrigatório.',
                'max_length' => 'O Bairro deve ter no máximo 100 caracteres.',
            ],
        ],
        'city' => [
            'rules' => 'required|max_length[100]',
            'errors' => [
                'required'   => 'O campo Cidade é obrigatório.',
                'max_length' => 'A Cidade deve ter no máximo 100 caracteres.',
            ],
        ],
        'state' => [
            'rules' => 'required|exact_length[2]',
            'errors' => [
                'required'     => 'O campo Estado é obrigatório.',
                'exact_length' => 'O Estado deve ter 2 letras (ex: SP).',
            ],
        ],
        'complement' => [
            'rules' => 'permit_empty|max_length[255]',
            'errors' => [
                'max_length' => 'O Complemento deve ter no máximo 255 caracteres.',
            ],
        ],
        'vehicle_plate' => [
            'rules' => 'required|alpha_numeric_punct|max_length[10]|is_unique[monthly_payers.vehicle_plate]',
            'errors' => [
                'required'             => 'O campo Placa do Veículo é obrigatório.',
                'alpha_numeric_punct'  => 'A Placa do Veículo só pode conter letras, números e traços.',
                'max_length'           => 'A Placa do Veículo deve ter no máximo 10 caracteres.',
                'is_unique'            => 'Esta placa já está cadastrada.',
            ],
        ],
        'vehicle_type' => 'required|in_list[carro,moto,outro]',
        'active' => 'required|in_list[0,1]',
        'due_day' => [
            'rules' => 'required|integer|greater_than[0]|less_than[32]',
            'errors' => [
                'required'      => 'O campo Vencimento é obrigatório.',
                'integer'       => 'O Vencimento deve ser um número inteiro.',
                'greater_than'  => 'O Vencimento deve ser maior que 0.',
                'less_than'     => 'O Vencimento deve ser menor que 32.',
            ],
        ],
        'notes' => 'permit_empty|max_length[65535]',
    ];
    if (! $this->validateData($post, $rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }
    $this->monthlyPayerModel->save($post);
    return redirect()->to(url_to('admin_mensalistas'))->with('success', 'Mensalista cadastrado com sucesso!');
}

    public function edit($id)
    {
        $mensalista = $this->monthlyPayerModel->find($id);

        if (!$mensalista) {
            return redirect()->to(url_to('admin_mensalistas'))->with('error', 'Mensalista não encontrado.');
        }

        $data = [
            'titlePage'   => 'Editar Mensalista',
            'active_page' => 'mensalistas',
            'mensalista'  => $mensalista,
        ];

        return view('admin/monthly_payers/edit', $data);
    }

    public function update($id)
    {
        $mensalista = $this->monthlyPayerModel->find($id);

        if (!$mensalista) {
            return redirect()->to(url_to('admin_mensalistas'))->with('error', 'Mensalista não encontrado.');
        }

        $post = $this->request->getPost();

        // Limpeza dos dados, igual no store
        $post['cpf']           = isset($post['cpf']) ? preg_replace('/\D/', '', $post['cpf']) : '';
        $post['vehicle_plate'] = isset($post['vehicle_plate']) ? strtoupper($post['vehicle_plate']) : '';
        $post['state']         = isset($post['state']) ? strtoupper($post['state']) : '';

        // Regras de validação, igual no store, mas precisamos ajustar o is_unique para ignorar o próprio registro atual
        $rules = [
            'first_name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => 'O campo Nome é obrigatório.',
                    'min_length' => 'O Nome deve ter no mínimo 3 caracteres.',
                    'max_length' => 'O Nome deve ter no máximo 100 caracteres.',
                ],
            ],
            'last_name' => 'required|min_length[3]|max_length[100]',
            'birth_date' => 'required|valid_date[Y-m-d]',
            // Aqui, o is_unique deve ignorar o registro atual pelo id:
            'cpf' => "required|exact_length[11]|is_unique[monthly_payers.cpf,id,{$id}]",
            'rg' => "required|max_length[20]|is_unique[monthly_payers.rg,id,{$id}]",
            'email' => "required|valid_email|max_length[100]|is_unique[monthly_payers.email,id,{$id}]",
            'phone' => 'required|max_length[20]',
            'zip_code' => 'required|exact_length[9]',
            'street' => 'required|max_length[255]',
            'number' => 'required|max_length[20]',
            'neighborhood' => 'required|max_length[100]',
            'city' => 'required|max_length[100]',
            'state' => 'required|exact_length[2]',
            'complement' => 'permit_empty|max_length[255]',
            'vehicle_plate' => "required|alpha_numeric_punct|max_length[10]|is_unique[monthly_payers.vehicle_plate,id,{$id}]",
            'vehicle_type' => 'required|in_list[carro,moto,outro]',
            'active' => 'required|in_list[0,1]',
            'due_day' => 'required|integer|greater_than[0]|less_than[32]',
            'notes' => 'permit_empty|max_length[65535]',
        ];

        if (! $this->validateData($post, $rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $post['id'] = $id; // garantir que o save atualize

        $this->monthlyPayerModel->save($post);

        return redirect()->to(url_to('admin_mensalistas'))->with('success', 'Mensalista atualizado com sucesso!');
    }

    public function delete($id)
    {
        $mensalista = $this->monthlyPayerModel->find($id);

        if (! $mensalista) {
            return redirect()->to(url_to('admin_mensalistas'))->with('error', 'Mensalista não encontrado.');
        }

        $this->monthlyPayerModel->delete($id);

        return redirect()->to(url_to('admin_mensalistas'))->with('success', 'Mensalista excluído com sucesso.');
    }
}
