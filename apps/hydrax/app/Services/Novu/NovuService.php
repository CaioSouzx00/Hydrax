<?php

namespace App\Services\Novu;

use Illuminate\Support\Facades\Log;
use novu\Novu;
use novu\Models\Components;

class NovuService
{
    protected Novu $novu;

    public function __construct()
    {
        $this->novu = Novu::builder()
            ->setSecurity(config('novu.api_key'))
            ->build();
    }

    /**
     * Trigger a Novu workflow event
     *
     * @param string $workflowKey
     * @param string $subscriberId
     * @param string $email
     * @param array $payload
     * @param array $subscriberData
     * @return array
     */
    public function triggerEvent(string $workflowKey, string $subscriberId, string $email, array $payload = [], array $subscriberData = []): array
    {
        try {
            $workflowId = config("novu.workflows.{$workflowKey}", $workflowKey);

            $subscriberPayload = new Components\SubscriberPayloadDto(
                subscriberId: $subscriberId,
                email: $email,
                firstName: $subscriberData['first_name'] ?? null,
                lastName: $subscriberData['last_name'] ?? null,
            );

            $triggerEventRequestDto = new Components\TriggerEventRequestDto(
                workflowId: $workflowId,
                to: $subscriberPayload,
                payload: $payload,
            );

            $response = $this->novu->trigger(
                triggerEventRequestDto: $triggerEventRequestDto,
                idempotencyKey: uniqid('novu_', true)
            );

            if ($response->triggerEventResponseDto !== null) {
                Log::info("Novu event triggered successfully", [
                    'workflow' => $workflowKey,
                    'subscriber_id' => $subscriberId,
                    'email' => $email,
                ]);

                return [
                    'success' => true,
                    'data' => $response->triggerEventResponseDto
                ];
            }

            Log::error("Novu event trigger failed", [
                'workflow' => $workflowKey,
                'subscriber_id' => $subscriberId,
                'email' => $email,
            ]);

            return [
                'success' => false,
                'error' => 'No response from Novu'
            ];

        } catch (\Exception $e) {
            Log::error("Novu event trigger exception", [
                'workflow' => $workflowKey,
                'subscriber_id' => $subscriberId,
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send email change confirmation
     *
     * @param string $subscriberId
     * @param string $email
     * @param string $userName
     * @param string $token
     * @param string $confirmationLink
     * @return array
     */
    public function sendEmailChangeConfirmation(string $subscriberId, string $email, string $userName, string $token, string $confirmationLink): array
    {
        return $this->triggerEvent(
            workflowKey: 'email_change_confirmation',
            subscriberId: $subscriberId,
            email: $email,
            payload: [
                'user_name' => $userName,
                'token' => $token,
                'confirmation_link' => $confirmationLink,
            ],
            subscriberData: [
                'first_name' => explode(' ', $userName)[0] ?? $userName,
            ]
        );
    }

    /**
     * Send abandoned cart email
     *
     * @param string $subscriberId
     * @param string $email
     * @param string $userName
     * @param array $cartItems
     * @return array
     */
    public function sendCarrinhoAbandonado(string $subscriberId, string $email, string $userName, array $cartItems): array
    {
        return $this->triggerEvent(
            workflowKey: 'carrinho_abandonado',
            subscriberId: $subscriberId,
            email: $email,
            payload: [
                'user_name' => $userName,
                'cart_items' => $cartItems,
                'cart_count' => count($cartItems),
            ],
            subscriberData: [
                'first_name' => explode(' ', $userName)[0] ?? $userName,
            ]
        );
    }

    /**
     * Send PIX key email
     *
     * @param string $subscriberId
     * @param string $email
     * @param string $userName
     * @param string $chavePix
     * @param float $total
     * @return array
     */
    public function sendChavePix(string $subscriberId, string $email, string $userName, string $chavePix, float $total): array
    {
        return $this->triggerEvent(
            workflowKey: 'chave_pix',
            subscriberId: $subscriberId,
            email: $email,
            payload: [
                'user_name' => $userName,
                'chave_pix' => $chavePix,
                'total' => number_format($total, 2, ',', '.'),
            ],
            subscriberData: [
                'first_name' => explode(' ', $userName)[0] ?? $userName,
            ]
        );
    }

    /**
     * Send verification code email
     *
     * @param string $subscriberId
     * @param string $email
     * @param string $codigo
     * @return array
     */
    public function sendCodigoVerificacao(string $subscriberId, string $email, string $codigo): array
    {
        return $this->triggerEvent(
            workflowKey: 'codigo_verificacao',
            subscriberId: $subscriberId,
            email: $email,
            payload: [
                'codigo' => $codigo,
            ]
        );
    }

    /**
     * Send supplier approval email
     *
     * @param string $subscriberId
     * @param string $email
     * @param string $fornecedorName
     * @return array
     */
    public function sendFornecedorAprovado(string $subscriberId, string $email, string $fornecedorName): array
    {
        return $this->triggerEvent(
            workflowKey: 'fornecedor_aprovado',
            subscriberId: $subscriberId,
            email: $email,
            payload: [
                'fornecedor_name' => $fornecedorName,
            ],
            subscriberData: [
                'first_name' => explode(' ', $fornecedorName)[0] ?? $fornecedorName,
            ]
        );
    }

    /**
     * Send supplier rejection email
     *
     * @param string $subscriberId
     * @param string $email
     * @param string $fornecedorName
     * @return array
     */
    public function sendFornecedorRejeitado(string $subscriberId, string $email, string $fornecedorName): array
    {
        return $this->triggerEvent(
            workflowKey: 'fornecedor_rejeitado',
            subscriberId: $subscriberId,
            email: $email,
            payload: [
                'fornecedor_name' => $fornecedorName,
            ],
            subscriberData: [
                'first_name' => explode(' ', $fornecedorName)[0] ?? $fornecedorName,
            ]
        );
    }

    /**
     * Send order status update email
     *
     * @param string $subscriberId
     * @param string $email
     * @param string $userName
     * @param int $pedidoId
     * @param string $status
     * @return array
     */
    public function sendPedidoAtualizado(string $subscriberId, string $email, string $userName, int $pedidoId, string $status): array
    {
        return $this->triggerEvent(
            workflowKey: 'pedido_atualizado',
            subscriberId: $subscriberId,
            email: $email,
            payload: [
                'user_name' => $userName,
                'pedido_id' => $pedidoId,
                'status' => strtoupper($status),
            ],
            subscriberData: [
                'first_name' => explode(' ', $userName)[0] ?? $userName,
            ]
        );
    }
}
