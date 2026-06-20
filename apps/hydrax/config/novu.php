<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Novu API Key
    |--------------------------------------------------------------------------
    |
    | The Novu API key gives you access to Novu's API. The "api_key" is
    | typically used to make a request to the API.
    |
    */
    'api_key' => env('NOVU_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Novu API URL
    |--------------------------------------------------------------------------
    |
    | The Novu API URL can be a self-hosted Novu API or Novu's cloud API.
    | Typically used to make a request to Novu's service.
    |
    */
    'api_url' => env('NOVU_API_URL', 'https://api.novu.co/v1/'),

    /*
    |--------------------------------------------------------------------------
    | Novu Workflow Identifiers
    |--------------------------------------------------------------------------
    |
    | Map your email types to Novu workflow identifiers.
    | These should match the workflow IDs created in your Novu dashboard.
    |
    */
    'workflows' => [
        'email_change_confirmation' => env('NOVU_WORKFLOW_EMAIL_CHANGE', 'email-change-confirmation'),
        'carrinho_abandonado' => env('NOVU_WORKFLOW_CARRINHO_ABANDONADO', 'carrinho-abandonado'),
        'chave_pix' => env('NOVU_WORKFLOW_CHAVE_PIX', 'chave-pix'),
        'codigo_verificacao' => env('NOVU_WORKFLOW_CODIGO_VERIFICACAO', 'codigo-verificacao'),
        'fornecedor_aprovado' => env('NOVU_WORKFLOW_FORNECEDOR_APROVADO', 'fornecedor-aprovado'),
        'fornecedor_rejeitado' => env('NOVU_WORKFLOW_FORNECEDOR_REJEITADO', 'fornecedor-rejeitado'),
        'pedido_atualizado' => env('NOVU_WORKFLOW_PEDIDO_ATUALIZADO', 'pedido-atualizado'),
    ],
];
