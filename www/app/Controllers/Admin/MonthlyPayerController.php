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
        $rules = [
            'first_name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'    => 'O campo Nome é obrigatório.',
                    'min_length'  => 'O campo Nome deve ter no mínimo 3 caracteres.',
                    'max_length'  => 'O campo Nome deve ter no máximo 100 caracteres.',
                ],
            ],
            'last_name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'    => 'O campo Sobrenome é obrigatório.',
                    'min_length'  => 'O campo Sobrenome deve ter no mínimo 3 caracteres.',
                    'max_length'  => 'O campo Sobrenome deve ter no máximo 100 caracteres.',
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
                    'is_unique'    => 'Este CPF já está em uso.',
                ],
            ],
            'rg' => [
                'rules' => 'required|max_length[20]|is_unique[monthly_payers.rg]',
                'errors' => [
                    'required'    => 'O campo RG é obrigatório.',
                    'max_length'  => 'O RG deve ter no máximo 20 caracteres.',
                    'is_unique'   => 'Este RG já está em uso.',
                ],
            ],
            'email' => [
                'rules' => 'required|valid_email|max_length[100]|is_unique[monthly_payers.email]',
                'errors' => [
                    'required'    => 'O campo Email é obrigatório.',
                    'valid_email' => 'Informe um endereço de email válido.',
                    'max_length'  => 'O Email deve ter no máximo 100 caracteres.',
                    'is_unique'   => 'Este email já está em uso.',
                ],
            ],
            'phone' => [
                'rules' => 'required|max_length[20]',
                'errors' => [
                    'required'   => 'O campo Telefone é obrigatório.',
                    'max_length' => 'O Telefone deve ter no máximo 20 caracteres.',
                ],
            ],
            'zip_code' => [
                'rules' => 'required|exact_length[9]',
                'errors' => [
                    'required'     => 'O campo CEP é obrigatório.',
                    'exact_length' => 'O CEP deve ter o formato 00000-000.',
                ],
            ],
            'street' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required'   => 'O campo Endereço é obrigatório.',
                    'max_length' => 'O Endereço deve ter no máximo 255 caracteres.',
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
                    'alpha_numeric_punct' => 'A Placa do Veículo só pode conter letras, números e traços.',
                    'max_length'          => 'A Placa do Veículo deve ter no máximo 10 caracteres.',
                    'is_unique'           => 'Esta placa já está cadastrada.',
                ],
            ],
            'vehicle_type' => [
                'rules' => 'required|in_list[carro,moto,outro]',
                'errors' => [
                    'required' => 'O campo Tipo de Veículo é obrigatório.',
                    'in_list'  => 'Tipo de Veículo inválido.',
                ],
            ],
            'active' => [
                'rules' => 'required|in_list[0,1]',
                'errors' => [
                    'required' => 'O campo Ativo é obrigatório.',
                    'in_list'  => 'Valor inválido para o campo Ativo.',
                ],
            ],
            'due_day' => [
                'rules' => 'required|integer|greater_than[0]|less_than[32]',
                'errors' => [
                    'required'      => 'O campo Vencimento é obrigatório.',
                    'integer'       => 'O Vencimento deve ser um número inteiro.',
                    'greater_than'  => 'O Vencimento deve ser maior que 0.',
                    'less_than'     => 'O Vencimento deve ser menor que 32.',
                ],
            ],
            'notes' => [
                'rules' => 'permit_empty|max_length[65535]',
                'errors' => [
                    'max_length' => 'O campo Observações é muito longo.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $post = $this->request->getPost();

        // Remove máscara do CPF
        $cpf = preg_replace('/\D/', '', $post['cpf']);

        $data = [
            'first_name'    => $post['first_name'],
            'last_name'     => $post['last_name'],
            'birth_date'    => $post['birth_date'],
            'cpf'           => $cpf,
            'rg'            => $post['rg'],
            'email'         => $post['email'],
            'phone'         => $post['phone'],
            'zip_code'      => $post['zip_code'],
            'street'        => $post['street'],
            'number'        => $post['number'],
            'neighborhood'  => $post['neighborhood'],
            'city'          => $post['city'],
            'state'         => strtoupper($post['state']),
            'complement'    => $post['complement'],
            'vehicle_plate' => strtoupper($post['vehicle_plate']),
            'vehicle_type'  => $post['vehicle_type'],
            'active'        => $post['active'],
            'due_day'       => $post['due_day'],
            'notes'         => $post['notes'],
        ];

        $this->monthlyPayerModel->save($data);

        return redirect()->to(url_to('admin_mensalistas'))->with('success', 'Mensalista cadastrado com sucesso!');
    }
}
