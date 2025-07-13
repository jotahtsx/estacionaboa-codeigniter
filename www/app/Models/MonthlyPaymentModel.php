<?php

namespace App\Models;

use CodeIgniter\Model;

class MonthlyPaymentModel extends Model
{
    protected $table = 'monthly_payments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $allowedFields = [
        'monthly_payer_id',
        'pricing_id',
        'due_day',
        'amount',
        'due_date',
        'payment_date',
        'status',
        'payment_method',
        'notes',
        'active',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validações para uso direto com ->insert() ou ->update()
    protected $validationRules = [
        'monthly_payer_id' => 'required|integer',
        'pricing_id'       => 'required|integer',
        'due_day'          => 'required|integer|greater_than[0]|less_than_equal_to[31]',
        'amount'           => 'required|decimal',
        'due_date'         => 'required|valid_date[Y-m-d]',
        'payment_date'     => 'permit_empty|valid_date[Y-m-d]',
        'status'           => 'required|in_list[pendente,pago,atrasado]',
        'active'           => 'required|in_list[0,1]',
    ];

    protected $validationMessages = [
        'monthly_payer_id' => [
            'required' => 'O ID do mensalista é obrigatório.',
            'integer'  => 'O ID do mensalista deve ser um número inteiro.',
        ],
        'pricing_id' => [
            'required' => 'O ID da precificação é obrigatório.',
            'integer'  => 'O ID da precificação deve ser um número inteiro.',
        ],
        'due_day' => [
            'required'           => 'O dia de vencimento é obrigatório.',
            'integer'            => 'O dia de vencimento deve ser um número.',
            'greater_than'       => 'O vencimento deve ser maior que 0.',
            'less_than_equal_to' => 'O vencimento deve ser no máximo 31.',
        ],
        'amount' => [
            'required' => 'O valor é obrigatório.',
            'decimal'  => 'O valor deve ser um número decimal.',
        ],
        'due_date' => [
            'required'   => 'A data de vencimento é obrigatória.',
            'valid_date' => 'A data de vencimento deve estar no formato YYYY-MM-DD.',
        ],
        'payment_date' => [
            'valid_date' => 'A data de pagamento deve estar no formato YYYY-MM-DD.',
        ],
        'status' => [
            'required' => 'O status é obrigatório.',
            'in_list'  => 'Status inválido.',
        ],
        'active' => [
            'required' => 'O campo ativo é obrigatório.',
            'in_list'  => 'O campo ativo deve ser 0 ou 1.',
        ],
    ];

    // Métodos de apoio (caso queira buscar os relacionados no controller ou view)
    public function getMonthlyPayer($monthlyPayerId)
    {
        return model('MonthlyPayerModel')->find($monthlyPayerId);
    }

    public function getPricing($pricingId)
    {
        return model('PricingModel')->find($pricingId);
    }
}
