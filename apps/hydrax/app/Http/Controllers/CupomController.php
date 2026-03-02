<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cupom\StoreCupomRequest;
use App\Http\Requests\Cupom\UpdateCupomRequest;
use App\Models\Cupom;
use Illuminate\Http\Request;

/**
 * Controller responsável pelas operações relacionadas a cupons.
 * 
 * Refatorado seguindo Clean Code e SOLID:
 * - Validações movidas para Form Requests
 * - Controller mantém apenas orquestração e respostas HTTP
 */
class CupomController extends Controller
{
    /**
     * Lista todos os cupons.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cupons = Cupom::orderBy('created_at', 'desc')->get();
        return view('admin.cupons.index', compact('cupons'));
    }

    /**
     * Exibe o formulário de criação de cupom.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.cupons.create');
    }

    /**
     * Armazena um novo cupom.
     * 
     * Validação via StoreCupomRequest.
     *
     * @param StoreCupomRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCupomRequest $request)
    {
        Cupom::create($request->validated());

        return redirect()->route('admin.cupons.index')
            ->with('success', 'Cupom criado com sucesso!');
    }

    /**
     * Exibe o formulário de edição de cupom.
     *
     * @param int $id ID do cupom
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $cupom = Cupom::findOrFail($id);
        return view('admin.cupons.edit', compact('cupom'));
    }

    /**
     * Atualiza um cupom existente.
     * 
     * Validação via UpdateCupomRequest.
     *
     * @param UpdateCupomRequest $request
     * @param int $id ID do cupom
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCupomRequest $request, $id)
    {
        $cupom = Cupom::findOrFail($id);
        $cupom->update($request->validated());

        return redirect()->route('admin.cupons.index')
            ->with('success', 'Cupom atualizado com sucesso!');
    }

    /**
     * Exclui um cupom.
     *
     * @param int $id ID do cupom
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $cupom = Cupom::findOrFail($id);
        $cupom->delete();

        return redirect()->route('admin.cupons.index')
            ->with('success', 'Cupom deletado com sucesso!');
    }
}
