# Novu.co Email Migration Guide

This document explains the migration from Brevo (Sendinblue) to Novu.co for email sending in the Hydrax project.

## Overview

The project has been successfully migrated from Brevo's SMTP service to Novu.co's notification platform. All email sending functionality now uses Novu's API through a custom service.

## Changes Made

### 1. Installed Novu PHP SDK
```bash
composer require novuhq/novu
```

### 2. Created Novu Configuration
- **File**: `apps/hydrax/config/novu.php`
- Contains API key configuration and workflow identifiers for all email types

### 3. Created Novu Service
- **File**: `apps/hydrax/app/Services/Novu/NovuService.php`
- Centralized service for all Novu API calls
- Methods for each email type:
  - `sendEmailChangeConfirmation()` - Email change verification
  - `sendCarrinhoAbandonado()` - Abandoned cart emails
  - `sendChavePix()` - PIX payment key emails
  - `sendCodigoVerificacao()` - Verification code emails
  - `sendFornecedorAprovado()` - Supplier approval emails
  - `sendFornecedorRejeitado()` - Supplier rejection emails
  - `sendPedidoAtualizado()` - Order status update emails

### 4. Updated All Email Calls
Replaced all `Mail::to()` calls with Novu service calls in:
- `app/Services/Usuario/UsuarioService.php`
- `app/Jobs/EnviarCarrinhoAbandonadoJob.php`
- `app/Services/Carrinho/CarrinhoService.php`
- `app/Http/Controllers/CarrinhoController.php`
- `app/Http/Controllers/FornecedorController.php`
- `app/Http/Controllers/SenhaUsuarioController.php`
- `app/Http/Controllers/AdminController.php`

### 5. Updated Environment Configuration
Added Novu configuration to `.env.example`:
```env
NOVU_API_KEY=your_novu_api_key_here
NOVU_API_URL=https://api.novu.co/v1/
NOVU_WORKFLOW_EMAIL_CHANGE=email-change-confirmation
NOVU_WORKFLOW_CARRINHO_ABANDONADO=carrinho-abandonado
NOVU_WORKFLOW_CHAVE_PIX=chave-pix
NOVU_WORKFLOW_CODIGO_VERIFICACAO=codigo-verificacao
NOVU_WORKFLOW_FORNECEDOR_APROVADO=fornecedor-aprovado
NOVU_WORKFLOW_FORNECEDOR_REJEITADO=fornecedor-rejeitado
NOVU_WORKFLOW_PEDIDO_ATUALIZADO=pedido-atualizado
```

## Setup Instructions

### 1. Create a Novu Account
1. Go to [https://novu.co](https://novu.co) and sign up
2. Create a new project
3. Navigate to Settings → API Keys
4. Copy your API Key

### 2. Configure Email Provider in Novu
1. In Novu dashboard, go to Integrations
2. Add your email provider (SMTP, SendGrid, AWS SES, etc.)
3. Configure the provider with your credentials

### 3. Create Email Workflows
For each email type, create a workflow in Novu:

#### Workflow Identifiers:
- `email-change-confirmation` - Email change confirmation
- `carrinho-abandonado` - Abandoned cart reminder
- `chave-pix` - PIX payment key
- `codigo-verificacao` - Verification code
- `fornecedor-aprovado` - Supplier approval
- `fornecedor-rejeitado` - Supplier rejection
- `pedido-atualizado` - Order status update

#### For each workflow:
1. Go to Workflows → Create Workflow
2. Set the workflow identifier (matching the config)
3. Add an email step
4. Design your email template using Novu's editor
5. Add the required data variables (payload fields)

#### Required Payload Variables:
- **Email Change**: `user_name`, `token`, `confirmation_link`
- **Abandoned Cart**: `user_name`, `cart_items` (array), `cart_count`
- **PIX Key**: `user_name`, `chave_pix`, `total`
- **Verification Code**: `codigo`
- **Supplier Approved**: `fornecedor_name`
- **Supplier Rejected**: `fornecedor_name`
- **Order Updated**: `user_name`, `pedido_id`, `status`

### 4. Update Environment Variables
Add your Novu API key to your `.env` file:
```env
NOVU_API_KEY=your_actual_novu_api_key
```

Update workflow identifiers if you used different names in Novu:
```env
NOVU_WORKFLOW_EMAIL_CHANGE=your-workflow-id
# ... etc for other workflows
```

### 5. Test the Integration
Run the test command:
```bash
php artisan novu:test your-email@example.com
```

This will send a test verification code email to verify the integration is working.

## Testing Email Flows

### Manual Testing
1. **Email Change Confirmation**: Try changing your email in the user profile
2. **Abandoned Cart**: Add items to cart and wait for the scheduled job (1 minute)
3. **PIX Key**: Complete a purchase and check for PIX email
4. **Verification Code**: Request a password change verification code
5. **Supplier Approval**: As admin, approve a pending supplier
6. **Supplier Rejection**: As admin, reject a pending supplier
7. **Order Update**: As admin, update an order status

### Using the Test Command
```bash
# Test with your email
php artisan novu:test caionk03@gmail.com
```

## Troubleshooting

### Common Issues

**1. API Key Error**
- Ensure `NOVU_API_KEY` is set correctly in `.env`
- Check that the API key is valid and active in Novu dashboard

**2. Workflow Not Found**
- Verify workflow identifiers match between `.env` and Novu dashboard
- Check that workflows are active in Novu

**3. Email Not Sending**
- Verify your email provider is configured in Novu Integrations
- Check Novu's activity feed for error messages
- Ensure subscriber data is being passed correctly

**4. Missing Variables in Email**
- Check that your Novu email templates include all required payload variables
- Verify variable names match between code and Novu templates

### Debug Mode
The NovuService logs all API calls to Laravel's log file. Check:
```bash
tail -f storage/logs/laravel.log
```

## Rollback Plan

If you need to rollback to Brevo:

1. Revert the service files to use `Mail::to()` with original Mailable classes
2. Remove Novu configuration and service
3. Restore original `.env` MAIL configuration
4. Remove Novu SDK: `composer remove novuhq/novu`

## Additional Resources

- [Novu Documentation](https://docs.novu.co)
- [Novu PHP SDK](https://github.com/novuhq/php-novu)
- [Novu Dashboard](https://app.novu.co)

## Support

For issues specific to this migration, check the Laravel logs and Novu activity feed.
